<?php
/* Template Name: Blog List Page */
require_once dirname(__DIR__, 2) . '/includes/functions.php';
get_header();

// Helper function to parse simple markdown frontmatter
function parse_md_file($filepath) {
    $content = file_get_contents($filepath);
    $meta = [];
    $body = $content;
    
    if (strpos($content, '---') === 0) {
        $parts = explode('---', $content, 3);
        if (count($parts) >= 3) {
            $frontmatter = $parts[1];
            $body = $parts[2];
            
            $lines = explode("\n", trim($frontmatter));
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $val) = explode(':', $line, 2);
                    $key = trim($key);
                    $val = trim(trim($val), "'\"");
                    if ($key === 'tags') continue; // Handled below
                    $meta[$key] = $val;
                }
            }
            if (preg_match('/tags:\s*\n((?:\s*-\s*.*\n?)+)/', $frontmatter, $matches)) {
                preg_match_all('/-\s*(.*)/', $matches[1], $tag_matches);
                $meta['tags'] = array_map(function($t) { return trim($t, " '\""); }, $tag_matches[1]);
            }
        }
    }
    return ['meta' => $meta, 'body' => trim($body), 'slug' => basename($filepath, '.md')];
}

// Fetch all MD files from the data directory
$data_dir = __DIR__ . '/data/';
$blog_files = glob($data_dir . '*.md');
$blogs = [];

foreach ($blog_files as $file) {
    $blogs[] = parse_md_file($file);
}

// Sort blogs by published date (descending)
usort($blogs, function($a, $b) {
    $dateA = isset($a['meta']['published']) ? strtotime($a['meta']['published']) : 0;
    $dateB = isset($b['meta']['published']) ? strtotime($b['meta']['published']) : 0;
    return $dateB - $dateA;
});
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
                
                <?php if (empty($blogs)): ?>
                    <p class="text-center w-100 text-muted">No blog posts found.</p>
                <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                        <div class="project-card glass-card animate-fade-up" style="display: flex; flex-direction: column;">
                            <div class="project-content" style="padding: 30px; display: flex; flex-direction: column; height: 100%;">
                                <h3 class="project-title" style="font-size: 1.5rem; line-height: 1.4; margin-bottom: 10px;">
                                    <?php echo esc_html($blog['meta']['title'] ?? 'Untitled'); ?>
                                </h3>
                                
                                <div style="font-size: 0.9rem; color: #a0a0a0; margin-bottom: 15px;">
                                    <i class="fa-regular fa-calendar" style="color: var(--color-orange); margin-right: 8px;"></i> 
                                    <?php 
                                        if (isset($blog['meta']['published'])) {
                                            echo esc_html(date('F j, Y', strtotime($blog['meta']['published'])));
                                        } else {
                                            echo 'Unknown Date';
                                        }
                                    ?>
                                </div>
                                
                                <p class="project-desc" style="flex-grow: 1;">
                                    <?php 
                                        $fallback_desc = substr(strip_tags($blog['body']), 0, 150) . '...';
                                        echo esc_html($blog['meta']['subtitle'] ?? $fallback_desc); 
                                    ?>
                                </p>
                                
                                <div class="project-tags mt-3 mb-4">
                                    <?php 
                                    if (isset($blog['meta']['tags']) && is_array($blog['meta']['tags'])) {
                                        foreach ($blog['meta']['tags'] as $tag) {
                                            echo '<span>' . esc_html($tag) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <div class="mt-auto">
                                    <a href="<?php echo esc_url(home_url('/src/blog/blog_detail_page.php?post=' . urlencode($blog['slug']))); ?>" class="btn-cert-small w-100 text-center" style="display: block;">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
            </div>
            
        </div>
    </section>
</main>

<?php get_footer(); ?>
