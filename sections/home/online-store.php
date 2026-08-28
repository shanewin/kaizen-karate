<section id="online-store" class="py-5" style="background: #ffffff; color: #333; position: relative; overflow: hidden;">
  <!-- Artistic Background Blobs -->
  <!-- Large Impact Blobs -->
  <div style="position: absolute; top: -120px; left: -120px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(220, 53, 69, 0.10) 0%, rgba(220, 53, 69, 0.05) 40%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: -100px; right: -150px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(44, 62, 80, 0.08) 0%, rgba(44, 62, 80, 0.03) 45%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 40%; right: -180px; width: 380px; height: 380px; background: radial-gradient(circle, rgba(220, 53, 69, 0.07) 0%, rgba(220, 53, 69, 0.02) 50%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: 20%; left: -80px; width: 320px; height: 320px; background: radial-gradient(circle, rgba(44, 62, 80, 0.06) 0%, rgba(44, 62, 80, 0.02) 60%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  
  <!-- Medium Impact Blobs -->
  <div style="position: absolute; top: 60%; left: 75%; transform: translate(-50%, -50%); width: 280px; height: 280px; background: radial-gradient(circle, rgba(220, 53, 69, 0.06) 0%, rgba(220, 53, 69, 0.02) 60%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 15%; left: 20%; width: 240px; height: 240px; background: radial-gradient(circle, rgba(44, 62, 80, 0.05) 0%, transparent 70%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: 30%; right: 10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(220, 53, 69, 0.05) 0%, transparent 75%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 70%; left: 10%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(44, 62, 80, 0.04) 0%, transparent 65%); border-radius: 50%; z-index: 1;"></div>
  
  <!-- Additional Artistic Blobs -->
  <div style="position: absolute; top: 20%; right: 8%; width: 200px; height: 200px; background: radial-gradient(circle, rgba(220, 53, 69, 0.06) 0%, rgba(220, 53, 69, 0.02) 60%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: 80%; left: 50%; width: 180px; height: 180px; background: radial-gradient(circle, rgba(44, 62, 80, 0.04) 0%, transparent 65%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; top: -30px; left: 45%; width: 260px; height: 260px; background: radial-gradient(circle, rgba(220, 53, 69, 0.04) 0%, transparent 80%); border-radius: 50%; z-index: 1;"></div>
  <div style="position: absolute; bottom: 35%; right: -60px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(44, 62, 80, 0.05) 0%, rgba(44, 62, 80, 0.01) 55%, transparent 100%); border-radius: 50%; z-index: 1;"></div>
  
  <div class="container" style="position: relative; z-index: 2;">
    <h2 class="text-center mb-5" style="color: #2c3e50; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;"><?php echo display_text('online_store', 'title', 'Online Store'); ?></h2>
    
    <div class="row align-items-center g-4">
      <!-- Store Image -->
      <div class="col-lg-7">
        <img src="<?php echo display_text('online_store', 'store_image', 'assets/images/online-store/online-store.jpg'); ?>" 
             alt="Kaizen Karate Online Store - Uniforms, T-shirts & Sparring Gear" 
             style="width: 100%; height: auto; object-fit: contain;">
    </div>
    
      <!-- Store Information -->
      <div class="col-lg-5">
        <div style="padding: 1.5rem;">
          
          <div style="background: rgba(220, 53, 69, 0.1); border: 2px solid rgba(220, 53, 69, 0.2); border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
            <h4 style="color: #dc3545; font-size: 1.8rem; margin-bottom: 1rem; font-weight: 700;">
              <i class="fas fa-shopping-cart" style="margin-right: 0.5rem;"></i>
              <?php echo display_text('online_store', 'announcement_heading', 'The online store is now open!'); ?>
            </h4>
            <p style="color: #495057; font-size: 1.1rem; margin: 0; line-height: 1.6;">
            <?php echo display_text('online_store', 'announcement_description', 'Get your karate uniform, t-shirt, & sparring gear shipped directly to your home.'); ?>
            </p>
          </div>
                               
                     <!-- Shop Now Button -->
           <div style="text-align: center; margin-top: 1.5rem;">
            <a href="<?php echo display_text('online_store', 'button_url', 'https://kaizenkarate.store/'); ?>" 
               target="_blank"
               style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.2rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.3rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3); border: none;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.5)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.3)';">
              <i class="fas fa-shopping-bag" style="margin-right: 0.8rem; font-size: 1.2rem;"></i>
              <?php echo display_text('online_store', 'button_text', 'Shop Now'); ?>
            </a>

          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
