<?php
/**
 * Template part for displaying the blog sidebar
 *
 * @package wp_rig
 */

namespace Accelerator;

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
    return;
}
?>
<aside class="blog-sidebar">
    <?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside>