<?php
/**
 * Content to display in Theme Settings admin page.
 * React loads in the app container div wprig-accelerator-settings-page.
 *
 * @package wp_rig
 */

wp_enqueue_style(
	'wp-components'
);
?>
<div class="wrap">
    <h1><?php esc_html_e( 'Accelerator Settings', 'accelerator' ); ?></h1>
    <div id="wprig-accelerator-settings-page"></div>
</div>