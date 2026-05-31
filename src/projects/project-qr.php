<?php
/* Template Name: Project - QR Generator */
require_once dirname(__FILE__, 6) . '/wp-load.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">QR <span class="highlight-orange">Generator</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="QR Generator" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>The QR Generator is a robust software application built using Python and the Tkinter GUI library. It allows users to quickly generate QR codes from text, URLs, or other data, and save them as images. It also features a decoding tool that can read existing QR codes and display their underlying data.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Python</span>
                    <span>Tkinter</span>
                    <span>GUI</span>
                    <span>Qrcode Library</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/QR_Generator" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
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
