<?php
/* Template Name: Course Roadmap */
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
            <h1 class="hero-title">My Learning <span class="highlight-orange">Roadmap</span></h1>
            <p class="hero-description mx-auto" style="max-width: 700px;">
                Follow along with my learning journey. Select a module to start learning!
            </p>
        </div>
    </section>

    <!-- ROADMAP SECTION -->
    <section class="journey-section section-padding dark-bg">
        <div class="container">
            
            <div class="timeline-grid mt-5" style="grid-template-columns: 1fr; max-width: 800px; margin: 0 auto;">
                
                <!-- Roadmap Card 1 -->
                <div class="project-card glass-card animate-fade-up" style="display: flex; flex-direction: column;">
                    <div class="project-content" style="padding: 30px;">
                        <h3 class="project-title" style="font-size: 2rem;"><i class="fa-solid fa-graduation-cap highlight-orange" style="margin-right: 12px;"></i> Chapter 1: &nbsp; Android Basics</h3>
                        <p class="project-desc mt-3">
                            This module covers the core concepts and fundamental topics needed to build a strong base in development. Contains 37 video lessons ranging from beginner to intermediate.
                        </p>
                        <div class="project-tags mt-3">
                            <span>Android</span>
                            <span>Development</span>
                            <span>37 Lessons</span>
                        </div>
                        <div class="project-links mt-4">
                            <a href="<?php echo esc_url( home_url( '/src/courses/course/android-basics/' ) ); ?>" class="btn btn-primary" style="width: 100%; text-align: center;">
                                <i class="fa-solid fa-play" style="margin-right: 12px;"></i> Start Learning
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Future Roadmap Card Placeholder -->
                <div class="project-card glass-card animate-fade-up mt-4" style="display: flex; flex-direction: column; opacity: 0.6;">
                    <div class="project-content" style="padding: 30px;">
                        <h3 class="project-title" style="font-size: 2rem;"><i class="fa-solid fa-lock highlight-orange" style="margin-right: 12px;"></i> Phase 2: Advanced</h3>
                        <p class="project-desc mt-3">
                            Coming soon. Advanced topics, architecture, and production deployment strategies.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>




<?php get_footer(); ?>

