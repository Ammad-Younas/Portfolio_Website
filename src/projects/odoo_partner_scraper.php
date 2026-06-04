<?php
/* Template Name: Project - Cursor Capturer */
require_once dirname(__DIR__, 2) . '/includes/functions.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">Odoo <span class="highlight-red">Partner Scraper</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/odoo_partner_scraper.jpg" alt="Odoo Partner Scraper" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>The Odoo Scraper is a Python-based data extraction tool specifically built to gather partner information from Odoo environments. The core functionality is driven by the odoo_partner_scraper.py script, which automates the retrieval process. The project is structured with a dedicated requirements.txt file to seamlessly manage Python dependencies and ensure easy setup and execution for web scraping tasks.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Python</span>
                    <span>Automation</span>
                    <span>Web Scraping</span>
                    <span>Odoo</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Odoo_Scraper" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
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

