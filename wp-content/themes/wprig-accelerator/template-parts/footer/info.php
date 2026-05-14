<?php
/**
 * Template part for displaying the footer info
 *
 * @package accelerator-26
 */

namespace Accelerator\WP_Rig; // Ensure this matches your theme's namespace

?>

<div class="site-info-widgets grid-container">



    <div class="grid-row">

        <?php
        // Loop through the 5 widget areas we registered
        for ( $i = 1; $i <= 3; $i++ ) :
            $sidebar_id = 'footer-col-' . $i;

            if ( is_active_sidebar( $sidebar_id ) ) :
               
                $col_span = 'col-4';
                ?>
                <div class="footer-column <?php echo esc_attr( $col_span ); ?>">
                    <?php dynamic_sidebar( $sidebar_id ); ?>
                </div>
                <?php
            endif;
        endfor;
        ?>

    </div></div>
    
    <div class="site-footer-bottom grid-container">
    <div class="grid-row">
        <div class="col-12">
            <div class="social-icons col-6">
            <a href="https://www.facebook.com/acceleratorltd" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="https://x.com/AcceleratorLtd" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="https://www.instagram.com/accelerator_ltd/" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-instagram"></i></a>
            <!--<a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>-->
    </div>
            <hr class="footer-divider">
        </div>
    
    <div class="grid-row">
        <div class="col-12 footer-credits">
            <p>&copy; <?php echo date_i18n( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
        </div>
        
</div>
