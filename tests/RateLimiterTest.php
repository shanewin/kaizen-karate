#!/usr/bin/env php
<?php
/**
 * Tests for RateLimiter — the sliding-window guard on the paid chat endpoint.
 *
 * Run: php tests/RateLimiterTest.php
 */

require_once __DIR__ . '/../chatbot-php/RateLimiter.php';

$passed = 0;
$failed = 0;

function check($label, $condition) {
    global $passed, $failed;
    if ($condition) { $passed++; echo "  PASS  {$label}\n"; }
    else            { $failed++; echo "  FAIL  {$label}\n"; }
}

function tmpStore() {
    return sys_get_temp_dir() . '/kaizen-rl-' . uniqid() . '/limits.txt';
}

echo "RateLimiter\n";

// --- allows up to the limit, then blocks --------------------------------
$store = tmpStore();
$rl = new RateLimiter($store, 3, 60);
$results = [];
for ($i = 0; $i < 4; $i++) { $results[] = $rl->hit('1.2.3.4', 1000); }

check('allows requests up to the limit',
    $results[0]['allowed'] && $results[1]['allowed'] && $results[2]['allowed']);
check('blocks the request past the limit', !$results[3]['allowed']);
check('reports remaining budget accurately', $results[0]['remaining'] === 2 && $results[2]['remaining'] === 0);
check('supplies a positive retryAfter when blocked', $results[3]['retryAfter'] > 0);
check('retryAfter never exceeds the window', $results[3]['retryAfter'] <= 60);

// --- window slides -------------------------------------------------------
$blockedAgain = $rl->hit('1.2.3.4', 1030);          // still inside the window
$afterExpiry  = $rl->hit('1.2.3.4', 1061);          // window has passed
check('still blocked inside the window', !$blockedAgain['allowed']);
check('allows again once the window slides past', $afterExpiry['allowed']);

// --- callers are independent ---------------------------------------------
$other = $rl->hit('9.9.9.9', 1000);
check('one caller hitting the limit does not block another', $other['allowed']);

// --- no raw IPs on disk ---------------------------------------------------
$contents = file_get_contents($store);
check('does not persist raw identifiers', strpos($contents, '1.2.3.4') === false);
check('store holds valid JSON', is_array(json_decode($contents, true)));

// --- expired entries are pruned, so the file cannot grow unbounded --------
$store2 = tmpStore();
$rl2 = new RateLimiter($store2, 5, 10);
for ($i = 0; $i < 50; $i++) { $rl2->hit("visitor-{$i}", 1000); }
$beforePrune = count(json_decode(file_get_contents($store2), true));
$rl2->hit('late-visitor', 2000);                     // far outside the window
$afterPrune = count(json_decode(file_get_contents($store2), true));
check('retains entries while they are live', $beforePrune === 50);
check('prunes expired entries for every caller', $afterPrune === 1);

// --- degrades safely ------------------------------------------------------
$unwritable = new RateLimiter('/proc/nonexistent/dir/limits.txt', 2, 60);
$r = $unwritable->hit('1.2.3.4', 1000);
check('fails open when the store is unwritable', $r['allowed'] === true);

// --- concurrency: locked read-modify-write loses no increments ------------
$store3 = tmpStore();
@mkdir(dirname($store3), 0750, true);
$children = [];
for ($i = 0; $i < 8; $i++) {
    $cmd = sprintf(
        'php -r %s > /dev/null 2>&1 &',
        escapeshellarg(sprintf(
            'require "%s"; $r = new RateLimiter("%s", 100, 60); for ($i=0;$i<10;$i++) { $r->hit("shared", time()); }',
            realpath(__DIR__ . '/../chatbot-php/RateLimiter.php'),
            $store3
        ))
    );
    exec($cmd);
}
sleep(3);
$final = json_decode(file_get_contents($store3), true);
$recorded = $final ? count(reset($final)) : 0;
check("concurrent writers lose no increments (recorded {$recorded}/80)", $recorded === 80);

echo "\n{$passed} passed, {$failed} failed\n";
exit($failed === 0 ? 0 : 1);
