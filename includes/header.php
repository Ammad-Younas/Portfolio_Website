<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" href="<?php echo esc_url( home_url( '/assets/images/favicon.png' ) ); ?>?v=<?php echo filemtime( get_template_directory() . '/assets/images/favicon.png' ); ?>" type="image/png">

	<title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | MADI Wist' : 'MADI Wist - Android & Python Developer'; ?></title>
	<meta property="og:site_name" content="MADI Wist">
	<script type="application/ld+json">
	[
		{
			"@context" : "https://schema.org",
			"@type" : "WebSite",
			"name" : "MADI Wist",
			"alternateName" : ["MADIWist", "MADI Wist"],
			"url" : "<?php echo esc_url( home_url( '/' ) ); ?>"
		},
		{
			"@context": "https://schema.org",
			"@type": "ItemList",
			"itemListElement": [
				{
					"@type": "SiteNavigationElement",
					"position": 1,
					"name": "Home",
					"description": "Welcome to MADI Wist - Android & Python Developer Portfolio.",
					"url": "<?php echo esc_url( home_url( '/' ) ); ?>"
				},
				{
					"@type": "SiteNavigationElement",
					"position": 2,
					"name": "About",
					"description": "Learn more about MADI Wist, an aspiring Android and Python Developer.",
					"url": "<?php echo esc_url( home_url( '/#about' ) ); ?>"
				},
				{
					"@type": "SiteNavigationElement",
					"position": 3,
					"name": "Projects",
					"description": "Explore my portfolio of Android and Python projects.",
					"url": "<?php echo esc_url( home_url( '/#projects' ) ); ?>"
				},
				{
					"@type": "SiteNavigationElement",
					"position": 4,
					"name": "Blog",
					"description": "Read my latest articles and tutorials on software development.",
					"url": "<?php echo esc_url( home_url( '/src/blogs/blogs' ) ); ?>"
				},
				{
					"@type": "SiteNavigationElement",
					"position": 5,
					"name": "Skills",
					"description": "Discover the programming languages and tools I specialize in.",
					"url": "<?php echo esc_url( home_url( '/#skills' ) ); ?>"
				}
			]
		}
	]
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">


	<header id="masthead" class="site-header glass-header">
        <div class="header-container container">
            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo">
                    <span class="logo-text"><span class="highlight-red">MADI</span> Wist</span>
                </a>
            </div>

            <nav id="site-navigation" class="main-navigation" style="display: flex; align-items: center; gap: 20px;">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="menu-container">
                    <ul id="primary-menu" class="menu">
                        <li><a href="<?php echo esc_url( home_url( '/#hero' ) ); ?>">Home</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>">About</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/#journey' ) ); ?>">Journey</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/#skills' ) ); ?>">Skills</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/#projects' ) ); ?>">Projects</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/src/blogs/blogs' ) ); ?>">Blog</a></li>
                        <li>
                            <button id="theme-toggle" class="theme-toggle-btn" aria-label="Toggle Light/Dark Mode" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; transition: color 0.3s; padding: 0;">
                                <i class="fa-solid fa-sun"></i>
                            </button>
                        </li>

                        <li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="btn-primary-nav">Contact Me</a></li>
                    </ul>
                </div>
            </nav>
        </div>
	</header>
