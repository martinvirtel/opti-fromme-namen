<?php
/**
 * Website header
 *
 * @package Opti
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="google-site-verification" content="AVbVdrfNDOrvQllrGLyLxXwXXJuXeRoYUr3vrWJOdGU" />
		<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script><![endif]-->
		<?php wp_head(); ?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/style.css?v=2.1" type="text/css" media="all"/>
		<!--[if IE 9]><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/ie9.css" type="text/css" media="all"/><![endif]-->
		<!--[if IE 8]><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/ie8.css" type="text/css" media="all"/><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/ie7.css" type="text/css" media="all"/><![endif]-->
	</head>

	<body <?php body_class(); ?> data-breakpoint="1023">
		<section class="container hfeed">
			<header id="masthead" role="banner">
				<section class="row">
					<hgroup id="branding">
						<h1 id="logo">
							<a href="<?php echo home_url(); ?>" title="<?php esc_attr_e( 'Home', 'opti' ); ?>"><?php bloginfo( 'name' ); ?></a>
						</h1>
						<?php if ( get_bloginfo( 'description' ) ) { ?>
						<h2 id="description">
							<?php bloginfo( 'description' ); ?>
						</h2>
						<?php } ?>
					</hgroup>
					<?php
						get_template_part( 'searchform' );
						opti_custom_header( 'header' );
					?>
				</section>
				<nav class="menu" id="nav-primary">
					<section class="row clearfloat">
						<?php opti_navmenu( 'navigation_top' ); ?>
					</section>
				</nav>
				<?php
				if ( has_nav_menu( 'navigation_bottom' ) ) {
					?>
					<nav class="menu clearfloat" id="nav-lower">
						<section class="row clearfloat">
							<?php wp_nav_menu( array( 'theme_location' => 'navigation_bottom', 'menu_class' => 'nav' ) ); ?>
						</section>
					</nav>
					<?php
				}
				?>
			</header>

			<section class="wrapper">
				<section id="main">
<?php
	opti_custom_header();
	do_action( 'opti_after_header' );