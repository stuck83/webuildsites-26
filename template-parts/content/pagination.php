<?php
/**
 * Template part for displaying a pagination
 *
 * @package wprig_webuildsites
 */

namespace Webuildsites;

the_posts_pagination(
	array(
		'mid_size'           => 2,
		'prev_text'          => _x( 'Previous', 'previous set of search results', 'wprig-webuildsites' ),
		'next_text'          => _x( 'Next', 'next set of search results', 'wprig-webuildsites' ),
		'screen_reader_text' => __( 'Page navigation', 'wprig-webuildsites' ),
	)
);
