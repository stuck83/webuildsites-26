<?php
/**
 * Webuildsites\Base_Support\Component class
 *
 * @package wprig_webuildsites
 */

namespace Webuildsites\Options;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use Webuildsites\Component_Interface;
use Webuildsites\Templating_Component_Interface;
use function add_action;

/**
 * Class for adding basic theme support, most of which is mandatory to be implemented by all themes.
 *
 * Exposes template tags:
 * * `wprig_webuildsites()->get_version()`
 * * `wprig_webuildsites()->get_asset_version( string $filepath )`
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
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wprig_webuildsites()`.
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
            'wprig-webuildsites-theme-settings',
            get_template_directory_uri() . '/assets/js/admin/index.min.js',
            array( 'wp-element', 'wp-components', 'wp-data' ),
            '1.0.1', // Safe, hardcoded version string
            true
        );

        wp_enqueue_style(
            'wprig-webuildsites-theme-settings',
            get_template_directory_uri() . '/assets/css/admin/theme-settings.min.css',
            array(),
            '1.0.1' // Safe, hardcoded version string
        );

        $settings = get_option( 'wprig_webuildsites_theme_settings', '' );

        wp_localize_script(
            'wprig-webuildsites-theme-settings',
            'wprigWebuildsitesThemeSettings',
            array(
                'nonce'    => wp_create_nonce( 'wp_rest' ),
                'settings' => $settings,
            )
        );
    }

	/**
	 * Adds an admin menu page for Webuildsites settings.
	 */
	public function add_admin_menu(): void {
		add_menu_page(
			__( 'Webuildsites Settings', 'wprig-webuildsites' ),
			__( 'Webuildsites Settings', 'wprig-webuildsites' ),
			'manage_options',
			'wprig-webuildsites-settings',
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

public function maybe_render_maintenance_page(): void {
    if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
        return;
    }

    $settings = get_option( 'wprig_webuildsites_theme_settings', array() );
    error_log( 'RAW maintenance settings: ' . print_r( $settings, true ) );
    error_log( 'maintenance_mode value: ' . var_export( $settings['maintenance_mode'] ?? 'NOT SET', true ) );
    error_log( 'current user can manage: ' . var_export( current_user_can( 'manage_options' ), true ) );

    if ( current_user_can( 'manage_options' ) ) {
        error_log( 'BLOCKED: user is admin' );
        return;
    }

    if ( ! is_array( $settings ) ) {
        $settings = array();
    }

    if ( empty( $settings['maintenance_mode'] ) || $settings['maintenance_mode'] === false || $settings['maintenance_mode'] === '0' ) {
        return;
    }

    status_header( 503 );
    nocache_headers();

    $logo_url = get_template_directory_uri() . '/assets/images/acc-logo.png';

    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' . esc_html__( 'Maintenance', 'wprig-webuildsites' ) . '</title>';
    echo '<style>body{margin:0;background:#0d1f57;color:#fff;font-family:sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;text-align:center;padding:1.5rem;} .maintenance-message{max-width:720px;} .maintenance-logo{max-width:240px;height:auto;margin-bottom:2rem;} .maintenance-message h1{margin:0 0 1rem;font-size:2.25rem;} .maintenance-message p{margin:0;font-size:1.1rem;line-height:1.6;}</style></head><body><div class="maintenance-message">';
    echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr__( 'Webuildsites Logo', 'wprig-webuildsites' ) . '" class="maintenance-logo" />';
    echo '<h1>' . esc_html__( 'Maintenance Mode Enabled', 'wprig-webuildsites' ) . '</h1><p>' . esc_html__( 'We are currently performing maintenance. Please check back soon. If your matter is urgent please call Support on: 0207 993 3100 or email: support@webuildsites.uk.com', 'wprig-webuildsites' ) . '</p></div></body></html>';
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

		update_option( 'wprig_webuildsites_theme_settings', $settings );

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