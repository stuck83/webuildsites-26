<?php
/**
 * The template for displaying all single blog posts
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

get_header();

wprig_accelerator()->print_styles( 'wprig-accelerator-content' );
?>

<div class="scroll-progress-container">
    <div id="blog-progress-bar" class="scroll-progress-bar"></div>
</div>

<div class="single-post-wrapper">
    <div class="single-post-row">

        <main id="primary" class="site-main single-post-main">
            <?php
            while ( have_posts() ) {
                the_post();
                get_template_part( 'template-parts/content/entry', get_post_type() );
            }
            ?>
        </main>

        <aside class="single-post-sidebar">
            <?php get_template_part( 'template-parts/sidebar/blog-sidebar' ); ?>
        </aside>

    </div>
</div>

<?php
get_footer();