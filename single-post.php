<?php
/**
 * The template for displaying all single blog posts
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

get_header();

// Safe global framework style injections
if ( \function_exists( 'accelerator_production' ) ) {
    \accelerator_production()->print_styles( 'accelerator-production-content' );
} elseif ( \function_exists( 'wprig_accelerator' ) ) {
    \wprig_accelerator()->print_styles( 'wprig-accelerator-content' );
} else {
    \WP_Rig\WP_Rig\wp_rig()->print_styles( 'wp-rig-content' );
}
?>

<style>
    body.single-post #page.site {
        display: block !important;
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Mobile First: Stacks by default */
    .responsive-flex-row {
        display: flex !important;
        flex-direction: column !important; 
        width: 100% !important;
    }
    .responsive-main {
        width: 100% !important;
        max-width: 100% !important;
        padding-right: 0 !important;
        margin-bottom: 3rem; /* Spacing above sidebar on mobile */
    }
    .responsive-sidebar {
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Tablets and Desktops: Snaps side-by-side */
    @media (min-width: 952px) {
        .responsive-flex-row {
            flex-direction: row !important;
            flex-wrap: nowrap !important;
        }
        .responsive-main {
            flex: 0 0 75% !important;
            width: 75% !important;
            max-width: 75% !important;
            padding-right: 5% !important;
            margin-bottom: 0;
        }
        .responsive-sidebar {
            flex: 0 0 25% !important;
            width: 25% !important;
            max-width: 25% !important;
        }
    }
</style>

<div class="scroll-progress-container">
    <div id="blog-progress-bar" class="scroll-progress-bar"></div>
</div>

<div class="single-post-custom-wrapper" style="display: block; width: 100%; max-width: 100%; padding: 2rem 5%; box-sizing: border-box;">
    
    <div class="responsive-flex-row">

        <main id="primary" class="site-main responsive-main" style="box-sizing: border-box !important;">
            <?php
            while ( have_posts() ) {
                the_post();
                get_template_part( 'template-parts/content/entry', get_post_type() );
            }
            ?>
        </main>

        <aside class="sidebar-wrapper responsive-sidebar" style="box-sizing: border-box !important;">
            <?php get_sidebar(); ?>
        </aside>

    </div>
</div>

<?php
get_footer();