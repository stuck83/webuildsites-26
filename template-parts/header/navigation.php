<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

if ( ! wprig_accelerator()->is_primary_nav_menu_active() ) {
	return;
}

?>
<div class="primary-menu-container flex-grow col-9">
	
	<div class="mobile-menu-header">
		<?php get_template_part( 'template-parts/header/mobile-menu-toggle' ); ?>
		<?php get_template_part( 'template-parts/header/branding' ); ?>
		
		
	</div>
	<nav id="<?php echo apply_filters( 'wprig_accelerator_site_navigation_id', 'site-navigation' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>" class="<?php echo apply_filters( 'wprig_accelerator_site_navigation_classes', 'main-navigation nav--toggle-sub nav--toggle-small' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>" aria-label="<?php esc_attr_e( 'Main menu', 'wprig-accelerator' ); ?>">
		<?php wprig_accelerator()->display_primary_nav_menu( array( 'menu_id' => 'primary-menu' ) ); ?>
	</nav><!-- #site-navigation -->
</div>