<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>THE GARRISON</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles/style.css">

  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico">
  <link rel="manifest" href="favicon/site.webmanifest">

  <!--
    /**
    * @license
    * MyFonts Webfont Build ID 892684
    *
    * The fonts listed in this notice are subject to the End User License
    * Agreement(s) entered into by the website owner. All other parties are
    * explicitly restricted from using the Licensed Webfonts(s).
    *
    * You may obtain a valid license from one of MyFonts official sites.
    * http://www.fonts.com
    * http://www.myfonts.com
    * http://www.linotype.com
    *
    */
    -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
</head>
<body>


<!-- Navigation -->
<nav class="navbar navbar-expand-lg  navbar-light bg-light fixed-top">
  <div class="container">
    <!-- Text Logo with Address -->
    <a class="navbar-brand" href="#" style="font-family: 'QuorthonDarkIV', serif; font-weight: 700; color: var(--accent-color);">
      The Garrison
      <div class="navbar-address" style="font-size: 1rem; color: var(--text-color); font-family: Arial, sans-serif;">
        151 Carlton Avenue, Brooklyn, NY 11205
      </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#luxury">Luxury Living</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#availability">Availability</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#amenities">Amenities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#neighborhood">Neighborhood</a>
        </li>
        <!-- Email List Link -->
        <li class="nav-item email-list-item">
          <a class="nav-link email-list-link" href="#" id="openEmailPopupBtn">Email List</a>
        </li>
        <!-- Wait List Link -->
        <li class="nav-item waitlist-item">
          <a class="nav-link waitlist-link" href="#contact">Wait List</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <!-- Hero Section with Two Columns -->
  <header class="hero-section">
    <div class="container-fluid h-100">
      <div class="row h-100">
        <!-- Left Column: Video and Hero Content -->
        <div class="col-lg-8 h-100 d-flex align-items-center justify-content-center position-relative">
          <div class="video-container">
            <video autoplay muted loop playsinline id="hero-video">
              <source src="assets/videos/hero-video-5.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        </div>
      

        <!-- Right Column (Panels) -->
        <div class="col-lg-4 d-flex flex-column">
            <!-- Panel 1 -->
            <div class="panel flex-grow-1 position-relative" 
                data-media='[
                    {
                      "type": "video",
                      "src": "assets/videos/coworking.mp4",
                      "caption": "Collaborative workspace"
                    }
                ]'>
              <img src="assets/images/coworking-1.png" alt="Panel 1" class="img-fluid w-100">
              <div class="panel-text">
                <h3>Coworking Space</h3>
                <p>Click to see more <span class="icon">→</span></p>
              </div>
            </div>

          
            <!-- Panel 2 -->
            <div class="panel flex-grow-1 position-relative mb-3" 
                 data-media='[{"type": "video", "src": "assets/videos/fitness-center-hero1.mp4", "caption": "Deluxe Fitness Center"}
                              ]'>
              <img src="assets/images/fitness-center.png" alt="Panel 2" class="img-fluid w-100">
              <div class="panel-text">
                <h3>Fitness Center</h3>
                <p>Click to see more <span class="icon">→</span></p>
              </div>
            </div>
          
            <!-- Panel 3 (Fix apostrophe issue) -->
            <div class="panel flex-grow-1 position-relative" 
                 data-media='[{"type": "video", "src": "assets/videos/rooftop-terrace.mp4", "caption": "Rooftop Terrace"}]'>
              <img src="assets/images/rooftop.png" alt="Rooftop Terrace" class="img-fluid w-100">
              <div class="panel-text">
                <h3>Rooftop Terrace</h3>
                <p>Click to see more <span class="icon">→</span></p>
              </div>
            </div>
          </div>
        


      </div>
    </div>
  </header>

  <!-- Pop-up Form Container -->
  <div id="popupForm" class="popup-form-container">
    <div class="popup-form-content">
      <span class="close-btn" id="closePopupBtn">&times;</span>
      
      <!-- Form Section (shown by default) -->
      <div id="formSection">
        <h2>Stay Updated</h2>
        <p>Be the first to know about leasing updates at 151 Carlton Avenue.</p>
        <form id="emailSignupForm" action="email-list.php" method="POST">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) ?>">
          <input type="email" name="email" placeholder="Enter your email" required>
          <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
      </div>
      
      <!-- Thank You Section (hidden by default) -->
      <div id="thankYouSection" style="display: none;">
        <h2>Thank You!</h2>
        <p>Thank you for joining the official email list of The Garrison!</p>
        <p>We will keep you up-to-date with all the latest news and updates.</p>
      </div>
    </div>
  </div>


<!-- About Section -->
<section id="about" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">About The Garrison</h2>
    <div class="row">
      <div class="col-md-6">
        <p class="lead">
      Welcome to <span style="font-family: 'QuorthonDarkIV', serif;">The Garrison</span>, Fort Greene’s newest luxury residence, perfectly positioned steps from Fort Greene Park and the neighborhood’s most sought-after hotspots. This 63-unit masterpiece blends sleek modern design with breathtaking Manhattan skyline views, setting a new standard for upscale Brooklyn living.
    </p>
    <p>
      Wake up to skyline views. Unwind in style. Your home at The Garrison is designed for the way you live. Expansive floor-to-ceiling windows bathe each space in natural light, while private glass balconies offer the perfect spot for morning coffee or sunset cocktails.
    </p>
    <p>
      Inside, every detail speaks of effortless luxury, from chef-inspired kitchens with elegant islands and premium finishes to spa-like bathrooms designed for relaxation and the everyday convenience of in-unit laundry.
    </p>
  </div>
  <div class="col-md-6">
    <p>
      Life at The Garrison is more than just a stunning apartment—it’s a lifestyle upgrade. Work, relax, and entertain with a furnished rooftop lounge featuring BBQ grills and an outdoor kitchen, a state-of-the-art fitness center to keep you moving, and a collaborative workspace lounge designed for work-from-home ease. A bike room and secure storage add extra convenience, ensuring everything you need is right at your fingertips.
    </p>
    <p>
      Step outside and find yourself immersed in Fort Greene’s vibrant culture—from farmers’ markets in the park to buzzing cafés, Michelin-starred dining, and boutique shopping. With easy access to public transportation, the entire city is just minutes away.
    </p>
    <p>
      Explore availability or join the waitlist today and make <em>The Garrison</em> your next home in Fort Greene.
    </p>
  </div>
</div>
    <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-4">
      <a href="#availability" class="btn btn-primary">Check Availability</a>
      <a href="#contact" class="btn btn-outline-primary">Join Wait List</a>
    </div>
  </div>
</section>



<!-- Luxury Living Section -->
<section id="luxury" class="py-5">
  <div class="video-container">
    <video autoplay muted loop class="luxury-video">
      <source src="assets/videos/rooftop-features.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <div class="luxury-overlay text-center"> 
      <h2>Experience Luxury Living</h2>
      <p>Discover our state-of-the-art amenities and breathtaking views.</p>
      
      <!-- Thumbnail Grid -->
      <div class="thumbnail-grid">
        <!-- Living Room Thumbnail -->
        <div class="thumbnail-item" 
             data-media='[{"type": "image", "src": "assets/images/panel1.jpg", "caption": "Spacious Living Rooms"},
                          {"type": "image", "src": "assets/images/live-2.jpg","caption": "Spacious Living Rooms"},
                          {"type": "video", "src": "assets/videos/living-1-panel.mp4", "caption": "Spacious Living Rooms"},
                          {"type": "video", "src": "assets/videos/living-room.mp4", "caption": "Spacious Living Rooms"}]'>
          <img src="assets/images/panel1.jpg" alt="Living Rooms" class="img-fluid">
          <div class="thumbnail-label">Living Room</div>
        </div>
        
        <!-- Bedrooms Thumbnail -->
        <div class="thumbnail-item" 
             data-media='[{"type": "image", "src": "assets/images/bedroom2.jpg","caption": "Luxurious Bedrooms"},
                          {"type": "image", "src": "assets/images/panel2.jpg", "caption": "Luxurious Bedrooms"},
                          {"type": "video", "src": "assets/videos/bedroom1.mp4", "caption": "Luxurious Bedrooms"},
                          {"type": "video", "src": "assets/videos/bedroom2.mp4", "caption": "Luxurious Bedrooms"}]'>
          <img src="assets/images/panel2.jpg" alt="Bedrooms" class="img-fluid">
          <div class="thumbnail-label">Bedroom</div>
        </div>
        
        <!-- Kitchens Thumbnail -->
        <div class="thumbnail-item" 
             data-media='[{"type": "image", "src": "assets/images/panel3.jpg", "caption": "State-of-the-Art Kitchens"},
                          {"type": "video", "src": "assets/videos/kitchen1.mp4", "caption": "State-of-the-Art Kitchens"}]'>
          <img src="assets/images/panel3.jpg" alt="Kitchen" class="img-fluid">
          <div class="thumbnail-label">Kitchen</div>
        </div>
        
        <!-- Bathrooms Thumbnail -->
        <div class="thumbnail-item" 
             data-media='[{"type": "image", "src": "assets/images/bathroom-shower.png", "caption": "Spa-like Bathrooms"},
                          {"type": "image", "src": "assets/images/bathroom-tub.png","caption": "Spa-like Bathrooms"},
                          {"type": "video", "src": "assets/videos/bathroom-shower.mp4", "caption": "Spa-like Bathrooms"},
                          {"type": "video", "src": "assets/videos/bathroom-tub.mp4", "caption": "Spa-like Bathrooms"}
                         ]'>
          <img src="assets/images/bathroom-shower.png" alt="Bathroom" class="img-fluid">
          <div class="thumbnail-label">Bathroom</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
  <div class="lightbox-content">
    <div class="media-container">
      <video controls autoplay muted loop class="lightbox-media" id="lightbox-video">
        <source src="" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      <img src="" alt="" class="lightbox-media" id="lightbox-image" style="display: none;">
    </div>

    <div class="lightbox-caption" id="lightbox-caption"></div>
    <span class="close-btn">&times;</span>

    <!-- 🔽 These are the arrows -->
    <div class="lightbox-nav-wrapper">
      <button class="lightbox-nav prev">&#10094;</button>
      <button class="lightbox-nav next">&#10095;</button>
    </div>
  </div>
</div>




<!--  Availability Section -->
<section id="availability" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Availability</h2>
    <p class="text-center mb-5">Imagine your ideal NYC living experience... Then find and capture it at The Garrison. Explore our expansive collection of one-, two-, and three-bedroom residences.</p>

    <div class="text-center mb-4">
      <button class="btn btn-outline-primary filter-btn active" data-filter="all">All</button>
      <button class="btn btn-outline-primary filter-btn" data-filter="1-bed">1 Bed</button>
      <button class="btn btn-outline-primary filter-btn" data-filter="2-bed">2 Bed</button>
      <button class="btn btn-outline-primary filter-btn" data-filter="3-bed">3 Bed</button>
    </div>

    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Unit</th>
            <th>Bed/Bath</th>
            <th>Outdoor Space</th>
            <th>Rent</th>
            <th>Floor Plan</th>
          </tr>
        </thead>
        <tbody id="unit-table">
          
        </tbody>
      </table>
    </div>
    <!-- Pagination Controls -->
    <div id="pagination" class="text-center mt-4">
      <!-- Next and Previous buttons will be dynamically inserted here -->
    </div>
  </div>
</section>

<!-- Floor Plan Modal -->
<div class="modal fade" id="floorPlanModal" tabindex="-1" aria-labelledby="floorPlanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="floorPlanModalLabel">Floor Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="floorPlanImage" src="" alt="Floor Plan" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Unit Details Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="unitModalLabel"><span id="unitTitleLabel">Unit</span> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">

        <!-- 👇 Content shown before submit -->
        <div id="unitDetailsContent">

          <!-- Description -->
          <div class="mt-4">
            <h4>Description</h4>
            <ul id="unitDescription" class="mt-3"></ul>
          </div>

          <!-- Form -->
          <form id="unitInterestForm" action="unit-interest.php" method="POST" class="w-100 px-3 mt-4">
            <input type="hidden" id="unitInput" name="unit">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) ?>">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName" class="form-label">First Name <span class="required">*</span></label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName" class="form-label">Last Name <span class="required">*</span></label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-control email-input" id="email-modal" name="email" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone Number <span class="required">*</span></label>
                <input type="tel" class="form-control phone-input" id="phone-modal" name="phone" required placeholder="(123) 456-7890" maxlength="14">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="moveInDate" class="form-label">Move-In Date</label>
                <input type="date" class="form-control" id="moveInDate" name="moveInDate">
              </div>
              <div class="col-md-6 mb-3">
                <label for="budget" class="form-label">Budget</label>
                <input type="text" class="form-control budget-input" id="budget-contact" name="budget" placeholder="$0">
              </div>
            </div>

            <div class="mb-3">
              <label for="hearAboutUs" class="form-label">How Did You Hear About Us?</label>
              <select class="form-select" id="hearAboutUs" name="hearAboutUs">
                <option value="">Select an option</option>
                <option value="Google">Google</option>
                <option value="Friend">Friend</option>
                <option value="Social Media">Social Media</option>
                <option value="Advertisement">Advertisement</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" name="message" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
          </form>
        </div>

        <!-- ✅ Thank You Message (Initially Hidden) -->
        <div id="unitThankYou" style="display: none;" class="py-4 text-center">
          <h4 id="thankYouHeading">Thank you for your interest!</h4>
          <p id="thankYouMessage">
            We’ll be in touch shortly about the availability of <span id="unitThankYouName">this unit</span> at <strong>The Garrison</strong>.
          </p>
        </div>


      </div> <!-- End modal-body -->

    </div>
  </div>
</div>


<!-- Leased Unit Modal -->
<div class="modal fade" id="leasedModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="leasedUnitNumber"></span> is Leased</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>This unit is no longer available. Please contact us for information about similar available units.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Amenities Section -->
<section id="amenities" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Amenities</h2>
    <div class="row g-4">
      <!-- Fitness Center Panel -->
      <div class="col-lg-6">
        <div class="amenity-panel">
          <div class="amenity-video-container">
            <video autoplay muted loop class="amenity-video">
              <source src="assets/videos/fitness-center-hero1.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
          <div class="amenity-content">
            <h3>Stay Fit & Energized at The Garrison</h3>
            <p class="amenity-summary">Our state-of-the-artfitness center offers a spacious and modern workout environment designed for both comfort and performance.</p>
            <button class="btn btn-primary toggle-details">View Details</button>
            <div class="amenity-details">
              <p><strong>Key Features:</strong></p>
              <ul>
                <li>Expansive Space: Plenty of room for cardio, strength training, and functional workouts.</li>
                <li>Open Concept Design: Enhances airiness and natural light.</li>
                <li>Premium Flooring & Finishes: High-quality materials ensure durability and comfort.</li>
                <li>Dedicated Bike Storage: Bike storage room for secure and easy access.</li>
                <li>Nearby Restrooms: Multiple restrooms located conveniently close to the fitness center.</li>
                <li>Modern Lighting & Ventilation: Designed for optimal airflow and comfort during workouts.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>


            <!-- Rooftop Panel -->
            <div class="col-lg-6">
              <div class="amenity-panel">
                <div class="amenity-video-container">
                  <video autoplay muted loop class="amenity-video">
                    <source src="assets/videos/rooftop-terrace.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                </div>
                <div class="amenity-content">
                  <h3>Experience Breathtaking Views from the Rooftop at The Garrison</h3>
                  <p class="amenity-summary">The rooftop at 151 Carlton Avenue offers a luxurious outdoor retreat with stunning city views, high-end finishes, and thoughtfully designed amenities.</p>
                  <button class="btn btn-primary toggle-details">View Details</button>
                  <div class="amenity-details">
                    <p><strong>Key Features:</strong></p>
                    <ul>
                      <li>Spacious Outdoor Area: Designed for relaxation, entertainment, and enjoying fresh air.</li>
                      <li>Outdoor Kitchen & Grilling Station: Dedicated power supply for electric grills to enhance your dining experience.</li>
                      <li>Elegant Paving System: Raised pedestal pavers for a sleek and modern outdoor flooring solution.</li>
                      <li>Ambient Lighting: Strategically placed outdoor lighting ensures a warm and inviting atmosphere at all times.</li>
                      <li>Secure & Stylish Fencing: Steel post fencing with wood cladding for privacy and aesthetics.</li>
                      <li>Lush Greenery & Planters: Thoughtfully incorporated landscaping elements for a natural touch.</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Coworking Space Panel -->
      <div class="col-lg-6">
        <div class="amenity-panel">
          <div class="amenity-video-container">
            <video autoplay muted loop class="amenity-video">
              <source src="assets/videos/coworking.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
          <div class="amenity-content">
            <h3>Elevate Your Productivity in the Coworking Space</h3>
            <p class="amenity-summary">For those who work from home or need a productive escape, the Coworking Space at The Garrison offers a sprawling workspace designed for focus and collaboration.</p>
            <button class="btn btn-primary toggle-details">View Details</button>
            <div class="amenity-details">
              <p><strong>Key Features:</strong></p>
              <ul>
                <li>Expansive Work Area: Thoughtfully designed coworking space.</li>
                <li>Flexible Workspaces: Includes private booths, communal desks, and lounge seating.</li>
                <li>Premium Finishes: Modern LED lighting and high-end materials create an inspiring atmosphere.</li>
                <li>Tech-Ready Setup: Strategically placed outlets and data connections for seamless productivity.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</section>


<section id="neighborhood" class="neighborhood-section py-5">

  <div class="container">
    <div class="row align-items-stretch">
      
      <!-- Left Column: Intro + Carousel -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <header class="mb-4">
          <h2 class="section-title">Discover Fort Greene</h2>
          <p class="section-description">
            Nestled in <strong>Fort Greene</strong>, one of Brooklyn’s most vibrant neighborhoods, The Garrison is steps away from iconic parks, renowned schools, and excellent transit options.
          </p>
        </header>

        <!-- Bootstrap Carousel -->
        <div id="carouselNeighborhood" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner rounded shadow-sm">
            <div class="carousel-item active">
              <img src="assets/images/neighborhood/neighborhood-1.jpg" class="d-block w-100" alt="Fort Greene Park">
            </div>
            <div class="carousel-item">
              <img src="assets/images/neighborhood/neighborhood-2.jpg" class="d-block w-100" alt="Local Cafe">
            </div>
            <div class="carousel-item">
              <img src="assets/images/neighborhood/neighborhood-3.jpg" class="d-block w-100" alt="Brooklyn Streets">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselNeighborhood" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselNeighborhood" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>

      <!-- Right Column: Map -->
      <div class="col-lg-6">
        <div class="map-wrapper h-100">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.048853038659!2d-73.9699876845947!3d40.68964497933206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25ba6b3c1b0a5%3A0x8f1a7c1b0e1b0e1b!2s151%20Carlton%20Ave%2C%20Brooklyn%2C%20NY%2011205!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus"
            class="w-100 h-100 rounded shadow-sm"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
          </iframe>
        </div>
      </div>
    </div>

    <!-- Tabs Section -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="text-center mb-4">
          <div class="nav nav-pills justify-content-center" id="infoTabs" role="tablist">
            <button class="btn btn-outline-tab active" id="transport-tab" data-bs-toggle="pill" data-bs-target="#transport" type="button" role="tab" aria-controls="transport" aria-selected="true">
              Transport
            </button>
            <button class="btn btn-outline-tab" id="schools-tab" data-bs-toggle="pill" data-bs-target="#schools" type="button" role="tab" aria-controls="schools" aria-selected="false">
              Schools
            </button>
            <button class="btn btn-outline-tab" id="colleges-tab" data-bs-toggle="pill" data-bs-target="#colleges" type="button" role="tab" aria-controls="colleges" aria-selected="false">
              Colleges
            </button>
            <button class="btn btn-outline-tab" id="parks-tab" data-bs-toggle="pill" data-bs-target="#parks" type="button" role="tab" aria-controls="parks" aria-selected="false">
              Parks
            </button>
            <button class="btn btn-outline-tab" id="museums-tab" data-bs-toggle="pill" data-bs-target="#museums" type="button" role="tab" aria-controls="museums" aria-selected="false">
              Museums
            </button>
          </div>
        </div>
        
        

        <div class="tab-content" id="infoTabsContent">
          <div class="tab-pane fade show active" id="transport" role="tabpanel">
            <ul class="list-unstyled info-list">
              <li><span class="subway-icon G">G</span> Clinton-Washington Avs – 0.43 miles</li>
              <li><span class="subway-icon G">G</span> Fulton St – 0.45 miles</li>
              <li><span class="subway-icon C">C</span> Lafayette Av – 0.46 miles</li>
              <li><span class="subway-icon B">B</span> <span class="subway-icon Q">Q</span> <span class="subway-icon R">R</span> DeKalb Av – 0.5 miles</li>
              <li><span class="subway-icon _2">2</span> <span class="subway-icon _3">3</span> <span class="subway-icon _4">4</span> <span class="subway-icon _5">5</span> Nevins St – 0.53 miles</li>
            </ul>
            
            <a href="https://www.google.com/maps/search/subway+stations+near+151+Carlton+Avenue,+Brooklyn,+NY" target="_blank">
              View subway lines on Google Maps
            </a>
          </div>

          <div class="tab-pane fade" id="schools" role="tabpanel">
              <ul class="list-unstyled info-list">
                <li><i class="fas fa-school me-2"></i> P.S. 020 Clinton Hill (Grades PK–5)</li>
              </ul>
              <small class="text-muted d-block mt-2">*School attendance zone boundaries are subject to change. Please verify with the local district.</small>
          </div>

          <div class="tab-pane fade" id="colleges" role="tabpanel">
            <ul class="list-unstyled info-list">
              <li><i class="fas fa-graduation-cap me-2"></i> St. Joseph's College – 0.31 miles</li>
              <li><i class="fas fa-graduation-cap me-2"></i> Long Island University - Brooklyn – 0.46 miles</li>
              <li><i class="fas fa-graduation-cap me-2"></i> Pratt Institute – 0.51 miles</li>
              <li><i class="fas fa-graduation-cap me-2"></i> ASA College – 0.72 miles</li>
            </ul>
          </div>

          <div class="tab-pane fade" id="parks" role="tabpanel">
            <ul class="list-unstyled info-list">
              <li><i class="fas fa-tree me-2"></i> Fort Greene Park – 0.08 miles</li>
              <li><i class="fas fa-tree me-2"></i> Commodore Barry Park – 0.36 miles</li>
              <li><i class="fas fa-tree me-2"></i> Underwood Park – 0.44 miles</li>
            </ul>
          </div>

          <div class="tab-pane fade" id="museums" role="tabpanel">
             <ul class="list-unstyled info-list">
                <li><i class="fas fa-landmark me-2"></i> MoCADA – 0.55 miles</li>
                <li><i class="fas fa-landmark me-2"></i> Brooklyn Historical Society – 1.05 miles</li>
                <li><i class="fas fa-landmark me-2"></i> Brooklyn Museum – 1.59 miles</li>
              </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>







 <!-- Contact Section -->
<section id="contact" class="contact-section">
  <div class="container">
    <h2 class="text-center mb-4">Wait List</h2>
    <p class="text-center">
    Secure your place in line for exclusive priority access when leasing opportunities open to the public.
  </p>
    <form action="form-handler.php" method="POST" class="contact-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) ?>">

      <!-- Hidden Input for Unit -->
      <input type="hidden" id="unit" name="unit">

      <div class="row">
        <!-- First Name -->
        <div class="col-md-6 mb-3">
          <label for="firstName" class="form-label">First Name <span class="required">*</span></label>
          <input type="text" class="form-control" id="firstName" name="firstName" required>
          

        </div>
        <!-- Last Name -->
        <div class="col-md-6 mb-3">
          <label for="lastName" class="form-label">Last Name <span class="required">*</span></label>
          <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
      </div>

      <div class="row">
        <!-- Email -->
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email <span class="required">*</span></label>
          <input type="email" class="form-control email-input" id="email-contact" name="email" required>

        </div>
        
        <!-- Phone -->
        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label">Phone Number <span class="required">*</span></label>
          <input 
            type="tel" 
            class="form-control phone-input" 
            id="phone" 
            name="phone" 
            required 
            maxlength="14" 
            placeholder="(123) 456-7890">
        </div>
        

      </div>

      <div class="row">
        <!-- Move-In Date -->
        <div class="col-md-6 mb-3">
          <label for="moveInDate" class="form-label">Move-In Date</label>
          <input type="date" class="form-control" id="moveInDate" name="moveInDate">
        </div>
        
        <!-- Budget -->
        <div class="col-md-6 mb-3">
          <label for="budget" class="form-label">Budget</label>
          <input 
            type="text" 
            class="form-control budget-input" 
            id="budget-contact" 
            name="budget" 
            placeholder="$0">
        </div>
      </div>

      <div class="row">
        <!-- How Did You Hear About Us? -->
        <div class="col-md-6 mb-3">
          <label for="hearAboutUs" class="form-label">How Did You Hear About Us?</label>
          <select class="form-select" id="hearAboutUs" name="hearAboutUs">
            <option value="">Select an option</option>
            <option value="Google">Google</option>
            <option value="Friend">Friend</option>
            <option value="Social Media">Social Media</option>
            <option value="Advertisement">Advertisement</option>
          </select>
        </div>
        <!-- Unit Type -->
        <div class="col-md-6 mb-3">
          <label for="unitType" class="form-label">Unit Type</label>
          <select class="form-select" id="unitType" name="unitType" >
            <option value="">Select Unit Type</option>
            <option value="Studio">Studio</option>
            <option value="1 Bedroom">1 Bedroom</option>
            <option value="2 Bedroom">2 Bedroom</option>
            <option value="2 Bedroom">3 Bedroom</option>
          </select>
        </div>
      </div>

      <!-- Message -->
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="waitlistThankYou" class="waitlist-thankyou text-center">
      <h4>Thank you!</h4>
      <p>You've been added to the wait list. We’ll contact you as soon as leasing opens.</p>
    </div>

    
  </div>
</section>





<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row align-items-center">
      <!-- Left Section: Logo & Address -->
      <div class="col-md-4 text-center text-md-start">
        <a class="navbar-brand" href="#" style="font-family: 'QuorthonDarkIV', serif; font-weight: 700; color: var(--accent-color);">
          The Garrison
          <div class="navbar-address" style="font-size: 1rem; color: var(--text-color); font-family: Arial, sans-serif;">
            151 Carlton Avenue, Brooklyn, NY 11205
          </div>
        </a>
      </div>

      <!-- Center Section: Navigation Links -->
      <div class="col-md-4 text-center">
        <ul class="footer-links">
          <li><a href="#about">About</a></li>
          <li><a href="#luxury">Luxury Living</a></li>
          <li><a href="#amenities">Amenities</a></li>
          <li><a href="#neighborhood">Neighborhood</a></li>
          <li><a href="#contact">Wait List</a></li>
        </ul>
      </div>

      <!-- Right Section: Doorway Logo -->
      <div class="col-md-4 text-center text-md-end">
        <a href="https://doorway.nyc/" target="_blank" rel="noopener">
          <img src="assets/images/doorway-logo.png" alt="Doorway NYC" class="doorway-logo" />
        </a>
      </div>
    </div>

    <!-- Bottom Line -->
    <div class="footer-bottom">
      <p>&copy; 2025 The Garrison. All Rights Reserved.</p>
    </div>
  </div>
</footer>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="scripts/availability.js"></script>
  <script src="scripts/lightbox.js"></script>
  <script src="scripts/amenities.js"></script>
  <script src="scripts/email-list.js"></script>
  <script src="scripts/unit-interest.js"></script>
  <script src="scripts/wait-list.js"></script>
  <script src="scripts/popup-form.js" defer></script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const phoneInputs = document.querySelectorAll(".phone-input");

        phoneInputs.forEach((input) => {
          input.addEventListener("input", function () {
            let x = input.value.replace(/\D/g, '').substring(0, 10); // Only digits
            let formatted = '';

            if (x.length > 0) formatted += '(' + x.substring(0, 3);
            if (x.length >= 4) formatted += ') ' + x.substring(3, 6);
            if (x.length >= 7) formatted += '-' + x.substring(6, 10);

            input.value = formatted;
          });
        });
        
        const emailInputs = document.querySelectorAll(".email-input");

          emailInputs.forEach((input) => {
            input.addEventListener("input", function () {
              // Remove spaces and convert to lowercase
              input.value = input.value.replace(/\s/g, "").toLowerCase();

              // Optionally: Add simple visual feedback
              if (!input.value.includes("@") || !input.value.includes(".")) {
                input.classList.add("is-invalid");
              } else {
                input.classList.remove("is-invalid");
              }
            });
          });

          const budgetInputs = document.querySelectorAll(".budget-input");

            budgetInputs.forEach((input) => {
              input.addEventListener("input", function () {
                // Remove everything except digits and decimal
                let raw = input.value.replace(/[^\d.]/g, "");

                // Split into dollars and cents
                let parts = raw.split(".");
                let dollars = parts[0].replace(/^0+/, '') || "0";
                let cents = parts[1] || "";

                // Limit to 2 decimal places
                if (cents.length > 2) {
                  cents = cents.substring(0, 2);
                }

                // Add comma formatting
                dollars = dollars.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                input.value = `$${dollars}${cents.length ? "." + cents : ""}`;
              });

              // Optional: prevent typing letters
              input.addEventListener("keydown", function (e) {
                // Allow numbers, backspace, delete, arrows, tab, dot
                if (
                  !/[0-9.]/.test(e.key) &&
                  !["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"].includes(e.key)
                ) {
                  e.preventDefault();
                }
              });
            });


  
      // --- Carousel Setup ---
      const imageFiles = [
        "apartment.png", "bathroom1.png", "bathroom2.png", "building.png",
        "co-working.png", "corridor.png", "fitness.png", "lobby.png",
        "lounge.png", "rooftop.png"
      ];
  
      const carouselInner = document.getElementById("carouselImages");
  
      if (carouselInner) {
        imageFiles.forEach((image, index) => {
          let item = document.createElement("div");
          item.classList.add("carousel-item");
          if (index === 0) item.classList.add("active");
  
          let imgElement = document.createElement("img");
          imgElement.src = `assets/images/shuffle/${image}`;
          imgElement.classList.add("d-block", "w-100");
          imgElement.alt = "Gallery Image";
  
          item.appendChild(imgElement);
          carouselInner.appendChild(item);
        });
      }
    });
  </script>
  

      

</body>
</html>