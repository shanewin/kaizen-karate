<?php
/**
 * TopicProjector — derives the chatbot's retrieval corpus from site content.
 *
 * The admin CMS publishes a single authoritative document, site-content.json.
 * The chatbot's retrieval layer (chatbot-php/SmartDataLoader.php) reads
 * topic-scoped files so a query loads only the relevant slice of the corpus
 * instead of the whole document.
 *
 * Those topic files are PROJECTIONS, not a second source of truth: they are
 * regenerated from site-content.json on every publish. Editing them by hand is
 * meaningless — the next publish overwrites them.
 *
 * Adding a topic is a one-line change to TOPIC_MAP below.
 */
class TopicProjector
{
    /**
     * topic filename => sections of site-content.json it projects.
     * Every section should appear in at least one topic, or the chatbot cannot
     * answer questions about it. See verifyCoverage().
     */
    const TOPIC_MAP = [
        'general.json' => [
            'site_info', 'hero_section', 'navigation',
            'about_section', 'service_areas', 'online_store', 'footer',
        ],
        'programs.json'     => ['programs', 'after_school', 'kaizen_dojo'],
        'belt_exams.json'   => ['belt_exams'],
        'kaizen_kenpo.json' => ['kaizen_kenpo'],
        'summer_camp.json'  => ['summer_camp'],
        'policies.json'     => ['policies_page'],
        'locations.json'    => ['nyc_section'],
    ];

    /** Sections deliberately withheld: presentational only, no answerable facts. */
    const EXCLUDED = ['homepage_popup'];

    /**
     * Field names pruned from projections at any depth.
     *
     * These carry rendered HTML for the website UI, not facts the assistant
     * needs. `lightbox_content` alone is ~104KB of belt-curriculum markup —
     * projecting it raised a single belt query from ~3k to ~15k input tokens
     * for no gain in answer quality, since the same facts are already present
     * in the sibling summary fields. Retrieval stays cheap; the site still
     * renders from site-content.json, which is untouched.
     */
    const PRUNED_FIELDS = ['lightbox_content', 'lightboxes'];

    private $contentRoot;
    private $topicsDir;

    public function __construct($contentRoot)
    {
        $this->contentRoot = rtrim($contentRoot, '/');
        $this->topicsDir   = $this->contentRoot . '/topics';
    }

    /**
     * Regenerate every topic file from site-content.json.
     *
     * @return array{written: string[], skipped: string[], errors: string[]}
     */
    public function project()
    {
        $result = ['written' => [], 'skipped' => [], 'errors' => []];

        $sourcePath = $this->contentRoot . '/site-content.json';
        if (!is_file($sourcePath)) {
            $result['errors'][] = "Source not found: {$sourcePath}";
            return $result;
        }

        $site = json_decode(file_get_contents($sourcePath), true);
        if (!is_array($site)) {
            $result['errors'][] = 'site-content.json is not valid JSON: ' . json_last_error_msg();
            return $result;
        }

        if (!is_dir($this->topicsDir) && !mkdir($this->topicsDir, 0755, true)) {
            $result['errors'][] = "Cannot create {$this->topicsDir}";
            return $result;
        }

        foreach (self::TOPIC_MAP as $filename => $sections) {
            $slice = [];
            foreach ($sections as $section) {
                if (isset($site[$section])) {
                    $slice[$section] = $this->prune($site[$section]);
                }
            }

            if (empty($slice)) {
                $result['skipped'][] = $filename;
                continue;
            }

            if ($this->writeAtomic($this->topicsDir . '/' . $filename, $slice)) {
                $result['written'][] = $filename;
            } else {
                $result['errors'][] = "Failed to write {$filename}";
            }
        }

        return $result;
    }

    /**
     * Report sections of site-content.json that no topic exposes. A section
     * listed here is invisible to the chatbot — it will not be able to answer
     * questions about that part of the site.
     *
     * @return string[]
     */
    public function verifyCoverage()
    {
        $sourcePath = $this->contentRoot . '/site-content.json';
        if (!is_file($sourcePath)) {
            return [];
        }

        $site = json_decode(file_get_contents($sourcePath), true) ?: [];

        $covered = [];
        foreach (self::TOPIC_MAP as $sections) {
            foreach ($sections as $section) {
                $covered[$section] = true;
            }
        }
        foreach (self::EXCLUDED as $section) {
            $covered[$section] = true;
        }

        return array_values(array_diff(array_keys($site), array_keys($covered)));
    }

    /**
     * Recursively drop PRUNED_FIELDS so heavy presentational markup never
     * reaches the retrieval corpus.
     */
    private function prune($value)
    {
        if (!is_array($value)) {
            return $value;
        }

        $out = [];
        foreach ($value as $key => $child) {
            if (is_string($key) && in_array($key, self::PRUNED_FIELDS, true)) {
                continue;
            }
            $out[$key] = $this->prune($child);
        }

        return $out;
    }

    /**
     * Write via temp file + rename so a concurrent read never observes a
     * half-written topic file.
     */
    private function writeAtomic($path, array $data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return false;
        }

        $tmp = $path . '.tmp';
        if (file_put_contents($tmp, $json, LOCK_EX) === false) {
            return false;
        }

        if (!rename($tmp, $path)) {
            @unlink($tmp);
            return false;
        }

        return true;
    }
}
