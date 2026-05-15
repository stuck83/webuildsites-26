<?php
/**
 * Template Name:  No Sidebar Page
 *
 * @package wprig
 */

// Remove has-sidebar body class on this template
add_filter( 'body_class', function( $classes ) {
    return array_diff( $classes, array( 'has-sidebar' ) );
} );

get_header();
?>
<main id="primary" class="site-main">
<?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'no-sidebar-article' ); ?>>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>
</main>
<?php get_footer();