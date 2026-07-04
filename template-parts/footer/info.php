<?php
/**
 * Template part for displaying the footer info
 *
 * @package webuildsites-26
 */

namespace Webuildsites\WP_Rig; // Ensure this matches your theme's namespace

?>

<div class="site-info-widgets">
    <?php
    // Loop through the 3 widget areas we registered
    for ( $i = 1; $i <= 3; $i++ ) :
        $sidebar_id = 'footer-col-' . $i;

        if ( is_active_sidebar( $sidebar_id ) ) :
            ?>
            <div class="footer-column">
                <?php dynamic_sidebar( $sidebar_id ); ?>
            </div>
            <?php
        endif;
    endfor;
    ?>
</div>

<div class="site-footer-bottom">
    <div class="social-icons">
        <a href="https://www.facebook.com/webuildsitesltd" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="https://x.com/WebuildsitesLtd" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="https://www.instagram.com/webuildsites_ltd/" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-instagram"></i></a>
    </div>
    <hr class="footer-divider">
    
    <div class="footer-credits">
        <p>&copy; <?php echo date_i18n( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
    </div>
</div>