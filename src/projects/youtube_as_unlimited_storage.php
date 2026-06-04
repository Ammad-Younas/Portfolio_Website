<?php
/* Template Name: Project - Cursor Capturer */
require_once dirname(__FILE__, 6) . '/wp-load.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">YouTube as Unlimited <span class="highlight-red">Storage</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/yt_as_storage.png" alt="YouTube as Unlimited Storage" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>The YouTube As Unlimited Storage project is an inventive Python-based tool designed to utilize video hosting infrastructure as a free, infinite cloud storage solution. The core of the project relies on the convert_and_reverse.py script. This script functions as a two-way processing engine: it encodes standard data files into a video format suitable for uploading to YouTube, and it reverses the process to decode downloaded videos back into their original file formats.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Python</span>
                    <span>File Conversion</span>
                    <span>Data Encoding</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Youtube_As_Unlimited_Storage" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
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
