<?php
/**
 * Template Name: Blog
 * Template Post Type: page
 *
 * A custom page template for displaying WordPress posts as cards in a 3-column grid.
 * No sidebar is displayed.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

// Remove has-sidebar body class on this template.
add_filter( 'body_class', function( $classes ) {
    return array_diff( $classes, array( 'has-sidebar' ) );
} );

get_header();
wp_rig()->print_styles( 'wp-rig-content' );

$paged = max( 1, get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1 );
$blog_query = new \WP_Query(
    array(
        'post_type'      => 'post',
        'posts_per_page' => 8,
        'paged'          => $paged,
    )
);
?>

<main id="primary" class="site-main blog-page">
    <div class="grid-container">

        <header class="page-header blog-page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <?php if ( $blog_query->have_posts() ) : ?>
            <div class="blog-post-grid grid-12">
                <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card col-4 reveal-on-scroll' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a class="blog-card-image-link" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" style="height:250px;">
                                <?php the_post_thumbnail( 'large' ); ?>
                            </a>
                        <?php endif; ?>

                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                            </div>

                            <?php the_title( '<h2 class="blog-card-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

                            <div class="blog-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a class="blog-card-readmore" href="<?php the_permalink(); ?>">
                                <?php esc_html_e( 'Read more', 'wp-rig' ); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="blog-pagination">
                <?php
                echo paginate_links(
                    array(
                        'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $paged,
                        'total'     => $blog_query->max_num_pages,
                        'prev_text' => esc_html__( 'Previous', 'wp-rig' ),
                        'next_text' => esc_html__( 'Next', 'wp-rig' ),
                    )
                );
                ?>
            </div>
        <?php else : ?>
            <div class="blog-no-posts">
                <?php esc_html_e( 'No posts were found.', 'wp-rig' ); ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
wp_reset_postdata();
get_footer();
