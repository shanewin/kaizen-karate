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

$defaultFaq = [
    'enabled' => true,
    'page_title' => 'Frequently Asked Questions',
    'meta_description' => 'Find answers to common questions about Kaizen Karate classes, registration, and programs.',
    'content' => <<<'HTML'
<section class="faq-section" style="padding-top: 120px; padding-bottom: 60px; background-color: #f8f9fa;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        <div class="faq-content" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
          
          <h1 class="text-center mb-5" style="color: var(--accent); font-weight: 700; font-size: 2.5rem;">Frequently Asked Questions</h1>
          
          <!-- FAQ Item 1 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">How old do I have to be to begin taking classes?</h3>
            <p class="mb-0">Our Little Ninja program is available for students ages 3.5 - 4 years old. Our beginner youth classes start at age 5. We also offer adult classes for all ages.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 2 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">What should my child wear to their 1st class?</h3>
            <p class="mb-0">Before ordering a uniform students should wear long comfortable pants and t-shirt to class each week. Students will have time to change before the start of class. Parents can purchase t-shirts, uniforms, and other gear through our <a href="https://kaizenkarate.store/" target="_blank" style="color: var(--accent); text-decoration: underline;">online store</a>.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 3 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">Do I need to order a uniform?</h3>
            <p class="mb-0">When a student first starts karate classes a uniform is optional. Once a student determines that they are interested in continuing classes past their initial session then a black uniform can be ordered through the Kaizen Karate <a href="https://kaizenkarate.store/" target="_blank" style="color: var(--accent); text-decoration: underline;">online store</a> at our discounted group rate.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 4 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">Will there be sparring or fighting in class?</h3>
            <p class="mb-0">Before a student is allowed to participate in partner drills they must first learn basic kicks, punches and blocks. Students will first learn proper technique, followed by movement drills, and finally partner based training.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 5 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">When should I purchase sparring equipment for my son/daughter?</h3>
            <p class="mb-0">Students can invest in sparring equipment after completing a full 8-week session of karate and not before. Students must have all sparring equipment no later than yellow belt rank.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 6 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">How safe is the class?</h3>
            <p class="mb-0">Safety is our #1 priority. We are very sensitive to the safety of every student in our karate program. The instructor will cover all safety procedures in detail before the start of each drill.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 7 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">Will students earn colored belts?</h3>
            <p class="mb-0">Yes, students will be allowed to test for colored belts upon invitation by their instructor. Please remember that belt exams are <strong>*invitation*</strong> only events. For more details, visit the belt exam page for testing requirements.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 8 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">When does the next session start?</h3>
            <p class="mb-0">Weekend & evening classes run in 2-month cycles. Other programs vary depending on the location. For details email us by <a href="index.php#contact" style="color: var(--accent); text-decoration: underline;">clicking here</a>.</p>
          </div>
          <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0; opacity: 0.6;">

          <!-- FAQ Item 9 -->
          <div class="faq-item mb-4">
            <h3 style="color: var(--accent); font-weight: 600; margin-bottom: 15px; font-size: 1.3rem;">How do I enroll my son/daughter for classes?</h3>
            <p class="mb-0">To register, visit us online by <a href="https://www.gomotionapp.com/team/mdkfu/page/class-registration" target="_blank" style="color: var(--accent); text-decoration: underline;">clicking here</a>. Students must be enrolled in class prior to participating. We ask that all students are registered online as we do not accept cash or check.</p>
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

<!-- Footer -->
HTML,
];

$faqData = array_replace_recursive($defaultFaq, $content['faq_page'] ?? []);
$faqKeyExists = array_key_exists('faq_page', $content);

$legacyFaqPlaceholder = 'Use this editor to build your complete FAQ page';
$legacyFaqText = 'Have questions? Find answers below';
if (
    trim($faqData['content'] ?? '') === '' ||
    strpos($faqData['content'], $legacyFaqPlaceholder) !== false ||
    strpos($faqData['content'], $legacyFaqText) !== false ||
    strpos($faqData['content'], '<h2>Frequently Asked Questions') !== false
) {
    $faqData['content'] = $defaultFaq['content'];
}

if (!$faqKeyExists && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $content['faq_page'] = $faqData;
    save_json_data('site-content', $content);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $postedFaq = $faqData;

        $postedFaq['enabled'] = isset($_POST['page_enabled']);
        $postedFaq['page_title'] = sanitize_input($_POST['page_title'] ?? $postedFaq['page_title']);
        $postedFaq['meta_description'] = sanitize_input($_POST['meta_description'] ?? $postedFaq['meta_description']);
        $postedFaq['content'] = $_POST['page_content'] ?? $postedFaq['content'];

        $content['faq_page'] = $postedFaq;
        if (save_json_data('site-content', $content)) {
            $message = success_message('FAQ page saved to draft successfully!');
            $faqData = $postedFaq;
        } else {
            $message = error_message('Failed to save FAQ page.');
        }
    }
}
ob_start();
?>
<div class="content-section">
    <h3 class="section-title"><i class="fas fa-file-alt me-2"></i>Edit FAQ Content</h3>

    <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" id="page_enabled" name="page_enabled" <?php echo $faqData['enabled'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="page_enabled">Enable FAQ Page</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Page Title</strong></label>
                                <input type="text" class="form-control" name="page_title" value="<?php echo htmlspecialchars($faqData['page_title']); ?>" placeholder="Frequently Asked Questions">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Meta Description</strong></label>
                                <textarea class="form-control" name="meta_description" rows="3" placeholder="Short summary for search results."><?php echo htmlspecialchars($faqData['meta_description']); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><strong>FAQ Page Content</strong></label>
                                <textarea class="form-control tinymce-editor" name="page_content" rows="15"><?php echo $faqData['content']; ?></textarea>
                                <div class="form-text">Use headings for categories and bold for questions. Lists help present answers clearly.</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    <i class="fas fa-save me-2"></i>Saves update <code>site-content-draft.json</code>.
                                </div>
                                <button type="submit" class="btn btn-kaizen">
                                    <i class="fas fa-save me-2"></i>Save FAQ to Draft
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

$page_title = 'FAQ Page';
$page_icon = 'fas fa-question-circle';

include 'includes/admin-template.php';
