<?php
/**
 * Accelerator\Editor\Component class
 *
 * @package wprig_accelerator
 */

namespace Accelerator\Editor;

use Accelerator\Component_Interface;

use function add_action;
use function add_theme_support;
use function add_editor_style;
use function __;

/**
 * Class for integrating with the block editor.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'editor';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_editor_support' ) );
	}

	/**
	 * Adds support for various editor features.
	 */
	public function action_add_editor_support() {
		add_theme_support( 'editor-styles' );

		// Load editor styles — font CSS must come first so @font-face is declared
		// before editor.min.css references the font family.
		add_editor_style( 'assets/css/google-fonts.min.css' );
		add_editor_style( 'assets/css/editor.min.css' );

		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		/**
		 * Add support for color palettes.
		 */
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'wprig-accelerator' ),
					'slug'  => 'theme-primary',
					'color' => '#e36d60',
				),
				array(
					'name'  => __( 'Secondary', 'wprig-accelerator' ),
					'slug'  => 'theme-secondary',
					'color' => '#41848f',
				),
				array(
					'name'  => __( 'Red', 'wprig-accelerator' ),
					'slug'  => 'theme-red',
					'color' => '#C0392B',
				),
				array(
					'name'  => __( 'Green', 'wprig-accelerator' ),
					'slug'  => 'theme-green',
					'color' => '#27AE60',
				),
				array(
					'name'  => __( 'Blue', 'wprig-accelerator' ),
					'slug'  => 'theme-blue',
					'color' => '#2980B9',
				),
				array(
					'name'  => __( 'Yellow', 'wprig-accelerator' ),
					'slug'  => 'theme-yellow',
					'color' => '#F1C40F',
				),
				array(
					'name'  => __( 'Black', 'wprig-accelerator' ),
					'slug'  => 'theme-black',
					'color' => '#1C2833',
				),
				array(
					'name'  => __( 'Grey', 'wprig-accelerator' ),
					'slug'  => 'theme-grey',
					'color' => '#95A5A6',
				),
				array(
					'name'  => __( 'White', 'wprig-accelerator' ),
					'slug'  => 'theme-white',
					'color' => '#ECF0F1',
				),
				array(
					'name'  => __( 'Dusty daylight', 'wprig-accelerator' ),
					'slug'  => 'custom-daylight',
					'color' => '#97c0b7',
				),
				array(
					'name'  => __( 'Dusty sun', 'wprig-accelerator' ),
					'slug'  => 'custom-sun',
					'color' => '#eee9d1',
				),
			)
		);

		/**
		 * Add support for custom font sizes.
		 */
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'wprig-accelerator' ),
					'shortName' => __( 'S', 'wprig-accelerator' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Medium', 'wprig-accelerator' ),
					'shortName' => __( 'M', 'wprig-accelerator' ),
					'size'      => 25,
					'slug'      => 'medium',
				),
				array(
					'name'      => __( 'Large', 'wprig-accelerator' ),
					'shortName' => __( 'L', 'wprig-accelerator' ),
					'size'      => 31,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Larger', 'wprig-accelerator' ),
					'shortName' => __( 'XL', 'wprig-accelerator' ),
					'size'      => 39,
					'slug'      => 'larger',
				),
			)
		);
	}
}