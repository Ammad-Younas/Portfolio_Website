<?php
/* Template Name: Project - Cursor Capturer */
require_once dirname(__FILE__, 6) . '/wp-load.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">Appointment <span class="highlight-red">Booking App</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="../../assets/images/projects_header_images/appointment_booking_app.jpg" alt="Appointment Booking App" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>The Medical Appointment Booking App is a robust, cross-platform solution developed with the Flutter framework and powered by a Firebase backend. Designed to bridge the gap between healthcare professionals and patients, the application offers distinct, tailored experiences for both user types.</p>
                
                <p>For patients, the app provides a seamless interface to browse doctors by medical category, view detailed professional profiles, and easily schedule or manage medical appointments. Doctors benefit from dedicated home and profile screens, alongside intuitive tools to efficiently track and manage their daily appointment rosters.</p>

                <p>Security and user experience are prioritized through a comprehensive authentication flow, which includes OTP verification, password recovery, and secure login and sign-up mechanisms. Additional features include an integrated push notification system to keep users updated on their bookings, dynamic theme settings for personalized UI customization, and an organized bottom navigation bar for effortless app traversal. The codebase is highly versatile and fully configured to compile natively across Android, iOS, Web, macOS, Windows, and Linux environments.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Flutter</span>    
                    <span>Dart</span>
                    <span>Firebase</span>
                    <span>Cross Platform Development</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Appointment_Booking_App" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
                    <a href="#" class="btn btn-secondary"><i class="fa-solid fa-arrow-up-right-from-square"></i> See Live Demo</a>
                </div>
            </div>
            
            <div class="text-center mt-4 animate-fade-up" style="animation-delay: 0.2s;">
                <a href="<?php echo home_url('/#projects'); ?>" class="btn-cert"><i class="fa-solid fa-arrow-left"></i> Back to Projects</a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
