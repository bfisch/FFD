<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="container">

	<header id="masthead" class="site-header" role="banner">

		<div id="navigationContainer">

			<div class="wrapper">

				<nav id="site-navigation" class="main-navigation" role="navigation">
					<button class="menu-toggle" aria-controls="menu" aria-expanded="false">Menu</button>

					<?php
						$menu_to_count = wp_nav_menu(array('echo' => false, 'theme_location' => 'main'));
						$menu_items = substr_count($menu_to_count,'class="menu-item ');
					?>

					<div class="menu-of-<?php echo $menu_items; ?>">
						<?php wp_nav_menu( array( 'theme_location' => 'main' ) ); ?>
					</div>

				</nav>

			</div>			

		</div>

	</header>

	<div id="headerFix"></div>

	<div id="content" class="site-content">

		<?php /* <div class="site-branding">
			<!-- <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2> -->
		</div><!-- .site-branding --> */ ?>
