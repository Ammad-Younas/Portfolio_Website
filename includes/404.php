<?php
get_header();
?>

<main id="primary" class="site-main">
    <section class="section-padding dark-bg text-center" style="min-height: 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="container animate-fade-up">
            <h1 style="font-size: 6rem; color: var(--color-red); margin-bottom: 20px; text-shadow: 0 0 20px rgba(255,51,51,0.5);">404</h1>
            <h2 class="section-title">Page Not <span class="highlight-orange">Found</span></h2>
            <p class="mt-3" style="font-size: 1.2rem; color: var(--text-muted); max-width: 600px; margin: 0 auto;">
                Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>
            <div class="mt-5" style="margin-top: 2rem;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i> Return Home
                </a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
