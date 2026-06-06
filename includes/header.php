<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" href="<?php echo esc_url( home_url( '/assets/images/favicon.png' ) ); ?>?v=<?php echo filemtime( get_template_directory() . '/assets/images/favicon.png' ); ?>" type="image/png">

	<title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | MADI Wist' : 'MADI Wist - Android & Python Developer'; ?></title>
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
