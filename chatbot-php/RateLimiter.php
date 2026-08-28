<?php
/**
 * Sliding-window rate limiter backed by a single JSON file.
 *
 * Guards the chat endpoint, where every accepted request costs money. The
 * window is a rolling count rather than a fixed cooldown: callers get
 * RATE_LIMIT_REQUESTS requests per RATE_LIMIT_WINDOW seconds, not one request
 * per cooldown period.
 *
 * Reads and writes are wrapped in an exclusive lock. The naive
 * read-then-write used elsewhere in this codebase loses increments when two
 * requests overlap, which on a paid endpoint means the limit can be exceeded
 * under exactly the concurrent load it exists to contain.
 */
class RateLimiter
{
    private $storePath;
    private $maxRequests;
    private $windowSeconds;

    public function __construct($storePath, $maxRequests, $windowSeconds)
    {
        $this->storePath     = $storePath;
        $this->maxRequests   = max(1, (int) $maxRequests);
        $this->windowSeconds = max(1, (int) $windowSeconds);
    }

    /**
     * Record a hit for $identifier and report whether it is allowed.
     *
     * @return array{allowed:bool, remaining:int, retryAfter:int}
     */
    public function hit($identifier, $now = null)
    {
        $now = $now === null ? time() : (int) $now;
        $key = $this->normalise($identifier);

        $dir = dirname($this->storePath);
        if (!is_dir($dir) && !@mkdir($dir, 0750, true) && !is_dir($dir)) {
            // Storage unavailable: fail open rather than take the site's
            // assistant down over a limiter that cannot persist.
            return ['allowed' => true, 'remaining' => $this->maxRequests, 'retryAfter' => 0];
        }

        $handle = @fopen($this->storePath, 'c+');
        if ($handle === false) {
            return ['allowed' => true, 'remaining' => $this->maxRequests, 'retryAfter' => 0];
        }

        if (!flock($handle, LOCK_EX)) {
            fclose($handle);
            return ['allowed' => true, 'remaining' => $this->maxRequests, 'retryAfter' => 0];
        }

        $raw  = stream_get_contents($handle);
        $data = json_decode($raw === false ? '' : $raw, true);
        if (!is_array($data)) {
            $data = [];
        }

        $cutoff = $now - $this->windowSeconds;

        // Drop expired hits for every caller, so the file cannot grow without
        // bound as one-off visitors accumulate.
        foreach ($data as $existingKey => $timestamps) {
            $kept = array_values(array_filter(
                is_array($timestamps) ? $timestamps : [],
                static function ($t) use ($cutoff) { return (int) $t > $cutoff; }
            ));

            if ($kept) {
                $data[$existingKey] = $kept;
            } else {
                unset($data[$existingKey]);
            }
        }

        $hits    = isset($data[$key]) ? $data[$key] : [];
        $allowed = count($hits) < $this->maxRequests;

        if ($allowed) {
            $hits[]      = $now;
            $data[$key]  = $hits;
            $retryAfter  = 0;
        } else {
            // Oldest hit in the window decides when capacity frees up.
            $retryAfter = max(1, ($hits[0] + $this->windowSeconds) - $now);
        }

        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, json_encode($data));
        fflush($handle);
        flock($handle, LOCK_UN);
        fclose($handle);

        return [
            'allowed'    => $allowed,
            'remaining'  => max(0, $this->maxRequests - count($hits)),
            'retryAfter' => $retryAfter,
        ];
    }

    /** Hash the identifier so the store holds no raw IP addresses. */
    private function normalise($identifier)
    {
        return substr(hash('sha256', (string) $identifier), 0, 32);
    }
}
