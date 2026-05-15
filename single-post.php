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
    <main id="primary" class="site-main">
        <div class="single-post-scroll">
            <div class="scroll-progress-container">
                <div class="scroll-progress-bar" id="blog-progress-bar"></div>
            </div>
            <?php
            while ( have_posts() ) {
                the_post();
                get_template_part( 'template-parts/content/entry', get_post_type() );
            }
            ?>
        </div>
    </main><?php
get_sidebar();
get_footer();