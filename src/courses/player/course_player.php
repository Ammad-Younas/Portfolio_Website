<?php
require_once dirname(__FILE__, 7) . '/wp-load.php';

$json_path = get_template_directory() . '/src/courses/data/videos.json';
$videos = [];
if (file_exists($json_path)) {
    $json_data = file_get_contents($json_path);
    $videos = json_decode($json_data, true);
}

$course_title = isset($_GET['course']) ? ucwords(str_replace('-', ' ', $_GET['course'])) : 'Course';
$course_phase = isset($_GET['phase']) ? ucwords(str_replace('-', ' ', $_GET['phase'])) : 'Phase 1: Foundation';

get_header();
?>
<main id="primary" class="site-main">
    <section class="section-padding dark-bg" style="padding-top: 120px;">
        <div class="container-fluid" style="width: 100%; max-width: 100%; padding: 0 20px;">
            
            <div class="player-header mb-4">
                <a href="<?php echo esc_url( get_template_directory_uri() . '/src/courses/course_roadmap.php' ); ?>" class="btn-cert-small" style="display: inline-block; margin-bottom: 20px;"><i class="fa-solid fa-arrow-left"></i> Back to Roadmap</a>
                <h2 class="section-title" id="course-title"><?php echo esc_html($course_phase); ?></h2>
            </div>

            <div class="course-player-grid">
                
                <!-- Left Side: Video Player & Description -->
                <div class="player-main-col">
                    <div class="video-container glass-card" style="padding: 10px; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div class="responsive-iframe" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                            <!-- The iframe src will be set by JS. Initially load the first video if available -->
                            <?php if (!empty($videos)): ?>
                                <iframe id="youtube-player" src="https://www.youtube.com/embed/<?php echo esc_attr($videos[0]['youtube_id']); ?>?rel=0&modestbranding=1" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            {% else %}
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #000; color: #fff;">No videos available</div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3 text-center">
                            <a id="fallback-youtube-link" href="https://www.youtube.com/watch?v=<?php echo esc_attr($videos[0]['youtube_id']); ?>" target="_blank" class="btn btn-outline-danger btn-sm" style="font-size: 0.8rem;">
                                <i class="fa-brands fa-youtube" style="margin-right: 3px;"></i> Play on YT
                            </a>
                        </div>
                    </div>
                    
                    <div class="video-details glass-card mt-4" style="padding: 25px; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <?php if (!empty($videos)): ?>
                            <h3 id="current-video-title" class="mb-3"><?php echo esc_html($videos[0]['title']); ?></h3>
                            <div class="video-meta mb-3" style="color: var(--highlight-orange); font-size: 0.9rem;">
                                <i class="fa-regular fa-clock"></i> <span id="current-video-duration"><?php echo esc_html($videos[0]['duration']); ?></span>
                            </div>
                            <div class="section-line" style="margin-left: 0; margin-bottom: 20px;"></div>
                            <p id="current-video-desc" class="text-muted">
                                <?php echo esc_html($videos[0]['description']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Side: Scrollable Playlist -->
                <div class="player-playlist-col">
                    <div class="playlist-container glass-card" style="height: 100%; max-height: 800px; display: flex; flex-direction: column; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div class="playlist-header" style="padding: 20px; border-bottom: 1px solid rgba(128,128,128,0.2);">
                            <h3 style="margin: 0; font-size: 1.2rem;">Course Content</h3>
                            <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);"><?php echo count($videos); ?> Lessons</p>
                        </div>
                        
                        <div class="playlist-items" style="overflow-y: auto; padding: 10px; flex-grow: 1;">
                            <?php $forloop_first = true; foreach ($videos as $video): ?>
                            <div class="playlist-item <?php echo $forloop_first ? 'active' : ''; ?>" 
                                 onclick="playVideo('<?php echo esc_attr($video['youtube_id']); ?>', '<?php echo esc_js($video['title']); ?>', '<?php echo esc_html($video['duration']); ?>', '<?php echo esc_js($video['description']); ?>', this)">
                                <div class="item-number"><?php echo esc_html($video['id']); ?></div>
                                <div class="item-details">
                                    <h4 class="item-title"><?php echo esc_html($video['title']); ?></h4>
                                    <span class="item-duration"><i class="fa-regular fa-clock"></i> <?php echo esc_html($video['duration']); ?></span>
                                </div>
                                <div class="item-play-icon">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                            </div>
                            <?php $forloop_first = false; endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<style>
    .course-player-grid {
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 30px;
        align-items: start;
    }
    
    @media (max-width: 991px) {
        .course-player-grid {
            grid-template-columns: 1fr;
        }
        .playlist-container {
            max-height: 500px !important;
        }
    }

    .playlist-items::-webkit-scrollbar {
        width: 6px;
    }
    .playlist-items::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 10px;
    }
    .playlist-items::-webkit-scrollbar-thumb {
        background: var(--color-orange); 
        border-radius: 10px;
    }

    .playlist-item {
        display: flex;
        align-items: center;
        padding: 15px;
        margin-bottom: 8px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(128, 128, 128, 0.05);
        border: 1px solid rgba(128, 128, 128, 0.15);
    }
    
    .playlist-item:hover {
        background: rgba(128, 128, 128, 0.15);
        border-color: rgba(255, 63, 63, 0.4);
    }
    
    .playlist-item.active {
        background: rgba(255, 63, 63, 0.1);
        border-color: var(--color-red);
    }
    
    .playlist-item.active .item-title {
        color: var(--color-red);
    }
    
    .playlist-item.active .item-play-icon {
        opacity: 1;
        color: var(--color-red);
    }

    .item-number {
        width: 30px;
        font-weight: 600;
        color: var(--text-muted);
    }
    
    .item-details {
        flex-grow: 1;
        padding: 0 10px;
    }
    
    .item-title {
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
        transition: color 0.3s;
    }
    
    .item-duration {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    
    .item-play-icon {
        opacity: 0;
        transition: opacity 0.3s;
    }
</style>

<script>
    function playVideo(youtubeId, title, duration, description, element) {
        // Update iframe
        const player = document.getElementById('youtube-player');
        if (player) {
            player.src = "https://www.youtube.com/embed/" + youtubeId + "?rel=0&modestbranding=1";
        }
        
        // Update fallback link
        const fallback = document.getElementById('fallback-youtube-link');
        if (fallback) {
            fallback.href = "https://www.youtube.com/watch?v=" + youtubeId;
        }
        
        // Update details
        document.getElementById('current-video-title').textContent = title;
        document.getElementById('current-video-duration').textContent = duration;
        document.getElementById('current-video-desc').textContent = description;
        
        // Update active class
        const items = document.querySelectorAll('.playlist-item');
        items.forEach(item => item.classList.remove('active'));
        element.classList.add('active');
    }
</script>




<?php get_footer(); ?>