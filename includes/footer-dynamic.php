<?php
/**
 * Dynamic footer renderer for Kaizen Karate.
 *
 * Usage:
 * require_once 'includes/footer-dynamic.php';
 * render_footer('draft'); // or 'live'
 */

if (!function_exists('render_footer')) {
    /**
     * Render the footer from JSON content.
     *
     * @param string $mode Either 'draft' or 'live'. Defaults to 'live'.
     */
    function render_footer(string $mode = 'live'): void
    {
        $mode = ($mode === 'draft') ? 'draft' : 'live';

        $defaultFooter = [
            'enabled' => true,
            'settings' => [
                'background_color' => '#2c3e50',
                'text_color' => '#ffffff',
                'num_columns' => 3,
            ],
            'columns' => [
                'branding' => [
                    'enabled' => true,
                    'logo' => [
                        'src' => 'assets/images/kaizen-logo-footer.png',
                        'alt' => 'Kaizen Karate',
                    ],
                    'title' => 'Kaizen Karate',
                    'description' => 'Traditional martial arts training in Washington DC, Maryland, Northern Virginia, and New York. Building character, discipline, and strength through the art of karate.',
                ],
                'quick_links' => [
                    'enabled' => true,
                    'title' => 'Quick Links',
                    'links' => [
                        ['label' => 'Training Options', 'url' => '#training-options'],
                        ['label' => 'Summer Camp', 'url' => '#summer-camp'],
                        ['label' => 'After School', 'url' => '#weekend-evening'],
                        ['label' => 'Weekend Classes', 'url' => '#weekend-evening'],
                        ['label' => 'Belt Exams', 'url' => '#belt-exam'],
                        ['label' => 'Contact Us', 'url' => '#contact'],
                        ['label' => 'Policies', 'url' => 'policies.php'],
                        ['label' => 'FAQs', 'url' => 'faq.php'],
                        ['label' => 'Student Handbook', 'url' => 'student-handbook.php'],
                    ],
                ],
                'contact' => [
                    'enabled' => true,
                    'heading' => 'Get In Touch',
                    'items' => [
                        ['type' => 'phone', 'label' => 'DC, MD, VA Programs', 'value' => '301-938-2711', 'icon' => 'fas fa-phone'],
                        ['type' => 'phone', 'label' => 'NY Program', 'value' => '646-475-7328', 'icon' => 'fas fa-phone'],
                        ['type' => 'email', 'label' => '', 'value' => 'coach.v@kaizenkarateusa.com', 'icon' => 'fas fa-envelope'],
                    ],
                    'social_heading' => 'Follow Us',
                    'social_links' => [
                        ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/people/Kaizen-Karate/100063714665511/', 'icon' => 'fab fa-facebook-f'],
                        ['platform' => 'TikTok', 'url' => 'https://www.tiktok.com/@kaizenkaratemd', 'icon' => 'fab fa-tiktok'],
                        ['platform' => 'Instagram', 'url' => 'https://www.instagram.com/kaizen_karate/', 'icon' => 'fab fa-instagram'],
                        ['platform' => 'Podcast', 'url' => 'https://coachv6z.podbean.com/', 'icon' => 'fas fa-podcast'],
                    ],
                ],
            ],
            'bottom_bar' => [
                'enabled' => true,
                'copyright' => '© {YEAR} Kaizen Karate. All Rights Reserved.',
            ],
        ];

        $content = [];

        if (function_exists('load_json_data')) {
            $content = load_json_data('site-content', $mode) ?: [];
        } else {
            $baseDir = __DIR__ . '/../data/content';
            $suffix = ($mode === 'draft') ? '-draft' : '';
            $path = $baseDir . '/site-content' . $suffix . '.json';
            if (is_readable($path)) {
                $json = file_get_contents($path);
                $content = json_decode($json, true) ?: [];
            }
        }

        $footerData = $content['footer'] ?? [];
        if (empty($footerData)) {
            $footerData = $defaultFooter;
        } else {
            $footerData = array_replace_recursive($defaultFooter, $footerData);
        }

        // Normalise collections
        $quickLinks = $footerData['columns']['quick_links']['links'] ?? [];
        $quickLinks = array_values(array_filter(
            $quickLinks,
            static fn($link) => !empty($link['label']) && !empty($link['url'])
        ));

        $contactItems = $footerData['columns']['contact']['items'] ?? [];
        $contactItems = array_values(array_filter(
            $contactItems,
            static fn($item) => !empty($item['value'])
        ));

        $socialLinks = $footerData['columns']['contact']['social_links'] ?? [];
        $socialLinks = array_values(array_filter(
            $socialLinks,
            static fn($link) => !empty($link['url'])
        ));

        $branding = $footerData['columns']['branding'];
        $quickLinksEnabled = !empty($footerData['columns']['quick_links']['enabled']);
        $contactEnabled = !empty($footerData['columns']['contact']['enabled']);

        $bottomBar = $footerData['bottom_bar'];
        $bottomEnabled = !empty($bottomBar['enabled']);
        $bottomText = $bottomBar['copyright'] ?? '';
        if ($bottomText) {
            $bottomText = str_replace('{YEAR}', date('Y'), $bottomText);
        }

        if (empty($footerData['enabled'])) {
            return;
        }

        ?>
<footer class="footer">
  <div class="container">
    <!-- Main Footer Content -->
    <div class="footer-main">
      <div class="row g-4">
        <!-- Column 1: Logo & Description -->
        <?php if (!empty($branding['enabled'])): ?>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="footer-brand">
            <?php if (!empty($branding['logo']['src'])): ?>
            <img src="<?php echo htmlspecialchars($branding['logo']['src']); ?>" alt="<?php echo htmlspecialchars($branding['logo']['alt'] ?? 'Kaizen Karate'); ?>" class="footer-logo">
            <?php endif; ?>
            <?php if (!empty($branding['title'])): ?>
            <h5 class="footer-title"><?php echo htmlspecialchars($branding['title']); ?></h5>
            <?php endif; ?>
            <?php if (!empty($branding['description'])): ?>
            <p class="footer-description">
              <?php echo htmlspecialchars($branding['description']); ?>
            </p>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Column 2: Quick Links -->
        <?php if ($quickLinksEnabled && !empty($quickLinks)): ?>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <h6 class="footer-heading"><?php echo htmlspecialchars($footerData['columns']['quick_links']['title'] ?? 'Quick Links'); ?></h6>
          <ul class="footer-links">
            <?php foreach ($quickLinks as $link): ?>
            <?php $linkUrl = kaizen_link($link['url'] ?? ''); ?>
            <li><a href="<?php echo htmlspecialchars($linkUrl); ?>"><?php echo htmlspecialchars($link['label']); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <!-- Column 3: Contact & Social -->
        <?php if ($contactEnabled && (!empty($contactItems) || !empty($socialLinks))): ?>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <?php if (!empty($footerData['columns']['contact']['heading'])): ?>
          <h6 class="footer-heading"><?php echo htmlspecialchars($footerData['columns']['contact']['heading']); ?></h6>
          <?php endif; ?>
          <?php if (!empty($contactItems)): ?>
          <div class="footer-contact">
            <?php foreach ($contactItems as $item): ?>
            <div class="contact-item">
              <?php if (!empty($item['icon'])): ?>
              <i class="<?php echo htmlspecialchars($item['icon']); ?>"></i>
              <?php endif; ?>
              <?php
                $label = trim($item['label'] ?? '');
                $value = trim($item['value'] ?? '');
                $type = strtolower($item['type'] ?? '');
              ?>
              <?php if ($type === 'email' && $value !== ''): ?>
              <a href="mailto:<?php echo htmlspecialchars($value); ?>" style="color: inherit; text-decoration: none;">
                <?php echo htmlspecialchars($value); ?>
              </a>
              <?php else: ?>
              <div style="display: flex; flex-direction: column; gap: 4px;">
                <span style="font-weight: 600;"><?php echo htmlspecialchars($value); ?></span>
                <?php if ($label !== ''): ?>
                <span style="font-size: 0.85em; opacity: 0.9;"><?php echo htmlspecialchars($label); ?></span>
                <?php endif; ?>
              </div>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <?php if (!empty($socialLinks)): ?>
          <div class="footer-social">
            <?php if (!empty($footerData['columns']['contact']['social_heading'])): ?>
            <h6 class="social-heading"><?php echo htmlspecialchars($footerData['columns']['contact']['social_heading']); ?></h6>
            <?php endif; ?>
            <div class="social-icons">
              <?php foreach ($socialLinks as $link): ?>
              <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="<?php echo htmlspecialchars($link['platform'] ?? 'Social Link'); ?>">
                <?php if (!empty($link['icon'])): ?>
                <i class="<?php echo htmlspecialchars($link['icon']); ?>"></i>
                <?php endif; ?>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($bottomEnabled && $bottomText !== ''): ?>
    <!-- Bottom Footer -->
    <div class="footer-bottom">
      <div class="row align-items-center">
        <div class="col-md-12 text-center">
          <p><?php echo htmlspecialchars($bottomText); ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</footer>
<?php
    }
}
