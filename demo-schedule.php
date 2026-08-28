<?php
session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'includes/content-loader.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JGNGZY633"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-8JGNGZY633');
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo display_text('site_info', 'title', 'Kaizen Karate | Traditional Martial Arts Training'); ?> | Demo Schedule</title>
  <meta name="description" content="Weekend & Evening (After School) schedule, filters, registration, and disclaimer.">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/demo-schedule.css?v=<?php echo time(); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png?v=2">
  <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg?v=2">
  <link rel="icon" type="image/x-icon" href="favicon/favicon.ico?v=2">
  <link rel="manifest" href="favicon/site.webmanifest?v=2">
  <link rel="stylesheet" type="text/css" href="assets/fonts/MyWebfontsKit/MyWebfontsKit.css">
</head>
<body>
<?php include 'includes/nav.php'; ?>

<?php
$after_school = get_content('after_school');
?>
<section id="after-school" class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); color: white; margin-top:100px;">
  <div class="container">
    <h2 class="text-center mb-5" style="color: white; font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700;"><span style="text-decoration: underline; text-underline-offset: 0.3em; text-decoration-color: #dc3545;"><?php echo display_text('after_school', 'title', 'Weekend & Evening'); ?></span></h2>
    
    <!-- Schedule Integration Section -->
    <div class="schedule-integration mt-5">
      <div id="schedule-container" class="demo-schedule-container">
        
          <div style="text-align: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 2px solid rgba(220, 53, 69, 0.2);">
            <h3 style="color: #dc3545; font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; margin-bottom: 2rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
              <i class="fas fa-calendar-alt" style="margin-right: 0.75rem; font-size: 1.8rem; opacity: 0.9;"></i>
              2026 January / February Class Calendar
            </h3>
            
            <!-- Info Badges -->
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; align-items: center;">
              <!-- Duration Badge -->
              <div style="background: rgba(255, 255, 255, 0.95); border: 2px solid #dc3545; border-radius: 25px; padding: 0.75rem 1.5rem; display: flex; align-items: center; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2); backdrop-filter: blur(10px);">
                <i class="fas fa-clock" style="color: #dc3545; font-size: 1.1rem; margin-right: 0.6rem;"></i>
                <span style="color: #333; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.3px;">One-hour classes unless stated otherwise</span>
              </div>
              
              <!-- Location Badge -->
              <div style="background: rgba(255, 255, 255, 0.95); border: 2px solid #dc3545; border-radius: 25px; padding: 0.75rem 1.5rem; display: flex; align-items: center; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2); backdrop-filter: blur(10px);">
                <i class="fas fa-home" style="color: #dc3545; font-size: 1.1rem; margin-right: 0.6rem;"></i>
                <span style="color: #333; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.3px;">All Classes Held Indoors/In-Person</span>
              </div>
            </div>
          </div>

          <!-- Top Scrollbar -->
          <div id="top-scroll-wrapper" class="top-scroll-wrapper">
            <div id="top-scroll-dummy" class="top-scroll-dummy"></div>
          </div>

          <!-- Table Wrapper -->
          <div id="table-scroll-wrapper" class="table-scroll-wrapper">
            <table id="schedule-table">
              <thead>
                  <tr>
                      <th>MON</th>
                      <th>TUE</th>
                      <th>WED</th>
                      <th>THU</th>
                      <th>FRI</th>
                      <th>SAT</th>
                      <th>SUN</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Calvary</div>
                              <div>All Belts</div>
                              <div>6:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Calvary</div>
                              <div>All Belts</div>
                              <div>7:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block youth-adult">
                              <div class="class-name">A-East Silver Spring ES</div>
                              <div>7:30 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                      </td>
                      <td>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Cleveland Park Club</div>
                              <div>All Belts</div>
                              <div>6:30 pm</div>
                              <div class="location">NW DC</div>
                          </div>
                          <div class="class-block adult-only">
                              <div class="class-name">A-Kemp Mill ES</div>
                              <div>Fundamentals</div>
                              <div>7:30 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                      </td>
                      <td>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-ACC</div>
                              <div>White-Purple Belts</div>
                              <div>6:30 pm</div>
                              <div class="location">Arlington VA</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Bayard Rustin ES</div>
                              <div>All Belts</div>
                              <div>6:30 pm</div>
                              <div class="location">Rockville MD</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-LCR</div>
                              <div>White-Purple Belts</div>
                              <div>6:30 pm</div>
                              <div class="location">Capitol Hill DC</div>
                          </div>
                          <div class="class-block adult-only">
                              <div class="class-name">A-ACC</div>
                              <div>7:30 pm</div>
                              <div class="location">Arlington VA</div>
                          </div>
                      </td>
                      <td>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Calvary</div>
                              <div>All Belts</div>
                              <div>6:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-ACC</div>
                              <div>White-Green Belts</div>
                              <div>6:30 pm</div>
                              <div class="location">Arlington VA</div>
                          </div>
                          <div class="class-block youth-adult">
                              <div class="class-name">Y/A-Calvary</div>
                              <div>Sparring</div>
                              <div>7:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                      </td>
                      <td>
                          <div class="class-block open-mat">
                              <div class="class-name">A-Calvary</div>
                              <div>Open Mat</div>
                              <div>6:30 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                      </td>
                      <td>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-St. Paul's Lutheran</div>
                              <div>Beginner #1 10 am</div>
                              <div>Beginner #2 11 am</div>
                              <div>Interm./Adv. 12 pm</div>
                              <div class="location">NW DC</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Reid Temple AME Church</div>
                              <div>Beginner #1 9am</div>
                              <div>Beginner #2/Interm. 10am</div>
                              <div class="location">Glenn Dale MD</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Pine Crest ES</div>
                              <div>Little Ninja/Beg. 11:00 am</div>
                              <div>Interm./Adv. 12pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-Christ Church + Washington Parish</div>
                              <div>Beginner 12:00 pm</div>
                              <div>Beginner 1:00 pm</div>
                              <div>Interm./Adv. 2:00 pm</div>
                              <div class="location">Capitol Hill DC</div>
                          </div>
                          <div class="class-block adult-only">
                              <div class="class-name">A-Pine Crest ES</div>
                              <div>1:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                      </td>
                      <td>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-East Silver Spring ES</div>
                              <div>Little Ninja 10:00 -10:30 am</div>
                              <div>Beginner 10:00 -11:00 am</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block youth-only">
                              <div class="class-name">Y-East Silver Spring ES</div>
                              <div>Intermediate</div>
                              <div>11:00 am</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block open-mat">
                              <div class="class-name">Y/A-East Silver Spring ES</div>
                              <div>Open Mat/ Test Prep.</div>
                              <div>12:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block master-form-kenpo">
                              <div class="class-name">Y/A-East Silver Spring ES</div>
                              <div>Master Form / Kenpo</div>
                              <div>1:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                          <div class="class-block youth-adult">
                              <div class="class-name">Y/A-East Silver Spring ES</div>
                              <div>Brown & Red Belts</div>
                              <div>2:00 pm</div>
                              <div class="location">Silver Spring MD</div>
                          </div>
                      </td>
                  </tr>
              </tbody>
            </table>
          </div>

          <div class="legend">
              <h3>LEGEND</h3>
              <p><strong>Y:</strong> Youth | <strong>A:</strong> Adult (13 yrs+)</p>
              <p><strong>Y-Little Ninja:</strong> 3.5 – 4 yrs</p>
              <p><strong>Y-Beginner:</strong> 5 yrs+/White-Yellow</p>
              <p><strong>Y-Intermediate:</strong> Green-Blue</p>
              <p><strong>Y-Advanced:</strong> Brown-Red</p>
              <p><strong>Master Form:</strong> Y/A-Green and up</p>
              <div class="legend-items">
                  <div class="legend-color">
                      <div class="legend-box" style="background-color: #fff;"></div>
                      <span>Youth Only</span>
                  </div>
                  <div class="legend-color">
                      <div class="legend-box" style="background-color: #f0f0f0;"></div>
                      <span>Youth/Adult</span>
                  </div>
                  <div class="legend-color">
                      <div class="legend-box" style="background-color: #e0e0e0; border-color: #999;"></div>
                      <span>Adult Only</span>
                  </div>
                  <div class="legend-color">
                      <div class="legend-box" style="background-color: #ffcccc;"></div>
                      <span>Open Mat</span>
                  </div>
                  <div class="legend-color">
                      <div class="legend-box" style="background-color: #ff9999;"></div>
                      <span>Master Form/ Jujitsu</span>
                  </div>
                  <div class="legend-color">
                      <div class="legend-box" style="background-color: #8B0000;"></div>
                      <span>Master Form / Kenpo</span>
                  </div>
              </div>
          </div>



      </div>
    </div>

    <!-- Sept-Oct Schedule and Registration Containers -->
    <div class="row justify-content-center g-4 mt-5">
      <!-- Sept - Oct Schedule -->
      <div class="col-lg-6">
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 2rem; border: 1px solid rgba(255, 255, 255, 0.1); text-align: center; height: 100%;">
          <h3 style="color: #dc3545; font-size: 1.5rem; margin-bottom: 1.5rem; font-weight: 600;"><?php echo display_text('after_school', 'schedule.title', 'September - October Schedule'); ?></h3>
          
          <!-- Calendar Preview -->
          <div style="position: relative; margin-bottom: 1.5rem;">
            <img src="<?php echo display_text('after_school', 'schedule.preview_image', 'assets/images/aftersschool/sep-oct-karate.png'); ?>" 
                 alt="September - October Karate Schedule" 
                 style="width: 100%; max-width: 400px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); cursor: pointer;"
                 onclick="openCalendarPreview()"
                 onmouseover="this.style.transform='scale(1.02)'; this.style.transition='all 0.3s ease';"
                 onmouseout="this.style.transform='scale(1)'; this.style.transition='all 0.3s ease';">
          </div>
          
          <!-- Download Button -->
          <a href="<?php echo display_text('after_school', 'schedule.pdf_file', 'assets/images/aftersschool/2025-Sep-Oct-Karate-Class-Calendar-v2.pdf'); ?>" 
            download="Kaizen-Karate-Sept-Oct-2025.pdf"
             style="background: rgba(220, 53, 69, 0.2); color: white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-block; border: 1px solid rgba(220, 53, 69, 0.4); transition: all 0.3s ease;"
             onmouseover="this.style.background='rgba(220, 53, 69, 0.3)'; this.style.borderColor='#dc3545';"
             onmouseout="this.style.background='rgba(220, 53, 69, 0.2)'; this.style.borderColor='rgba(220, 53, 69, 0.4)';">
            <i class="fas fa-download" style="margin-right: 0.5rem;"></i>
<?php echo display_text('after_school', 'schedule.download_text', 'Download Schedule'); ?>
          </a>
            </div>
          </div>
      
      <!-- Registration Button -->
      <div class="col-lg-6">
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 2rem; border: 1px solid rgba(255, 255, 255, 0.1); text-align: center; display: flex; flex-direction: column; justify-content: center; height: 100%;">
          <h3 style="color: white; font-size: 1.8rem; margin-bottom: 2rem; font-weight: 600;"><?php echo display_text('after_school', 'registration.title', 'Ready to Enroll?'); ?></h3>
          
          <a href="<?php echo display_text('after_school', 'registration.button_url', 'https://www.gomotionapp.com/team/mdkfu/page/class-registration'); ?>" 
             target="_blank"
             style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.5rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.3rem; display: inline-block; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4); border: none; margin: 0 auto;"
             onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.6)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.4)';">
            <i class="fas fa-user-plus" style="margin-right: 0.8rem; font-size: 1.2rem;"></i>
            <?php echo display_text('after_school', 'registration.button_text', 'Register Now'); ?>
          </a>
          
          <p style="color: #e9ecef; margin-top: 1.5rem; font-size: 0.95rem; opacity: 0.8;">
<?php echo display_text('after_school', 'registration.subtext', 'Secure your spot in our programs'); ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Disclaimer Text -->
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <p style="color: #e9ecef; font-size: 0.9rem; text-align: center; line-height: 1.5; opacity: 0.8;">
<?php echo display_text('after_school', 'disclaimer.text', 'Not all classes are listed. If you do not see your program listed then please'); ?> 
          <a href="<?php echo display_text('after_school', 'disclaimer.link_url', '#contact'); ?>" style="color: #dc3545; text-decoration: underline; transition: color 0.2s ease;"
             onmouseover="this.style.color='#ff6b7a';"
             onmouseout="this.style.color='#dc3545';"><?php echo display_text('after_school', 'disclaimer.link_text', 'contact our office'); ?></a> 
          <?php echo display_text('after_school', 'disclaimer.end_text', 'directly for more information.'); ?>
        </p>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'includes/footer-dynamic.php';
render_footer('live');
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/nav.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const topScrollWrapper = document.getElementById('top-scroll-wrapper');
    const topScrollDummy = document.getElementById('top-scroll-dummy');
    const tableScrollWrapper = document.getElementById('table-scroll-wrapper');
    const scheduleTable = document.getElementById('schedule-table');

    // Function to update dimensions
    function updateDimensions() {
        if (scheduleTable && topScrollDummy) {
            topScrollDummy.style.width = scheduleTable.offsetWidth + 'px';
        }
    }

    // Initial update
    updateDimensions();

    // Update on resize
    window.addEventListener('resize', updateDimensions);

    // Sync scroll
    if (topScrollWrapper && tableScrollWrapper) {
        topScrollWrapper.addEventListener('scroll', function() {
            tableScrollWrapper.scrollLeft = topScrollWrapper.scrollLeft;
        });

        tableScrollWrapper.addEventListener('scroll', function() {
            topScrollWrapper.scrollLeft = tableScrollWrapper.scrollLeft;
        });
    }
});
</script>
</body>
</html>
