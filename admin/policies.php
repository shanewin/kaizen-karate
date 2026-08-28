<?php
define('KAIZEN_ADMIN', true);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/error-handling.php';

require_once 'config.php';

require_login();

$message = '';

$content = load_json_data('site-content', 'draft');

$defaultPolicies = [
    'enabled' => true,
    'page_title' => 'Policies & Terms',
    'meta_description' => 'Review Kaizen Karate policies, terms of service, and privacy information.',
    'content' => <<<'HTML'
<div class="policies-content" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
          
          <h1 class="text-center mb-5" style="color: var(--accent); font-weight: 700; font-size: 2.5rem;">Policies</h1>
          
          <!-- Refund Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Refund Policy</h2>
            <p class="mb-3">There are no refunds for any classes once the session has begun (see Withdrawal Policy below). Students who do not attend one or more sessions of a class are not due a "partial" refund. All sales are final after the start of the first class of the session. No exceptions will be made.</p>
          </div>

          <!-- Withdrawal Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Withdrawal Policy</h2>
            <p class="mb-2">If class is cancelled by Kaizen Karate then student will receive a FULL refund.</p>
            <p class="mb-2">If the student withdraws before the start of the 1st class then they will receive a FULL refund minus a $25 processing fee.</p>
            <p class="mb-2">If a student withdraws after the 1st class then credit will be given (see Credit Policy below).</p>
            <p class="mb-2">If a student withdraws after 2nd class: No refund or credit will be given.</p>
            <p class="mb-0"><strong>Workshops / Seminars / Tournaments / Belt Exams:</strong> No refund or credit will be given at any time.</p>
          </div>

          <!-- Credit Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Credit Policy</h2>
            <p class="mb-3">Per our no refund policy, credit will be given for any refund request up to 30 days from the original date of sale (not the class start date). Credit applies to any service offered by Kaizen Karate of equal or lesser value. Any additional price difference must be paid prior to the student participating in the class. Credit may not be used to purchase merchandise. Any credit not used within a 6 month period will expire. No exceptions.</p>
            <p class="mb-3">Credit that is issued for ANY reason is valid for a 6 month period only. No Exceptions. After the 60 day period the credit is no longer valid.</p>
            <p class="mb-3">Credit given for any program that operates during the school year (September - May) can <strong>not</strong> be applied to any Summer Camp programs including our all-day camps.</p>
            <p class="mb-3">Credit given for group classes can not be applied to private lessons or small group classes.</p>
            <p class="mb-3">Credit given for Summer Camp can not be applied for school year programs.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 9/4/2020</p>
          </div>

          <!-- Transfer Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Transfer Policy</h2>
            <p class="mb-0">If you have registered for a class and wish to transfer there is a $10.00 processing fee. Students are only able to transfer to a different class if there is space available.</p>
          </div>

          <!-- Late Pick-up Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Late Pick-up Policy</h2>
            <p class="mb-0">Instructors frequently have other commitments shortly after class ends, we ask that you respect the Instructors' time by arriving on time. There will be a 5 minute grace period after the program has ended. After that parents will be charged an additional fee of $1.00 per minute. The late fee must be paid before the next class. If the late-fee is not paid the student will be removed from the program.</p>
          </div>

          <!-- Make-Up Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Make-Up Policy</h2>
            
            <h3 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">AFTER SCHOOL PROGRAMS - Fall, Winter, Spring, & Summer</h3>
            <p class="mb-3">Kaizen Karate does <strong>not</strong> offer pro-rating of tuition at any of our programs. However, if a class is missed, it can be made up at one of our evening or weekend locations. The make-up must be completed during the session that the class was missed. Once the given session has been completed, no more make-ups are permitted for that session. No Exceptions.</p>
            <p class="mb-3">To schedule your make-up a class, email our office directly at coach.v@kaizenkaratemd.com with your request. Please note, all make-ups <strong>must</strong> be scheduled in advance.</p>
            <p class="mb-4" style="font-style: italic; color: #666;">Updated on 6/13/18</p>

            <h3 style="color: var(--text-dark); font-weight: 600; margin-bottom: 15px;">AFTER SCHOOL PROGRAMS - Winter <strong>ONLY</strong></h3>
            <p class="mb-3">Kaizen Karate does <strong>not</strong> offer more than 2 make-ups per session during the winter season. IF one or two classes is missed due to weather, those classes will be made up during the session generally by adding classes dates to the end of the session. If three or more classes are missed for any reason, class three and beyond must be made up at one of our weekend or evening locations.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 11/16/21</p>
          </div>

          <!-- Snow Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Snow Policy - After School Programs</h2>
            <p class="mb-0">If 1 class is missed at an after school program due to a snow day then the class will be made up at the end of the session by adding on one extra class. If 2 classes are missed due to snow then Kaizen Fitness will make-up the missed dates by adding 2 extra classes on to the end of the session. No more than 2 missed classes will be made up for snow dates in a given session. If a 3rd class is missed due to snow then this class and any future missed classes (4, 5, etc) in the session must be made up at one of our weekend or evening classes and they will not be made up by adding on additional dates to the session.</p>
          </div>

          <!-- Tuition Payment Policies -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Tuition Payment Policies</h2>
            <p class="mb-2">No Cash OR Checks Accepted by Kaizen Karate Instructors.</p>
            <p class="mb-0">ALL tuition payments must be made online through our website PRIOR to the start of classes.</p>
          </div>

          <!-- Private Lesson Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Private Lesson Policy</h2>
            <p class="mb-3">All registration for private lessons must place directly with the Kaizen Karate office.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 9/4/2020</p>
          </div>

          <!-- Lockout Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Lockout Policy</h2>
            <p class="mb-3">The Kaizen Office Team will do everything possible to ensure that all classes run on schedule at all times. On rare occasions, we are unable to access a facility for factors that are out of our control. We ask that all parents and adult students "opt in" for our text message alerts to receive timely updates with the latest news and announcements in the case of a last minute change. Please note, you will only receive a text message if you are enrolled for the class. See our Lockout Policy below for both youth & adult classes.</p>
            <p class="mb-3"><strong>YOUTH Classes:</strong> If we are unable to access the facility for any reason (lock out, etc), a credit will be awarded to the parent's online account to be used for future sessions.</p>
            <p class="mb-3"><strong>ADULT Classes:</strong> If we are unable to access the facility for any reason (lock out, etc), a credit will be issued to your account IF you are enrolled in that class with your name on the roster. If you are enrolled in a different adult class (name not on the roster) and attend the class that is "locked out", no credit and no refund will be given. Instead, students who are not on the roster (but are enrolled in a different adult class) are welcome to make-up the class at any of our other adult class locations.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 11/23/2021</p>
          </div>

          <!-- Merchandise Exchange Policy -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Merchandise Exchange Policy</h2>
            <p class="mb-0">All items include FREE SHIPPING and will be sent directly to your address on file. In the event you need to return or exchange for a different size, customer will be charged for the shipping fee to re-ship each item for the correct size. No exchanges or refunds for special edition t-shirts or t-shirt competition apparel. Once the item is mailed back to PO Box 221, Spencerville, MD 20868 and received then the new item will be shipped out.</p>
          </div>

          <!-- Virtual Classes -->
          <div class="policy-section mb-5">
            <h2 style="color: var(--accent); font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">Virtual Classes</h2>
            <p class="mb-3">No transfers allowed from In-person classes to Virtual classes or vice versa.</p>
            <p class="mb-3">There is no pro-rating at any time for Virtual classes. Full tuition rate is due if you join after the start of the session.</p>
            <p class="mb-3">No refunds or credits will be given after the first class of the week has started.</p>
            <p class="mb-0" style="font-style: italic; color: #666;">Updated on 1/6/2022</p>
          </div>

          <!-- Back to Home Button -->
          <div class="text-center mt-5">
            <a href="index.php" class="btn btn-danger btn-lg px-5 py-3" style="border-radius: 8px; font-weight: 600;">
              <i class="fas fa-arrow-left me-2"></i>Back to Home
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
HTML,
];

$policiesData = array_replace_recursive($defaultPolicies, $content['policies_page'] ?? []);
$policiesKeyExists = array_key_exists('policies_page', $content);

$legacyPoliciesPlaceholder = '<h2>Policies &amp; Terms';
$legacyPoliciesText = 'Use this space to outline the policies';
if (
    trim($policiesData['content'] ?? '') === '' ||
    strpos($policiesData['content'], $legacyPoliciesPlaceholder) !== false ||
    strpos($policiesData['content'], $legacyPoliciesText) !== false
) {
    $policiesData['content'] = $defaultPolicies['content'];
}

if (!$policiesKeyExists && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $content['policies_page'] = $policiesData;
    save_json_data('site-content', $content);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $postedPolicies = $policiesData;

        $postedPolicies['enabled'] = isset($_POST['page_enabled']);
        $postedPolicies['page_title'] = sanitize_input($_POST['page_title'] ?? $postedPolicies['page_title']);
        $postedPolicies['meta_description'] = sanitize_input($_POST['meta_description'] ?? $postedPolicies['meta_description']);
        $postedPolicies['content'] = $_POST['page_content'] ?? $postedPolicies['content'];

        $content['policies_page'] = $postedPolicies;
        if (save_json_data('site-content', $content)) {
            $message = success_message('Policies page saved to draft successfully!');
            $policiesData = $postedPolicies;
        } else {
            $message = error_message('Failed to save policies page.');
        }
    }
}
ob_start();
?>
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-clipboard-list me-2"></i>Edit Policies Content</h3>

    
    <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                                <div class="form-check form-switch mb-4">
                                    <input class="form-check-input" type="checkbox" id="page_enabled" name="page_enabled" <?php echo $policiesData['enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="page_enabled">Enable Policies Page</label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Page Title</strong></label>
                                    <input type="text" class="form-control" name="page_title" value="<?php echo htmlspecialchars($policiesData['page_title']); ?>" placeholder="Policies &amp; Terms">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Meta Description</strong></label>
                                    <textarea class="form-control" name="meta_description" rows="3" placeholder="Short summary for search results."><?php echo htmlspecialchars($policiesData['meta_description']); ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><strong>Policies Page Content</strong></label>
                                    <textarea class="form-control tinymce-editor" name="page_content" rows="15"><?php echo $policiesData['content']; ?></textarea>
                                    <div class="form-text">TinyMCE supports headings, lists, tables, and embedded links. Paste formatted HTML if needed.</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        <i class="fas fa-save me-2"></i>Saves update <code>site-content-draft.json</code>.
                                    </div>
                                    <button type="submit" class="btn btn-kaizen">
                                        <i class="fas fa-save me-2"></i>Save Policies to Draft
                                    </button>
                                </div>
                            </form>

</div>
<?php
$page_content = ob_get_clean();
$render_page_content_direct = true;

$additional_head_scripts = '<script src="https://cdn.tiny.cloud/1/' . TINYMCE_API_KEY . '/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>';

$additional_scripts = <<<JS
document.addEventListener('DOMContentLoaded', function () {
    if (typeof tinymce === 'undefined') {
        console.error('TinyMCE failed to load.');
        return;
    }
    tinymce.init({
        selector: '.tinymce-editor',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | link | code | fullscreen',
        menubar: false,
        branding: false,
        height: 500,
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 15px; }'
    });
});
JS;

$page_title = 'Policies Page';
$page_icon = 'fas fa-file-contract';

include 'includes/admin-template.php';
