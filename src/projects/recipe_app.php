<?php
/* Template Name: Project - Cursor Capturer */
require_once dirname(__FILE__, 6) . '/wp-load.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">Recipe <span class="highlight-red">App</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="../../assets/images/projects_header_images/recipe_app.jpg" alt="Recipe App" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>The Recipe App is a native Android application designed to help users discover and explore various culinary categories and recipes. Developed using Kotlin, the project demonstrates modern Android architecture by utilizing a MainViewModel for robust state management and seamless UI updates. The application actively connects with external data sources, employing an ApiService to fetch dynamic data and structure it using custom Category models. Featuring a clean user interface built with dedicated screen components like RecipeScreen and custom theme configurations, this application provides an intuitive and engaging experience for food enthusiasts.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Android Development</span>
                    <span>Kotlin</span>
                    <span>API Integration</span>
                    <span>MVVM Architecture</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Android_Development_Journey/tree/main/RecipeApp" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
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
