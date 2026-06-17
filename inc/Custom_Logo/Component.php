<?php
/**
 * Webuildsites\Custom_Logo\Component class
 *
 * @package wprig_webuildsites
 */

namespace Webuildsites\Custom_Logo;

use Webuildsites\Component_Interface;
use function add_action;
use function add_theme_support;
use function apply_filters;

/**
 * Class for adding custom logo support.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'custom_logo';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_custom_logo_support' ) );
	}

	/**
	 * Adds support for the Custom Logo feature.
	 */
	public function action_add_custom_logo_support() {
        add_theme_support(
            'custom-logo',
            apply_filters(
                'wprig_webuildsites_custom_logo_args',
                array(
                    'height'      => 155, // This becomes the "suggested" height
                    'width'       => 800, // Increase this to a realistic max width
                    'flex-width'  => true,  // Allows the width to skip cropping
                    'flex-height' => true,  // Allows the height to skip cropping
                    'header-text' => array( 'site-title', 'site-description' ),
                )
            )
        );
    }
}