<?php
/**
 * Shared publish behaviour.
 *
 * There are two publish entry points: publish.php (form post) and
 * publish-changes.php (the dashboard's fetch call). The topic projection was
 * originally wired into publish.php only, which is the one the UI does not
 * use, so publishing from the dashboard pushed content live and left the
 * chatbot answering from the previous corpus. Both now call this.
 */

require_once __DIR__ . '/../includes/TopicProjector.php';

/**
 * Publish pending changes, then re-derive the chatbot's retrieval corpus from
 * the freshly published content.
 *
 * Projection failure is reported but does not fail the publish: the site is
 * already live by that point.
 *
 * @return array publish_all_changes() result plus a 'projection' key
 */
function publish_all_changes_and_project()
{
    $result = publish_all_changes();
    $result['projection'] = ['written' => [], 'skipped' => [], 'errors' => []];

    if (!empty($result['success'])) {
        $projector = new TopicProjector(CONTENT_ROOT);
        $result['projection'] = $projector->project();

        if (!empty($result['projection']['errors'])) {
            error_log('Topic projection failed: ' . implode('; ', $result['projection']['errors']));
        }
        if ($uncovered = $projector->verifyCoverage()) {
            error_log('Content not exposed to chatbot: ' . implode(', ', $uncovered));
        }
    }

    return $result;
}
