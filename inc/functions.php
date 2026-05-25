<?php
/**
 * The `wprig_accelerator()` function.
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

/**
 * Provides access to all available template tags of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Template_Tags Template tags instance exposing template tag methods.
 */
function wprig_accelerator(): Template_Tags {
	static $theme = null;

	if ( null === $theme ) {
		$theme = new Theme();
		$theme->initialize();
	}

	return $theme->template_tags();
}

/**
 * Fix for wprigScreenReaderText is not defined error
 */
/*add_action( 'wp_head', function() {
    ?>
    <script>
        window.wprigScreenReaderText = { 
            "expand": "expand child menu", 
            "collapse": "collapse child menu" 
        };
    </script>
    <?php
}, 1 );*/


add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css' );
    wp_enqueue_script( 'aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true );

    // This script finds your columns and gives them AOS powers before initializing
    wp_add_inline_script( 'aos-js', "
        document.querySelectorAll('.reveal-on-scroll').forEach((el, index) => {
            el.setAttribute('data-aos', 'fade-up');
            el.setAttribute('data-aos-delay', (index + 1) * 100);
        });
        AOS.init({ duration: 800, once: true });
    ");
});



/**
 * 1. Force WordPress to generate all theme thumbnail sizes in WebP format.
 */
add_filter( 'wp_image_editors', 'accelerator_prioritize_gd_editor' );
function accelerator_prioritize_gd_editor( $editors ) {
    $gd_editor = 'WP_Image_Editor_GD';
    if ( ( $key = array_search( $gd_editor, $editors ) ) !== false ) {
        unset( $editors[$key] );
        array_unshift( $editors, $gd_editor ); // Push GD to the top
    }
    return $editors;
}

add_filter( 'image_editor_output_format', 'accelerator_force_webp_thumbnails' );
function accelerator_force_webp_thumbnails( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
}

/**
 * 2. Intercept the original full-size upload and convert it to WebP via GD.
 */
add_filter( 'wp_handle_upload', 'accelerator_convert_original_to_webp' );
function accelerator_convert_original_to_webp( $upload ) {
    if ( ! function_exists( 'imagewebp' ) ) {
        return $upload; 
    }

    $file_path = $upload['file'];
    $file_info = pathinfo( $file_path );
    $extension = strtolower( $file_info['extension'] );

    if ( in_array( $extension, array( 'jpg', 'jpeg', 'png' ) ) ) {
        if ( 'png' === $extension ) {
            $image = imagecreatefrompng( $file_path );
            if ( ! $image ) return $upload;
            imagepalettetotruecolor( $image );
            imagealphablending( $image, true );
            imagesavealpha( $image, true );
        } else {
            $image = imagecreatefromjpeg( $file_path );
            if ( ! $image ) return $upload;
        }

        $webp_file_path = $file_info['dirname'] . '/' . $file_info['filename'] . '.webp';
        
        if ( imagewebp( $image, $webp_file_path, 80 ) ) {
            imagedestroy( $image );
            unlink( $file_path ); // Delete heavy original to save server storage
            
            $upload['file'] = $webp_file_path;
            $upload['url']  = str_replace( '.' . $extension, '.webp', $upload['url'] );
            $upload['type'] = 'image/webp';
        }
    }
    return $upload;
}

