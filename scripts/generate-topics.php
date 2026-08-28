#!/usr/bin/env php
<?php
/**
 * Regenerate the chatbot retrieval corpus from site-content.json.
 *
 *   php scripts/generate-topics.php          regenerate topic files
 *   php scripts/generate-topics.php --check   exit 1 if topics are stale (CI)
 *
 * The --check mode makes drift a build failure rather than a silent bug where
 * the chatbot answers from stale content.
 */

require_once __DIR__ . '/../includes/TopicProjector.php';

$contentRoot = __DIR__ . '/../data/content';
$checkOnly   = in_array('--check', $argv, true);

$projector = new TopicProjector($contentRoot);

if ($checkOnly) {
    $topicsDir = $contentRoot . '/topics';
    $before = [];
    foreach (glob($topicsDir . '/*.json') as $file) {
        $before[basename($file)] = file_get_contents($file);
    }

    // Project into a scratch dir so --check never mutates the working tree.
    $scratch = sys_get_temp_dir() . '/kaizen-topics-' . getmypid();
    mkdir($scratch . '/topics', 0755, true);
    copy($contentRoot . '/site-content.json', $scratch . '/site-content.json');
    (new TopicProjector($scratch))->project();

    $stale = [];
    foreach (glob($scratch . '/topics/*.json') as $file) {
        $name = basename($file);
        if (!isset($before[$name]) || $before[$name] !== file_get_contents($file)) {
            $stale[] = $name;
        }
        unlink($file);
    }
    rmdir($scratch . '/topics');
    unlink($scratch . '/site-content.json');
    rmdir($scratch);

    if ($stale) {
        fwrite(STDERR, "Topic files are stale (regenerate with scripts/generate-topics.php):\n");
        foreach ($stale as $name) {
            fwrite(STDERR, "  - {$name}\n");
        }
        exit(1);
    }

    echo "Topic files are in sync with site-content.json.\n";
    exit(0);
}

$result = $projector->project();

foreach ($result['written'] as $name) {
    echo "  regenerated  {$name}\n";
}
foreach ($result['skipped'] as $name) {
    echo "  skipped      {$name} (no matching sections)\n";
}
foreach ($result['errors'] as $error) {
    fwrite(STDERR, "  ERROR        {$error}\n");
}

$uncovered = $projector->verifyCoverage();
if ($uncovered) {
    fwrite(STDERR, "\nWarning: sections not exposed to the chatbot: "
        . implode(', ', $uncovered) . "\n");
}

exit(empty($result['errors']) ? 0 : 1);
