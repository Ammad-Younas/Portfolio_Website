<?php
/* Template Name: Project - Maze Generator */
require_once dirname(__FILE__, 6) . '/wp-load.php';
get_header();
?>

<main id="primary" class="site-main">
    <section class="project-detail-section section-padding">
        <div class="container">
            <div class="project-detail-header text-center animate-fade-up">
                <h1 class="section-title">Maze <span class="highlight-red">Generator</span></h1>
                <div class="section-line mx-auto"></div>
            </div>

            <div class="project-detail-content glass-card mt-4 animate-fade-up" style="animation-delay: 0.1s;">
                <img src="https://images.unsplash.com/photo-1516259762381-22954d7d3ad2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Maze Generator" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h3>About This Project</h3>
                <p>An algorithmic project focused on generating random mazes and solving them. It implements the Depth-First Search (DFS) algorithm to ensure a perfect maze is created with exactly one solution between the start and end points. The project serves as an excellent demonstration of recursion and graph theory in action.</p>
                
                <h3 class="mt-4">Tech Stack</h3>
                <div class="project-tags">
                    <span>Python</span>
                    <span>Algorithms</span>
                    <span>DFS</span>
                    <span>Data Structures</span>
                </div>

                <div class="project-actions mt-4">
                    <a href="https://github.com/Ammad-Younas/Maze_Generator_and_Solver_Using_DFS" target="_blank" class="btn btn-primary"><i class="fa-brands fa-github"></i> View Repository</a>
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
