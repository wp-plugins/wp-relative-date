<?php
/**
* Artiss Dashboard Widget (v1.1)
*
* Add a box to the dashboard to display Artiss plugin news and support links
*
* @package	YouTubeEmbed
* @since	2.0
*/

/**
* Define Dashboard Widget
*
* Set up a new dashboard widget
*
*/

function artiss_dashboard_widget() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget( 'artiss_help_widget', 'Artiss Plugin News & Support', 'artiss_plugin_help' );
}
add_action( 'wp_dashboard_setup', 'artiss_dashboard_widget' );

/**
* Display Dashboard Widget
*
* Show dashboard widget. Fetch top news items from category feed and cache them.
*
*/

function artiss_plugin_help() {

	// Set number of minutes to cache output
	$minutes_to_cache = 60;
	
	// Set number of news items to display
	$news_items = 5;

	// Attempt to get the cache	
	$output = get_transient( 'artiss_dashboard_text' );

	// No cache found
	if (!$output) {

		$output = '<img src="http://www.artiss.co.uk/wp-content/themes/artiss-1/images/head.png" alt="Artiss.co.uk logo" title="Artiss.co.uk logo" style="float: right; margin-right: 8px; margin-bottom: 4px; padding:2px; padding-bottom: 8px; border: 1px solid #ddd; background-color: #fff;">';

		// Use MagpieRSS to fetch the feed
		include_once( ABSPATH . WPINC . '/rss.php' );
		$array = fetch_rss( 'http://www.artiss.co.uk/category/wordpress/feed' );

		if ( $array != '' ) {

			// If a feed is returned, slice up the results into an array
			$items = array_slice( $array -> items, 0, $news_items );

			// Now loop around the result and output
			$output .= "<h4>News</h4><br/>\n";
			if ( count( $items ) != 0 ) {
				$output .= "<ul>\n";
				foreach ( $items as $item ) {
					$output .= '<li><a href="' . $item[ 'link' ] . '">' . $item[ 'title' ] . "</a></li>\n";
				}
				$output .= "</ul></br>\n";
			} else {
				$output .= "No news items were found - please check back later!</br></br>";
			}
		}

		// Generate support links
		$output .= "<h4>Support Links</h4><br/>\n<ul>\n<li><a href=\"http://www.artiss.co.uk\">Artiss.co.uk website</a><br/></li>\n<li><a href=\"http://www.artiss.co.uk/wp-plugins\">Main plugin page</a><br/></li>\n<li><a href=\"http://www.artiss.co.uk/forum\">Plugin forum </a></li>\n</ul></br>\n";

		// Generate news links
		$output .= "<h4>News</h4><br/>\n<ul>\n<li><a href=\"http://www.artiss.co.uk\">Subscribe to the RSS feed</a><br/></li>\n<li><a href=\"http://www.artiss.co.uk/wp-plugins\">Follow us on Twitter</a><br/></li>\n</ul>\n";

		// Add donation link
		$output .= "<h5 style=\"text-align: right\"><a href=\"http://www.artiss.co.uk/donate\">Donate</a></h5>";

		// Update cache
		set_transient( 'artiss_dashboard_text', $output, $minutes_to_cache * 60 );
	}

	echo $output;
}
?>