<?php
/* Template Name: Project - Cursor Capturer */
require_once dirname(__FILE__, 6) . '/wp-load.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">Under <span class="highlight-red">Byte</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/under_byte.jpg" alt="Under Byte" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>Structured as a comprehensive Final Year Project, Under Byte is a native Android chat application built to showcase modern mobile development practices. Developed entirely in Kotlin, the application features a robust messaging system where users can seamlessly create or join dedicated chat rooms. It demonstrates strong architectural implementation through rich media support, allowing users to share files, preview media, and record or play audio directly within the interface. To ensure performance, the app utilizes a local Room database for media caching and data persistence, paired with Retrofit for efficient backend API communication. A unique technical highlight of the application is its custom steganography integration, providing specialized tools to embed and process hidden data within media files.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Android Development</span>
                    <span>Kotlin</span>
                    <span>Steganography</span>
                    <span>Mobile Chat Application</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Under-Byte" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
                    <a href="https://play.google.com/store/apps/details?id=com.madirwx.underbyte" target="_blank" class="btn btn-secondary"><i class="fa-solid fa-arrow-up-right-from-square"></i> See Live Demo</a>
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
