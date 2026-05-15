<?php
/**
 * The template for displaying all single blog posts
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();


wp_rig()->print_styles( 'wp-rig-content' );

?>
<div class="scroll-progress-container">
    <div id="blog-progress-bar" class="scroll-progress-bar"></div>
</div>


    <main id="primary" class="site-main">
        
            <?php
            while ( have_posts() ) {
                the_post();
                get_template_part( 'template-parts/content/entry', get_post_type() );
            }
            ?>
        
    </main><?php
get_sidebar();
get_footer();