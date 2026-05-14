<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="top-bar-navigation">
        <div class="container flex justify-end">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'topmenu', // This must match your registration slug
                    'menu_id'        => 'top-menu',
                    'container'      => 'nav',
                    'fallback_cb'    => false,
                )
            );
            ?>
        </div>
    </div>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wp-rig' ); ?></a>

	

   

	<header id="masthead" class="site-header flex">
		<?php get_template_part( 'template-parts/header/custom_header' ); ?>

		<?php get_template_part( 'template-parts/header/branding' ); ?>

		<?php get_template_part( 'template-parts/header/mobile-menu-toggle' ); ?>

		

		<?php get_template_part( 'template-parts/header/navigation' ); ?>
	</header><!-- #masthead -->
