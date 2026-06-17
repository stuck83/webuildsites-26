<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig_webuildsites
 */

namespace Webuildsites;

if ( ! wprig_webuildsites()->is_primary_sidebar_active() ) {
	return;
}

wprig_webuildsites()->print_styles( 'wprig-webuildsites-sidebar', 'wprig-webuildsites-widgets' );

?>
<aside id="secondary" class="primary-sidebar widget-area" aria-label="Sidebar">
	<?php wprig_webuildsites()->display_primary_sidebar(); ?>
</aside><!-- #secondary -->
