<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	 <?php
// Fetch the Google Analytics ID from the customizer settings
$ga_id = get_theme_mod( 'ga_id' );

// Only output the tracking script if the ID has actually been filled out
if ( ! empty( $ga_id ) ) : 
?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo esc_js( $ga_id ); ?>');
    </script>
<?php 
endif; 
?>
    
    
    <?php wp_head(); ?>

</head>
 
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<span id="top-target"></span>

<div class="back-to-top-wrapper" id="btt-wrapper">
    <a href="#top-target" class="back-to-top-btn" aria-label="Back to top">
        <span class="chevron"></span>
    </a>
</div>

<script>
window.onscroll = function() {
    var btt = document.getElementById('btt-wrapper');
    // Displays the button only after scrolling down 40% of the viewport height (40vh)
    if (window.scrollY > (window.innerHeight * 0.4)) {
        btt.classList.add('is-visible');
    } else {
        btt.classList.remove('is-visible');
    }
};
</script>


<div class="top-bar-navigation">
    <div class="container flex justify-end">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'topmenu', // Dev environment uses 'topmenu' natively
                'menu_id'        => 'top-menu',
                'container'      => 'nav',
                'fallback_cb'    => false,
            )
        );
        ?>
    </div>
</div>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wprig-accelerator' ); ?></a>

	

   

	<header id="masthead" class="site-header flex">

   

		<?php get_template_part( 'template-parts/header/custom_header' ); ?>

		<?php get_template_part( 'template-parts/header/branding' ); ?>

		<?php get_template_part( 'template-parts/header/mobile-menu-toggle' ); ?>

		

		<?php get_template_part( 'template-parts/header/navigation' ); ?>

       
	</header><!-- #masthead -->
