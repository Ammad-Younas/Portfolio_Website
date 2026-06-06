<?php
require_once dirname(__DIR__, 3) . '/includes/functions.php';

$json_path = dirname(__DIR__) . '/data/videos.json';
$videos = [];
if (file_exists($json_path)) {
    $json_data = file_get_contents($json_path);
    $json_data = preg_replace('/^[\xef\xbb\xbf]+/', '', $json_data);
    $videos = json_decode($json_data, true);
    if (!is_array($videos)) $videos = [];
}

$course_title = isset($_GET['course']) ? ucwords(str_replace('-', ' ', $_GET['course'])) : 'Course';
$course_phase = isset($_GET['phase']) ? ucwords(str_replace('-', ' ', $_GET['phase'])) : 'Phase 1: Foundation';

get_header();
?>
<main id="primary" class="site-main">
    <section class="section-padding dark-bg" style="padding-top: 120px; position: relative;">
        
        <!-- Far left positioned back button -->
        <div style="position: absolute; top: 120px; left: 40px; z-index: 10;">
            <a href="<?php echo esc_url( home_url( '/src/courses/course_roadmap.php' ) ); ?>" class="btn-cert-small player-back-btn" style="display: inline-block;"><i class="fa-solid fa-arrow-left"></i> Back to Roadmap</a>
        </div>

        <div class="container-fluid" style="width: 100%; max-width: 100%; padding: 0 20px;">
            
            <div class="player-header mb-4 text-left" style="margin-top: 50px; padding-left: 20px;">
                <h2 class="section-title" id="course-title"><?php echo esc_html($course_phase); ?></h2>
            </div>

            <div class="course-player-grid">
                
                <!-- Left Side: Video Player & Description -->
                <div class="player-main-col" style="display: flex; gap: 30px; align-items: stretch;">
                    <div class="video-container glass-card" style="width: 100%; max-width: 60vw; flex: 2; padding: 10px; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div class="responsive-iframe" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                            <!-- The iframe src will be set by JS. Initially load the first video if available -->
                            <?php if (!empty($videos)): ?>
                                <iframe id="youtube-player" src="https://www.youtube.com/embed/<?php echo esc_attr($videos[0]['youtube_id']); ?>?rel=0&modestbranding=1" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <?php else: ?>
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #000; color: #fff;">No videos available</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="video-details-wrapper" style="flex: 1; position: relative;">
                        <div class="video-details glass-card" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow-y: auto; padding: 25px; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                            <?php if (!empty($videos)): ?>
                                <h3 id="current-video-title" class="mb-3"><?php echo esc_html($videos[0]['title']); ?></h3>
                                <div class="video-meta mb-3" style="color: var(--highlight-orange); font-size: 0.9rem;">
                                    <i class="fa-regular fa-clock"></i> <span id="current-video-duration"><?php echo esc_html($videos[0]['duration']); ?></span>
                                </div>
                                <div class="section-line" style="margin-left: 0; margin-bottom: 20px;"></div>
                                <p id="current-video-desc" class="text-muted" style="white-space: pre-wrap; margin-bottom: 0;">
                                    <?php echo esc_html($videos[0]['description']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
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
                            <?php $index = 0; foreach ($videos as $video): ?>
                            <div class="playlist-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                                 onclick="playVideo(<?php echo $index; ?>, this)">
                                <div class="item-number"><?php echo esc_html($video['id']); ?></div>
                                <div class="item-details">
                                    <h4 class="item-title"><?php echo esc_html($video['title']); ?></h4>
                                    <span class="item-duration"><i class="fa-regular fa-clock"></i> <?php echo esc_html($video['duration']); ?></span>
                                </div>
                                <div class="item-play-icon">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                            </div>
                            <?php $index++; endforeach; ?>
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
        grid-template-columns: 1fr;
        gap: 30px;
        align-items: start;
    }
    
    .video-details::-webkit-scrollbar {
        width: 6px;
    }
    .video-details::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 10px;
    }
    .video-details::-webkit-scrollbar-thumb {
        background: var(--color-red); 
        border-radius: 10px;
    }

    @media (max-width: 1199px) {
        .player-main-col {
            flex-direction: column;
        }
        .video-container {
            max-width: 100% !important;
        }
        .video-details-wrapper {
            position: static !important;
            width: 100%;
        }
        .video-details {
            position: relative !important;
            height: auto !important;
            margin-top: 20px;
            max-height: 300px;
        }
        .playlist-container {
            max-height: 500px !important;
        }
    }

    .playlist-items {
        overflow-y: auto;
        padding: 10px;
        flex: 1;
        min-height: 0;
    }
    .playlist-items::-webkit-scrollbar {
        width: 6px;
    }
    .playlist-items::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 10px;
    }
    .playlist-items::-webkit-scrollbar-thumb {
        background: var(--color-red); 
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
    const courseVideos = <?php echo json_encode($videos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    
    function playVideo(index, element) {
        const video = courseVideos[index];
        if (!video) return;

        const player = document.getElementById('youtube-player');
        if (player) {
            player.src = "https://www.youtube.com/embed/" + video.youtube_id + "?rel=0&modestbranding=1";
        }
        
        const fallback = document.getElementById('fallback-youtube-link');
        if (fallback) {
            fallback.href = "https://www.youtube.com/watch?v=" + video.youtube_id;
        }
        
        document.getElementById('current-video-title').textContent = video.title;
        document.getElementById('current-video-duration').textContent = video.duration;
        document.getElementById('current-video-desc').innerText = video.description;
        
        const items = document.querySelectorAll('.playlist-item');
        items.forEach(item => item.classList.remove('active'));
        element.classList.add('active');
    }
</script>




<?php get_footer(); ?>

