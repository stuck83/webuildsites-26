<?php
/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @package wprig_webuildsites
 */

namespace Webuildsites;

?>
<section class="error">
	<?php get_template_part( 'template-parts/content/page_header' ); ?>

	<div class="page-content">
		<p>
			<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wprig-webuildsites' ); ?>
		</p>

		
			<?php
			get_search_form();

		wprig_webuildsites()->print_styles( 'wprig-webuildsites-widgets' );
		the_widget( 'WP_Widget_Recent_Posts' );
		?>


		
	</div><!-- .page-content -->
</section><!-- .error -->