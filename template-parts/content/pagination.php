<?php
/**
 * Template part for displaying a pagination
 *
 * @package wprig_accelerator
 */

namespace Accelerator;

the_posts_pagination(
	array(
		'mid_size'           => 2,
		'prev_text'          => _x( 'Previous', 'previous set of search results', 'wprig-accelerator' ),
		'next_text'          => _x( 'Next', 'next set of search results', 'wprig-accelerator' ),
		'screen_reader_text' => __( 'Page navigation', 'wprig-accelerator' ),
	)
);
