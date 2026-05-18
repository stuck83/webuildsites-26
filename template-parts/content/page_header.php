<?php
/**
 * Template part for displaying the page header of the currently displayed page
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

if ( is_404() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'wprig-accelerator' ); ?>
		</h1>
	</header><!-- .page-header -->
	<?php
} elseif ( is_home() && ! have_posts() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'Nothing Found', 'wprig-accelerator' ); ?>
		</h1>
	</header><!-- .page-header -->
	<?php
} elseif ( is_home() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php
			if ( is_front_page() ) {
				esc_html_e( 'Latest Posts', 'wprig-accelerator' );
			} else {
				single_post_title();
			}
			?>
		</h1>
	</header><!-- .page-header -->
	<?php
} elseif ( is_search() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search Results for: %s', 'wprig-accelerator' ),
				'<span>' . get_search_query() . '</span>'
			);
			?>
		</h1>
	</header><!-- .page-header -->
	<?php
} elseif ( is_archive() ) {
	?>
	<header class="page-header">
		<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		?>
	</header><!-- .page-header -->
	<?php
}
