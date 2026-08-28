<section id="contact" class="contact-section" style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white;">
  <div class="container">
    <h2 class="text-center mb-5" style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;">Contact Kaizen Karate</h2>
    <p class="text-center mb-5" style="color: #e9ecef; font-size: 1.2rem; line-height: 1.6; font-weight: 400;">
      Ready to begin your martial arts journey? Have Questions? Contact us to learn more about our programs.
    </p>

    <!--
      Elfsight Contact Form.

      The widget is lazy loaded and takes several seconds to appear, which left
      this space blank under the heading: a visitor could scroll past an empty
      "Contact us" section and never see a form. The placeholder below fills that
      gap, and becomes a set of direct contact details if the widget does not
      arrive at all, which happens when a content blocker stops third party
      scripts.
    -->
    <div id="contactFormPlaceholder" class="text-center py-5" style="color: #e9ecef;">
      <div class="spinner-border text-light mb-3" role="status" aria-hidden="true"></div>
      <p class="mb-0">Loading the contact form...</p>
    </div>

    <noscript>
      <div class="text-center py-4" style="color: #e9ecef;">
        <p>The contact form needs JavaScript. You can reach us directly:</p>
        <p class="mb-0">
          <a href="tel:301-938-2711" style="color: #fff;">301-938-2711</a> (DC, MD, VA) &nbsp;|&nbsp;
          <a href="tel:646-475-7328" style="color: #fff;">646-475-7328</a> (NY) &nbsp;|&nbsp;
          <a href="mailto:coach.v@kaizenkarateusa.com" style="color: #fff;">coach.v@kaizenkarateusa.com</a>
        </p>
      </div>
    </noscript>

    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-80a0582f-129a-4b92-98e8-31c4ecf061ba" data-elfsight-app-lazy></div>

    <script>
      (function () {
        var placeholder = document.getElementById('contactFormPlaceholder');
        var widget = document.querySelector('[class^="elfsight-app-"]');
        if (!placeholder || !widget) { return; }

        var settled = false;

        function widgetHasRendered() {
          return widget.querySelector('form, input, textarea') !== null;
        }

        function hidePlaceholder() {
          if (settled) { return; }
          settled = true;
          placeholder.style.display = 'none';
          observer.disconnect();
        }

        // The widget injects its markup asynchronously, so watch for it rather
        // than guessing at a delay.
        var observer = new MutationObserver(function () {
          if (widgetHasRendered()) { hidePlaceholder(); }
        });
        observer.observe(widget, { childList: true, subtree: true });

        if (widgetHasRendered()) { hidePlaceholder(); }

        // If it still has not appeared, give people a way to reach us rather
        // than an empty section.
        setTimeout(function () {
          if (settled || widgetHasRendered()) { return; }
          settled = true;
          observer.disconnect();
          placeholder.innerHTML =
            '<p class="mb-2">The contact form is taking longer than usual to load.</p>' +
            '<p class="mb-0">Call <a href="tel:301-938-2711" style="color:#fff;">301-938-2711</a> (DC, MD, VA) ' +
            'or <a href="tel:646-475-7328" style="color:#fff;">646-475-7328</a> (NY), ' +
            'or email <a href="mailto:coach.v@kaizenkarateusa.com" style="color:#fff;">coach.v@kaizenkarateusa.com</a>.</p>';
        }, 12000);
      })();
    </script>
  </div>
</section>
