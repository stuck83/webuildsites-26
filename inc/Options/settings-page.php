<?php
/**
 * Content to display in Theme Settings admin page.
 * React loads in the app container div wprig-webuildsites-settings-page.
 *
 * @package wprig_webuildsites
 */

wp_enqueue_style(
	'wp-components'
);
?>
<div class="wrap">
    <h1><?php esc_html_e( 'Webuildsites Settings', 'webuildsites' ); ?></h1>
    <div id="wprig-webuildsites-settings-page"></div>
</div>