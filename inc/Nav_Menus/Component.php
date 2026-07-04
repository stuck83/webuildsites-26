<?php
/**
 * Accelerator\Nav_Menus\Component class
 *
 * @package wprig_accelerator
 */

namespace Accelerator\Nav_Menus;

use WP_Post;
use Accelerator\Component_Interface;
use Accelerator\Templating_Component_Interface;

use function Accelerator\wprig_accelerator;
use function add_action;
use function add_filter;
use function register_nav_menus;
use function esc_html__;
use function has_nav_menu;
use function wp_nav_menu;

/**
 * Class for managing navigation menus.
 *
 * Exposes template tags:
 * * `wprig_accelerator()->is_primary_nav_menu_active()`
 * * `wprig_accelerator()->display_primary_nav_menu( array $args = array() )`
 */
class Component implements Component_Interface, Templating_Component_Interface {

	const PRIMARY_NAV_MENU_SLUG = 'primary';

	/**
	 * All theme settings - from JSON file.
	 *
	 * @var $theme_settings array
	 */
	public $theme_settings;

	/**
	 * Dropdown symbol SVG content.
	 *
	 * @var string
	 */
	private $dropdown_symbol_svg;

	/**
	 * Menu icon SVG content.
	 *
	 * @var string
	 */
	private $menu_icon_svg;

	/**
	 * Close icon SVG content.
	 *
	 * @var string
	 */
	private $close_icon_svg;

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'nav_menus';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		$this->get_theme_settings_config();
		$this->preload_svg_assets();
		$this->hooks();
	}

	/**
	 * Preloads SVG assets to avoid multiple file reads during menu rendering.
	 */
	private function preload_svg_assets() {
		// Load dropdown symbol SVG.
		$dropdown_svg = wprig_accelerator()->get_theme_asset( 'dropdown-symbol.svg', 'svg', true ) ?? '';
		$this->dropdown_symbol_svg = apply_filters( 'wprig_accelerator_dropdown_icon_svg', $dropdown_svg );

		// Load menu toggle icons directly from disk instead of over HTTP.
		$menu_icon_path  = get_theme_file_path( '/assets/svg/menu-icon.svg' );
		$close_icon_path = get_theme_file_path( '/assets/svg/close-icon.svg' );

		$menu_icon_svg  = file_exists( $menu_icon_path ) ? file_get_contents( $menu_icon_path ) : '';
		$close_icon_svg = file_exists( $close_icon_path ) ? file_get_contents( $close_icon_path ) : '';

		$this->menu_icon_svg = apply_filters( 'wprig_accelerator_menu_toggle_icon_svg', $menu_icon_svg );
		$this->close_icon_svg = apply_filters( 'wprig_accelerator_menu_close_icon_svg', $close_icon_svg );
	}

	/**
	 * Setup all hooks for the class.
	 */
	public function hooks() {
		add_action( 'after_setup_theme', array( $this, 'action_register_nav_menus' ) );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'filter_primary_nav_menu_dropdown_symbol' ), 10, 4 );
		add_filter( 'wprig_accelerator_menu_toggle_button', array( $this, 'customize_mobile_menu_toggle' ) );
		add_filter( 'wprig_accelerator_site_navigation_classes', array( $this, 'customize_mobile_menu_nav_classes' ) );
		add_filter( 'render_block_core/navigation', array( $this, 'add_nav_class_to_navigation_block' ), 10, 3 );
		add_filter( 'wp_nav_menu_objects', array( $this, 'inject_parent_link_into_submenu' ), 10, 2 );
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance.
	 */
	public function template_tags(): array {
		return array(
			'is_primary_nav_menu_active' => array( $this, 'is_primary_nav_menu_active' ),
			'display_primary_nav_menu'   => array( $this, 'display_primary_nav_menu' ),
		);
	}

	/**
	 * Retrieves the theme settings from the JSON file.
	 */
	private function get_theme_settings_config() {
		$path = get_theme_file_path( '/inc/EZ_Customizer/themeCustomizeSettings.json' );
		if ( ! file_exists( $path ) ) {
			return null;
		}
		$theme_settings_json  = file_get_contents( $path );
		$this->theme_settings = apply_filters( 'wprig_accelerator_customizer_settings', json_decode( $theme_settings_json, true ) );
		return null;
	}

	/**
	 * Registers the navigation menus.
	 */
	public function action_register_nav_menus() {
		register_nav_menus(
			array(
				static::PRIMARY_NAV_MENU_SLUG => esc_html__( 'Primary', 'wprig-accelerator' ),
				'topmenu' => esc_html__( 'Top Menu', 'wprig-accelerator' ),
			)
		);
	}

	/**
	 * Adds a dropdown symbol to nav menu items with children.
	 */
	public function filter_primary_nav_menu_dropdown_symbol( string $item_output, WP_Post $item, int $depth, object $args ): string {
		if ( empty( $args->theme_location ) || static::PRIMARY_NAV_MENU_SLUG !== $args->theme_location ) {
			return $item_output;
		}

		if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			return $item_output . '<button class="dropdown-toggle" aria-expanded="false" aria-label="' . esc_html__( 'Expand child menu', 'wprig-accelerator' ) . '">' . $this->dropdown_symbol_svg . '</button>';
		}

		return $item_output;
	}

	/**
	 * Checks whether the primary navigation menu is active.
	 */
	public function is_primary_nav_menu_active(): bool {
		return (bool) has_nav_menu( static::PRIMARY_NAV_MENU_SLUG );
	}

	/**
	 * Displays the primary navigation menu.
	 */
	public function display_primary_nav_menu( array $args = array() ) {
		if ( ! isset( $args['container'] ) ) {
			$args['container'] = '';
		}

		$args['theme_location'] = static::PRIMARY_NAV_MENU_SLUG;
		wp_nav_menu( $args );
	}

	/**
	 * Displays the primary navigation menu toggle.
	 */
	public function customize_mobile_menu_toggle() {
		return '<button class="menu-toggle icon" aria-label="' . esc_html__( 'Open menu', 'wprig-accelerator' ) . '" aria-controls="primary-menu" aria-expanded="false">
					' . $this->menu_icon_svg . '
					' . $this->close_icon_svg . '
					</button>'
	}

	/**
	 * Displays the primary navigation menu classes.
	 */
	public function customize_mobile_menu_nav_classes() {
		return esc_html( 'main-navigation nav--toggle-sub nav--toggle-small icon-nav' );
	}

	/**
	 * Adds the necessary nav class for navigation.js to control sub menus.
	 */
	public function add_nav_class_to_navigation_block( mixed $block_content, mixed $block, mixed $instance ): string {
		$content = new \WP_HTML_Tag_Processor( $block_content );
		$content->next_tag( array( 'nav' ) );
		$content->add_class( 'nav--toggle-sub' );
		$block_content = (string) $content;
		return $block_content;
	}

	/**
	 * Inject a duplicate of the parent link as the first submenu item.
	 */
	public function inject_parent_link_into_submenu( array $items, object $args ): array {
		if ( empty( $args->theme_location ) || static::PRIMARY_NAV_MENU_SLUG !== $args->theme_location ) {
			return $items;
		}

		$children_by_parent = array();
		foreach ( $items as $itm ) {
			$parent_id = (int) ( $itm->menu_item_parent ?? 0 );
			if ( ! isset( $children_by_parent[ $parent_id ] ) ) {
				$children_by_parent[ $parent_id ] = array();
			}
			$children_by_parent[ $parent_id ][] = $itm;
		}

		$injected = array();

		foreach ( $items as $item ) {
			$has_children  = ! empty( $item->classes ) && is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true );
			$has_valid_url = ! empty( $item->url ) && '#' !== $item->url;

			if ( ! $has_children || ! $has_valid_url ) {
				continue;
			}

			$already_has_injected = false;
			$children             = $children_by_parent[ (int) $item->ID ] ?? array();
			foreach ( $children as $child ) {
				if ( ! empty( $child->classes ) && is_array( $child->classes ) && in_array( 'menu-item--injected-parent-link', $child->classes, true ) ) {
					$already_has_injected = true;
					break;
				}
			}

			if ( $already_has_injected ) {
				continue;
			}

			$new = clone $item;
			$new->ID               = -1 * ( absint( $item->ID ) + 100000 );
			$new->db_id            = 0;
			$new->menu_item_parent = (int) $item->ID;
			$new->type             = 'custom';
			$new->object           = 'custom';
			$new->object_id        = 0;
			$new->title            = $item->title;
			$new->url              = $item->url;
			$new->xfn              = '';
			$new->target           = $item->target ?? '';
			$new->attr_title       = $item->attr_title ?? '';
			$new->description      = '';
			$base_classes          = array_diff( (array) ( $item->classes ?? array() ), array( 'menu-item-has-children' ) );
			$new->classes          = array_unique( array_merge( $base_classes, array( 'menu-item--injected-parent-link' ) ) );

			$children_orders = array_map(
				function ( $c ) {
					return (int) ( $c->menu_order ?? 0 );
				},
				$children
			);
			$min_order       = empty( $children_orders ) ? 0 : min( $children_orders );
			$new->menu_order = $min_order - 1;

			$injected[] = $new;
		}

		if ( empty( $injected ) ) {
			return $items;
		}

		$items = array_merge( $items, $injected );
		usort(
			$items,
			function ( $a, $b ) {
				$ao = (int) ( $a->menu_order ?? 0 );
				$bo = (int) ( $b->menu_order ?? 0 );
				if ( $ao === $bo ) {
					return 0;
				}
				return ( $ao < $bo ) ? -1 : 1;
			}
		);

		return $items;
	}

	/**
	 * Modifies menu item output for improved accessibility.
	 */
	public function modify_menu_items_for_accessibility( string $item_output, object $item, int $depth, object $args ): string {
		if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
			return $item_output;
		}

		if ( empty( $item->url ) || '#' === $item->url ) {
			$item_label = $item->title;
			$has_submenu = in_array( 'menu-item-has-children', $item->classes, true );

			return sprintf(
				'<button class="%s" type="button" aria-expanded="false" aria-controls="submenu-%s">%s %s</button>',
				$has_submenu ? 'submenu-toggle' : '',
				esc_attr( $item->ID ),
				esc_html( $item_label ),
				$has_submenu ? '<span class="dropdown-icon">' . $this->dropdown_symbol_svg . '</span>' : ''
			);
		}

		return $item_output;
	}

	/**
	 * Gets the dropdown symbol SVG content.
	 */
	public function get_dropdown_symbol_svg() {
		return $this->dropdown_symbol_svg;
	}

	/**
	 * Gets the menu toggle icon SVG content.
	 */
	public function get_menu_icon_svg() {
		return $this->menu_icon_svg;
	}

	/**
	 * Gets the menu close icon SVG content.
	 */
	public function get_close_icon_svg() {
		return $this->close_icon_svg;
	}
}