<?php
/* Template Name: Blog List Page */
require_once dirname(__DIR__, 2) . '/includes/functions.php';
get_header();
?>

<main id="primary" class="site-main">
    <!-- HERO SECTION -->
    <section class="hero-section" style="padding-top: 150px; padding-bottom: 50px; position: relative;">
        <div class="hero-background-effects">
            <div class="glow-orb red-orb"></div>
        </div>
        
        <!-- Far left positioned back button -->
        <div style="position: absolute; top: 120px; left: 40px; z-index: 10;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-cert-small" style="display: inline-block;"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
        </div>

        <div class="container text-center animate-fade-up">
            <h1 class="hero-title">My <span class="highlight-orange">Blog</span></h1>
            <p class="hero-description mx-auto" style="max-width: 700px;">
                Thoughts, tutorials, and deep dives into software engineering, Android development, and more.
            </p>
        </div>
    </section>

    <!-- BLOG LIST SECTION -->
    <section class="section-padding dark-bg">
        <div class="container">
            
            <div class="timeline-grid mt-5" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin: 0 auto;">
                
                <!-- Blog Card 1 -->
                <div class="project-card glass-card animate-fade-up" style="display: flex; flex-direction: column;">
                    <div class="project-content" style="padding: 30px; display: flex; flex-direction: column; height: 100%;">
                        <h3 class="project-title" style="font-size: 1.5rem; line-height: 1.4; margin-bottom: 10px;">
                            Android Interview Questions & Answers
                        </h3>
                        
                        <div style="font-size: 0.9rem; color: #a0a0a0; margin-bottom: 15px;">
                            <i class="fa-regular fa-calendar" style="color: var(--color-orange); margin-right: 8px;"></i> 
                            October 25, 2023
                        </div>
                        
                        <p class="project-desc" style="flex-grow: 1;">
                            A comprehensive guide of real scenario-based Android interview questions with in-depth explanations. Ideal for mid to senior-level developers.
                        </p>
                        
                        <div class="project-tags mt-3 mb-4">
                            <span>Android</span>
                            <span>Interview</span>
                            <span>Kotlin</span>
                            <span>Architecture</span>
                        </div>
                        
                        <div class="mt-auto">
                            <a href="<?php echo esc_url(home_url('/src/blog/blogs/android-interview-questions-answers-real-scenario-based-with-in-depth-explanations.php')); ?>" class="btn-cert-small w-100 text-center" style="display: block;">Read More</a>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </section>
</main>

<?php get_footer(); ?>
