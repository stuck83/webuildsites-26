<?php
/**
 * The template for displaying all single blog posts
 *
 * @package wprig_webuildsites
 */

namespace Webuildsites;

get_header();

wprig_webuildsites()->print_styles( 'wprig-webuildsites-content' );
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
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-view-article' ); ?>>
                    
                    <header class="blog-view-header">
                        <?php the_title( '<h1 class="blog-view-title">', '</h1>' ); ?>
                        <div class="blog-view-meta">
                            Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?>
                        </div>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="blog-view-thumbnail">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="blog-view-content">
                        <?php
                        the_content();
                        
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wprig_webuildsites' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div>

                </article>
                <?php
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