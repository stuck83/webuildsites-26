<?php
/**
 * Template Name: Homepage
 *
 * @package wprig
 */

get_header();
?>

<section class="accelerator-hero-video">
    <div class="video-overlay">
        <div class="grid-container">
            <div class="hero-text-box">
                <h2 class="hero-title">Comprehensive IT and Telecom Solutions</h2>
                <div class="orange-divider"></div>
                <p class="hero-description">
                    Trusted for over 21 years to deliver seamless IT, Telecom and AV solutions - keeping businesses connected, safe and ahead.
                </p>
            </div>
        </div>
    </div>
    
    <video autoplay muted loop playsinline poster="assets/images/video-placeholder.jpg" class="bg-video">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/video/london-skyline.mp4" type="video/mp4">
    </video>
</section>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			
			<div class="entry-content">
				<?php
				the_content();
				?>
			</div>

		</article>

		<?php
	endwhile;
	?>

</main>

<?php
get_footer();