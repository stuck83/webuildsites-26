<?php
/**
 * WP_Rig\WP_Rig\Base_Support\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Options;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function add_action;

/**
 * Class for adding basic theme support, most of which is mandatory to be implemented by all themes.
 *
 * Exposes template tags:
 * * `wp_rig()->get_version()`
 * * `wp_rig()->get_asset_version( string $filepath )`
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'options';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'admin_enqueue_scripts', array( $this, 'theme_options_enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'rest_api_init', array( $this, 'register_settings_endpoint' ) );
		add_action( 'template_redirect', array( $this, 'maybe_render_maintenance_page' ) );
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wp_rig()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array {
		return array();
	}

	/**
	 * Enqueues the theme options admin scripts.
	 */
	public function theme_options_enqueue_scripts(): void {
		wp_enqueue_script(
			'wp-rig-theme-settings',
			get_template_directory_uri() . '/assets/js/admin/index.min.js',
			array( 'wp-element', 'wp-components', 'wp-data' ),
			filemtime( get_template_directory() . '/assets/js/admin/index.min.js' ),
			true
		);

		wp_enqueue_style(
			'wp-rig-theme-settings',
			get_template_directory_uri() . '/assets/css/admin/theme-settings.min.css',
			array(),
			filemtime( get_template_directory() . '/assets/css/admin/theme-settings.min.css' ),
		);

		$settings = get_option( 'wp_rig_theme_settings', '' );

		wp_localize_script(
			'wp-rig-theme-settings',
			'wprigAcceleratorThemeSettings',
			array(
				'nonce'    => wp_create_nonce( 'wp_rest' ),
				'settings' => $settings,
			)
		);
	}

	/**
	 * Adds an admin menu page for WP Rig settings.
	 */
	public function add_admin_menu(): void {
		add_menu_page(
			__( 'Accelerator Settings', 'wp-rig' ),
			__( 'Accelerator Settings', 'wp-rig' ),
			'manage_options',
			'wp-rig-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Renders the settings page by including the settings-page.php file from the theme's inc/Options directory.
	 */
	public function render_settings_page(): void {
		require get_template_directory() . '/inc/Options/settings-page.php';
	}

	/**
	 * Registers the settings endpoint for the REST API.
	 */
	public function register_settings_endpoint(): void {
		register_rest_route(
			'my-theme/v1',
			'/settings',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'update_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
	}

	/**
	 * Checks whether maintenance mode should be displayed for visitors.
	 */
	
     
    public function maybe_render_maintenance_page(): void {
        if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
            return;
        }

        if ( current_user_can( 'manage_options' ) ) {
            return;
        }

        $settings = get_option( 'wp_rig_theme_settings', array() );
        if ( ! is_array( $settings ) ) {
            $settings = array();
        }

        if ( empty( $settings['maintenance_mode'] ) ) {
            return;
        }

        status_header( 503 );
        nocache_headers();

        // Get the absolute path to your theme's compiled image directory
        $logo_url = get_template_directory_uri() . '/assets/images/acc-logo.png';

        /** @noinspection PhpUndefinedFunctionInspection */
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' . esc_html__( 'Maintenance', 'wp-rig' ) . '</title>';
        echo '<style>body{margin:0;background:#0d1f57;color:#fff;font-family:sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;text-align:center;padding:1.5rem;} .maintenance-message{max-width:720px;} .maintenance-logo{max-width:240px; height:auto; margin-bottom:2rem;} .maintenance-message h1{margin:0 0 1rem;font-size:2.25rem;} .maintenance-message p{margin:0;font-size:1.1rem;line-height:1.6;}</style></head><body><div class="maintenance-message">';
        
        // Output the image right above the heading
        echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr__( 'Accelerator Logo', 'wp-rig' ) . '" class="maintenance-logo" />';
        
        echo '<h1>' . esc_html__( 'Maintenance Mode Enabled', 'wp-rig' ) . '</h1><p>' . esc_html__( 'We are currently performing maintenance. Please check back soon. If your matter is urgent please call Support on: 0207 993 3100 or email: support@accelerator.uk.com', 'wp-rig' ) . '</p></div></body></html>';
        exit;
    }

	/**
	 * Updates settings based on the provided request.
	 *
	 * @param WP_REST_Request $request The request object containing 'settings' parameter.
	 *
	 * @return WP_REST_Response|WP_Error WP_REST_Response on success, or WP_Error on failure due to invalid settings.
	 */
	public function update_settings( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$settings = $request->get_param( 'settings' );

		if ( ! is_array( $settings ) ) {
			return new WP_Error( 'invalid_settings', 'Invalid settings.', array( 'status' => 400 ) );
		}

		$settings = $this->sanitize_theme_settings( $settings );

		update_option( 'wp_rig_theme_settings', $settings );

		return new WP_REST_Response(
			array(
				'success'  => true,
				'settings' => $settings,
			),
			200
		);
	}

	/**
	 * Sanitizes theme settings by key.
	 *
	 * @param array $settings The settings array to be sanitized.
	 *
	 * @return array The sanitized settings array.
	 */
	public function sanitize_theme_settings( array $settings ): array {
		$sanitized_settings = array();
		foreach ( $settings as $key => $value ) {
			$sanitized_key = sanitize_key( $key );

			switch ( $sanitized_key ) {
				case 'email_option':
					$sanitized_settings[ $sanitized_key ] = sanitize_email( $value );
					break;
				case 'url_option':
					$sanitized_settings[ $sanitized_key ] = esc_url_raw( $value );
					break;
				case 'maintenance_mode':
					$sanitized_settings[ $sanitized_key ] = rest_sanitize_boolean( $value );
					break;
				default:
					$sanitized_settings[ $sanitized_key ] = sanitize_text_field( $value );
					break;
			}
		}

		return $sanitized_settings;
	}

	/**
	 * Checks whether the current user has permission to manage settings.
	 *
	 * @param WP_REST_Request $request The current request instance.
	 *
	 * @return bool True if the user has the 'manage_options' capability, false otherwise.
	 */
	public function settings_permissions_check( WP_REST_Request $request ): bool {
		return current_user_can( 'manage_options' );
	}
}
