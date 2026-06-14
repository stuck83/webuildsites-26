<?php
/**
 * Accelerator\Editor\Component class
 *
 * @package wprig_accelerator
 */

namespace Accelerator\Editor;

use Accelerator\Component_Interface;

// ALL function imports live up here perfectly together!
use function add_action;
use function add_theme_support;
use function add_editor_style; 
use function get_theme_file_uri;
use function esc_url;
use function wp_add_inline_style;
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
        
        // This hook injects styles inside the block editor iframe context
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_iframe_editor_fonts' ) );
    }

    /**
     * Adds support for various editor features.
     */
    public function action_add_editor_support() {
        add_theme_support( 'editor-styles' );
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
         * Add support custom font sizes.
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
    } // End action_add_editor_support()

    /**
     * Enqueues inline fonts directly inside the editor iframe canvas panel.
     */
    public function enqueue_iframe_editor_fonts() {
        // Dynamically grab the exact URI directory name path
        $font_url = get_theme_file_uri( '/assets/fonts/raleway/1Ptug8zYS_SKggPNyCAIT5lu.woff2' );

        $custom_css = '
            @font-face {
                font-family: "Raleway";
                font-style: normal;
                font-weight: 100 900;
                font-display: swap;
                src: url("' . esc_url( $font_url ) . '") format("woff2");
            }
            
            /* Target the root canvas element inside the iframe */
            .editor-styles-wrapper,
            .editor-styles-wrapper *,
            .editor-styles-wrapper p,
            .editor-styles-wrapper .block-editor-rich-text__editable,
            .wp-block-post-title,
            .editor-post-title__input {
                font-family: "Raleway", sans-serif !important;
            }
            
            .editor-styles-wrapper p { font-weight: 400 !important; }
            .editor-styles-wrapper h1, 
            .editor-styles-wrapper h2, 
            .editor-styles-wrapper h3,
            .editor-post-title__input { font-weight: 700 !important; }
        ';

        // Safely force-injects the style block directly into the iframe asset queue
        wp_add_inline_style( 'wp-edit-blocks', $custom_css );
    } // End enqueue_iframe_editor_fonts()

} // End Class Component