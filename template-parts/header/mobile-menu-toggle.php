<?php
/**
 * Template part for displaying the mobile menu toggle button
 *
 * @package wprig_accelerator
 */

$menu_toggle_button = '<button class="menu-toggle" aria-label="' . esc_html__( 'Open menu', 'wprig-accelerator' ) . '" aria-controls="primary-menu" aria-expanded="false">
				' . esc_html__( 'Menu', 'wprig-accelerator' ) . '
				</button>';
$menu_toggle_button = apply_filters( 'wprig_accelerator_menu_toggle_button', $menu_toggle_button );
echo $menu_toggle_button; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */