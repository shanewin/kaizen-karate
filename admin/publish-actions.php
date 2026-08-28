<?php
/**
 * Shared publish behaviour.
 *
 * Publishing and re-deriving the chatbot corpus belong together: content that
 * is live while the assistant still answers from the previous corpus is the
 * drift the projection exists to prevent. Keeping the pair in one function
 * means a future publish entry point cannot pick up one without the other,
 * which is how they came apart before: the projection was wired into a second,
 * orphaned publish script that the dashboard never called.
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
