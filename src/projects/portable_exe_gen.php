<?php
/* Template Name: Project - Cursor Capturer */
require_once dirname(__DIR__, 2) . '/includes/functions.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">Portable EXE <span class="highlight-red">Generator</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/portable_exe_gen.png" alt="Portable EXE Generator" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>The Portable EXE Generator is a software packaging utility centered around a Python script named py2exe.pyw. This tool is designed to convert and compile code into standalone, portable executable files. To facilitate the creation of these portable packages, the project incorporates a Default.SFX self-extracting archive module. The repository also contains interface assets such as files_img.png and a custom Logo.ico located in the icon directory, alongside a generated executable file named cyber-spider.exe.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Python</span>
                    <span>Automation</span>
                    <span>SFX Archive</span>
                    <span>Executable Generator</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Portable_EXE_Generator" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
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

