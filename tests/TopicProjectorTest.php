#!/usr/bin/env php
<?php
/**
 * Tests for TopicProjector — the projection step that keeps the chatbot's
 * retrieval corpus derived from site-content.json rather than maintained
 * alongside it.
 *
 * Run: php tests/TopicProjectorTest.php
 */

require_once __DIR__ . '/../includes/TopicProjector.php';

$passed = 0;
$failed = 0;

function check($label, $condition) {
    global $passed, $failed;
    if ($condition) {
        $passed++;
        echo "  PASS  {$label}\n";
    } else {
        $failed++;
        echo "  FAIL  {$label}\n";
    }
}

/** Build an isolated content root with a synthetic site-content.json. */
function makeFixture(array $site) {
    $dir = sys_get_temp_dir() . '/kaizen-test-' . uniqid();
    mkdir($dir . '/topics', 0755, true);
    file_put_contents($dir . '/site-content.json', json_encode($site));
    return $dir;
}

function cleanup($dir) {
    foreach (glob($dir . '/topics/*') as $f) { unlink($f); }
    @rmdir($dir . '/topics');
    foreach (glob($dir . '/*') as $f) { unlink($f); }
    @rmdir($dir);
}

echo "TopicProjector\n";

// --- projection produces the mapped slice ---------------------------------
$dir = makeFixture([
    'site_info'  => ['name' => 'Kaizen Karate'],
    'belt_exams' => ['hero' => ['title' => 'Belt Exams']],
]);
$result = (new TopicProjector($dir))->project();

check('writes a topic file for a mapped section', in_array('belt_exams.json', $result['written'], true));
check('reports no errors on a valid source', empty($result['errors']));

$belt = json_decode(file_get_contents($dir . '/topics/belt_exams.json'), true);
check('projected content matches the source exactly', $belt === ['belt_exams' => ['hero' => ['title' => 'Belt Exams']]]);

$general = json_decode(file_get_contents($dir . '/topics/general.json'), true);
check('general.json carries site_info', isset($general['site_info']['name']));
check('unmapped sections are skipped, not invented', !in_array('summer_camp.json', $result['written'], true));
cleanup($dir);

// --- pruning ---------------------------------------------------------------
$dir = makeFixture([
    'belt_exams' => [
        'accordions' => [
            ['id' => 'scripts', 'title' => 'Scripts', 'lightbox_content' => str_repeat('x', 5000)],
        ],
    ],
]);
(new TopicProjector($dir))->project();
$belt = json_decode(file_get_contents($dir . '/topics/belt_exams.json'), true);
$acc  = $belt['belt_exams']['accordions'][0];

check('prunes heavy presentational fields at depth', !isset($acc['lightbox_content']));
check('preserves sibling fields while pruning', $acc['title'] === 'Scripts');
cleanup($dir);

// --- projection is deterministic -------------------------------------------
$dir = makeFixture(['site_info' => ['name' => 'Kaizen'], 'programs' => ['a' => 1]]);
$p = new TopicProjector($dir);
$p->project();
$first = file_get_contents($dir . '/topics/programs.json');
$p->project();
$second = file_get_contents($dir . '/topics/programs.json');
check('repeated projection is byte-identical', $first === $second);
cleanup($dir);

// --- coverage --------------------------------------------------------------
$dir = makeFixture(['site_info' => ['n' => 1], 'brand_new_section' => ['n' => 2]]);
$uncovered = (new TopicProjector($dir))->verifyCoverage();
check('flags a section no topic exposes', in_array('brand_new_section', $uncovered, true));

$dir2 = makeFixture(['site_info' => ['n' => 1], 'homepage_popup' => ['n' => 2]]);
check('does not flag deliberately excluded sections',
    !in_array('homepage_popup', (new TopicProjector($dir2))->verifyCoverage(), true));
cleanup($dir);
cleanup($dir2);

// --- failure handling ------------------------------------------------------
$dir = sys_get_temp_dir() . '/kaizen-test-' . uniqid();
mkdir($dir, 0755, true);
file_put_contents($dir . '/site-content.json', '{ not valid json');
$result = (new TopicProjector($dir))->project();
check('reports an error on malformed source', !empty($result['errors']));
check('writes nothing when the source is unreadable', empty($result['written']));
cleanup($dir);

$result = (new TopicProjector('/nonexistent/path'))->project();
check('reports an error on a missing source', !empty($result['errors']));

echo "\n{$passed} passed, {$failed} failed\n";
exit($failed === 0 ? 0 : 1);
