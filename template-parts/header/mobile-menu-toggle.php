<?php
/**
 * Template part for displaying the mobile menu toggle button
 *
 * @package wprig_webuildsites
 */

$menu_toggle_button = '<button class="menu-toggle" aria-label="' . esc_html__( 'Open menu', 'wprig-webuildsites' ) . '" aria-controls="primary-menu" aria-expanded="false">
				' . esc_html__( 'Menu', 'wprig-webuildsites' ) . '
				</button>';
$menu_toggle_button = apply_filters( 'wprig_webuildsites_menu_toggle_button', $menu_toggle_button );
echo $menu_toggle_button; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */