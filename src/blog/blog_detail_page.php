<?php
/* Template Name: Blog Detail Page */
require_once dirname(__DIR__, 2) . '/includes/functions.php';

$post_slug = isset($_GET['post']) ? sanitize_text_field($_GET['post']) : '';

if (empty($post_slug)) {
    wp_redirect(home_url('/src/blog/blog_list_page.php'));
    exit;
}

$post_slug = preg_replace('/[^a-zA-Z0-9\-_]/', '', $post_slug);
$md_file = __DIR__ . '/data/' . $post_slug . '.md';
$blog_data = null;

if (file_exists($md_file)) {
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
                        if ($key === 'tags') continue; 
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
    
    $blog_data = parse_md_file($md_file);
    
    // Extract Q&A blocks using regex
    $qna = [];
    $body = $blog_data['body'];
    if (preg_match_all('/(### Q\d+\.\s+.*?\n)(.*?)(?=(?:### Q\d+\.\s+.*?\n)|(?:### Section)|$)/s', $body, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $question = trim($match[1]);
            if (strpos($question, '### ') === 0) {
                $question = substr($question, 4);
            }
            $answer = trim($match[2]);
            $qna[] = ['question' => $question, 'answer' => $answer];
        }
    }
    $blog_data['qna'] = $qna;
}

if (!$blog_data) {
    get_header();
    ?>
    <main id="primary" class="site-main">
        <section class="section-padding dark-bg" style="padding-top: 150px; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
            <div class="text-center">
                <h2>Post Not Found</h2>
                <p>The blog post you are looking for does not exist.</p>
                <a href="<?php echo esc_url(home_url('/src/blog/blog_list_page.php')); ?>" class="btn-cert mt-4">Back to Blog</a>
            </div>
        </section>
    </main>
    <?php
    get_footer();
    exit;
}

get_header();
?>
<!-- Include Marked.js for markdown rendering -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<!-- Include highlight.js for code highlighting -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" id="highlight-theme">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

<style>
/* Custom styling for markdown content inside the blog */
.blog-content {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #e0e0e0;
}
.blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4 {
    color: #ffffff;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}
.blog-content h1 { font-size: 2.2rem; }
.blog-content h2 { font-size: 1.8rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; }
.blog-content h3 { font-size: 1.5rem; }
.blog-content p {
    margin-bottom: 1.5rem;
}
.blog-content ul, .blog-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}
.blog-content li {
    margin-bottom: 0.5rem;
}
.blog-content pre {
    background-color: #1e1e1e;
    padding: 2.5rem 1rem 1rem 1rem; /* Extra top padding for copy button */
    border-radius: 8px;
    overflow-x: auto;
    border: 1px solid rgba(128,128,128,0.2);
    margin-bottom: 1.5rem;
    position: relative;
}
.blog-content code {
    background-color: rgba(255,255,255,0.1);
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-family: monospace;
    font-size: 0.9em;
    color: var(--highlight-orange, #ff6b6b);
}
.blog-content pre code {
    background-color: transparent;
    padding: 0;
    color: inherit;
}
.blog-content blockquote {
    border-left: 4px solid var(--color-red, #e50914);
    padding-left: 1rem;
    margin-left: 0;
    font-style: italic;
    color: #a0a0a0;
}
.blog-content a {
    color: var(--color-red, #e50914);
    text-decoration: underline;
}
.blog-content a:hover {
    color: var(--highlight-orange, #ff6b6b);
}
.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}

/* Light mode overrides for blog content */
body.light-mode .blog-content { color: #333333; }
body.light-mode .blog-content h1, 
body.light-mode .blog-content h2, 
body.light-mode .blog-content h3, 
body.light-mode .blog-content h4 { color: #1a1a1a; }
body.light-mode .blog-content h2 { border-bottom: 1px solid rgba(0,0,0,0.1); }
body.light-mode .blog-content pre { 
    background-color: #eef2f5 !important; /* More distinct background for code blocks */
    border: 1px solid rgba(0,0,0,0.15); 
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
}
body.light-mode .blog-content code { 
    background-color: rgba(0,0,0,0.06); 
    color: var(--color-red, #e50914); 
}
body.light-mode .blog-content pre code,
body.light-mode .blog-content pre code.hljs { 
    background-color: transparent !important;
    color: #24292e; 
}
body.light-mode .blog-content blockquote { color: #666666; }

/* Copy Code Button */
.code-wrapper {
    position: relative;
}
.copy-code-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: #e0e0e0;
    padding: 5px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    z-index: 5;
}
.copy-code-btn:hover {
    background: var(--color-orange);
    color: #fff;
    border-color: var(--color-orange);
}
body.light-mode .copy-code-btn {
    background: rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.1);
    color: #333;
}
body.light-mode .copy-code-btn:hover {
    background: var(--color-orange);
    color: #fff;
    border-color: var(--color-orange);
}
</style>

<main id="primary" class="site-main">
    <section class="section-padding dark-bg" style="padding-top: 150px; position: relative;">
        
        <!-- Back button -->
        <div style="position: absolute; top: 120px; left: 40px; z-index: 10;">
            <a href="<?php echo esc_url(home_url('/src/blog/blog_list_page.php')); ?>" class="btn-cert-small player-back-btn" style="display: inline-block; color: var(--color-orange);"><i class="fa-solid fa-arrow-left"></i> Back to Blogs</a>
        </div>

        <div class="container" style="max-width: 900px;">
            
            <article class="glass-card" style="padding: 40px; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                
                <header style="margin-bottom: 40px; text-align: center;">
                    <h1 style="font-size: 2.5rem; line-height: 1.3; margin-bottom: 20px;">
                        <?php echo esc_html($blog_data['meta']['title'] ?? 'Untitled'); ?>
                    </h1>
                    
                    <?php if (!empty($blog_data['meta']['subtitle'])): ?>
                        <p style="font-size: 1.2rem; color: #a0a0a0; margin-bottom: 20px;">
                            <?php echo esc_html($blog_data['meta']['subtitle']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div style="color: var(--color-orange); font-size: 1rem; margin-bottom: 20px;">
                        <i class="fa-regular fa-calendar" style="margin-right: 8px;"></i>
                        <?php 
                            if (isset($blog_data['meta']['published'])) {
                                echo esc_html(date('F j, Y', strtotime($blog_data['meta']['published'])));
                            } else {
                                echo 'Unknown Date';
                            }
                        ?>
                    </div>
                    
                    <div class="project-tags justify-content-center">
                        <?php 
                        if (isset($blog_data['meta']['tags']) && is_array($blog_data['meta']['tags'])) {
                            foreach ($blog_data['meta']['tags'] as $tag) {
                                echo '<span>' . esc_html($tag) . '</span>';
                            }
                        }
                        ?>
                    </div>
                </header>
                
                <div class="section-line" style="margin-bottom: 40px;"></div>
                
                <div class="blog-content">
                    <?php 
                        if (!empty($blog_data['qna'])) {
                            echo '<div class="qna-container">';
                            $counter = 1;
                            foreach ($blog_data['qna'] as $qa) {
                                echo '<div class="qna-block" style="margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.05);">';
                                
                                // Question styling
                                echo '<h2 class="qna-question" style="font-size: 1.6rem; color: var(--highlight-orange); margin-bottom: 20px; display: flex; align-items: flex-start; gap: 15px;">';
                                echo '<span style="flex-grow: 1; padding-top: 4px;">' . esc_html($qa['question']) . '</span>';
                                echo '</h2>';
                                
                                // Answer styling
                                echo '<div class="qna-answer" style="padding-left: 15px; border-left: 2px solid rgba(128,128,128,0.2); margin-left: 20px;" data-md="' . base64_encode($qa['answer']) . '">';
                                echo '</div>';
                                
                                echo '</div>';
                                $counter++;
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="blog-fallback-body" data-md="' . base64_encode($blog_data['body']) . '"></div>';
                        }
                    ?>
                </div>
                
            </article>
            
        </div>
    </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Helper to process markdown blocks and add copy buttons
    function processMarkdownBlocks(selector) {
        document.querySelectorAll(selector).forEach(function(el) {
            if(el.dataset.md) {
                var rawMd = decodeURIComponent(escape(window.atob(el.dataset.md)));
                el.innerHTML = marked.parse(rawMd);
                el.classList.add('blog-content'); // Apply custom styles
                
                // Add copy buttons and highlight to all pre blocks
                el.querySelectorAll('pre').forEach(function(preBlock) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'code-wrapper';
                    preBlock.parentNode.insertBefore(wrapper, preBlock);
                    wrapper.appendChild(preBlock);
                    
                    var codeEl = preBlock.querySelector('code');
                    if (codeEl) {
                        hljs.highlightElement(codeEl);
                    }
                    
                    var btn = document.createElement('button');
                    btn.className = 'copy-code-btn';
                    btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy';
                    
                    btn.addEventListener('click', function() {
                        var code = codeEl ? codeEl.innerText : preBlock.innerText;
                        navigator.clipboard.writeText(code).then(function() {
                            btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                            setTimeout(function() { 
                                btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy'; 
                            }, 2000);
                        });
                    });
                    
                    wrapper.appendChild(btn);
                });
            }
        });
    }

    // Render Q&A and fallback blocks
    processMarkdownBlocks('.qna-answer');
    processMarkdownBlocks('.blog-fallback-body');
    
    // Toggle highlight theme based on light/dark mode
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === "class") {
                var isLight = document.body.classList.contains('light-mode');
                var themeLink = document.getElementById('highlight-theme');
                if (isLight) {
                    themeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css';
                } else {
                    themeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css';
                }
            }
        });
    });
    observer.observe(document.body, { attributes: true });
    
    // Initialize correct highlight theme on load
    if (document.body.classList.contains('light-mode')) {
        document.getElementById('highlight-theme').href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css';
    }
});
</script>

<?php get_footer(); ?>
