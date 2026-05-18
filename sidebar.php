<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

if ( ! wprig_accelerator()->is_primary_sidebar_active() ) {
	return;
}

wprig_accelerator()->print_styles( 'wprig-accelerator-sidebar', 'wprig-accelerator-widgets' );

?>
<aside id="secondary" class="primary-sidebar widget-area" aria-label="Sidebar">
	<?php wprig_accelerator()->display_primary_sidebar(); ?>
</aside><!-- #secondary -->
