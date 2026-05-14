<?php
/**
 * WP_Rig\WP_Rig\Widgets\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Widgets;

use WP_Rig\WP_Rig\Component_Interface; // Corrected from 'import'
use function add_action;
use function register_sidebar;
use function sprintf;
use function __;

/**
 * Class for integrating Widgets/Sidebars.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'widgets';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'widgets_init', array( $this, 'action_register_sidebars' ) );
	}

	/**
	 * Registers the theme's sidebars/widget areas.
	 */
	public function action_register_sidebars() {
		$widget_wrapper = array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		);



		for ( $i = 1; $i <= 3; $i++ ) {
			register_sidebar(
				array_merge(
					$widget_wrapper,
					array(
						'name' => sprintf( __( 'Footer Column %d', 'wp-rig' ), $i ),
						'id'   => 'footer-col-' . $i,
					)
				)
			);
		}
	}
}