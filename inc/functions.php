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
