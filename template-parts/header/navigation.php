<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

?>
<div class="primary-menu-container flex-grow col-9">
    
    <div class="mobile-menu-header">
        <?php get_template_part( 'template-parts/header/mobile-menu-toggle' ); ?>
        <?php get_template_part( 'template-parts/header/branding' ); ?>
    </div>
    
    <nav id="site-navigation" class="main-navigation nav--toggle-sub nav--toggle-small" aria-label="<?php esc_attr_e( 'Main menu', 'wprig-accelerator' ); ?>">
        <?php 
        if ( function_exists( 'wprig_accelerator' ) ) {
            wprig_accelerator()->display_primary_nav_menu( array( 'menu_id' => 'primary-menu' ) ); 
        } else {
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                )
            );
        }
        ?>
    </nav>
</div>