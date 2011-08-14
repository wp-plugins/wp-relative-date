<?php
/*
Plugin Name: Artiss Relative Date
Plugin URI: http://www.artiss.co.uk/relative-date
Description: Return a relative formatted date
Version: 1.1
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/

if ( ( is_admin() ) && ( !has_action( 'wp_dashboard_setup', 'artiss_dashboard_widget' ) ) ) {
	include_once( WP_PLUGIN_DIR . '/wp-relative-date/artiss-dashboard-widget.php' );
}

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @package	ArtissRelativeDate
* @since	1.1
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function ard_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'wp-relative-date.php' ) !== false ) {
		$links = array_merge( $links, array( '<a href="http://www.artiss.co.uk/forum">' . __( 'Support' ) . '</a>' ) );
		$links = array_merge( $links, array( '<a href="http://www.artiss.co.uk/donate">' . __( 'Donate' ) . '</a>' ) );
	}

	return $links;
}
if ( is_admin() ) { add_filter( 'plugin_row_meta', 'ard_set_plugin_meta', 10, 2 ); }

/**
* Output relative date
*
* Function call to output the results of a requested relative date calculation
*
* @package	ArtissRelativeDate
* @since	1.0
*
* @param	string	$para1		First parameter (optional)
* @param	string	$para2		Second parameter (optional)
* @param	string	$para3		Third parameter (optional)
*/

function relative_date( $para1 = '', $para2 = '', $para3 = '' ) {
	echo ard_generate_date_code( $para1, $para2, $para3 );
	return;
}

/**
* Return relative date
*
* Function call to return the results of a requested relative date calculation
*
* @package	ArtissRelativeDate
* @since	1.0
*
* @param	string	$para1		First parameter (optional)
* @param	string	$para2		Second parameter (optional)
* @param	string	$para3		Third parameter (optional)
* @return	string				Relative date
*/

function get_relative_date( $para1 = '', $para2 = '', $para3 = '' ) {
	return ard_generate_date_code( $para1, $para2, $para3 );
}

/**
* Generate relative date
*
* Function call to create a string containing a requested relative date calculation
*
* @package	ArtissRelativeDate
* @since	1.0
*
* @param	string	$para1		First parameter (optional)
* @param	string	$para2		Second parameter (optional)
* @param	string	$para3		Third parameter (optional)
* @return	string				Relative date
*/

function ard_generate_date_code( $para1, $para2, $para3 ) {

	// Transfer parameters into an array

	$para[ 1 ] = $para1;
	$para[ 2 ] = $para2;
	$para[ 3 ] = $para3;

	// Work out current date, adjusted to GMT offset of user's WP installation

	$time_gmt_adjusted = gmmktime() + ( get_option( 'gmt_offset' ) * 3600 );

	// Set initial parameter values

	$date_num = 1;
	$divider = '';
	$date = array( 1 => get_the_time( 'U' ), 2 => $time_gmt_adjusted );

	// Read array and extract parameters

	foreach ($para as $para_value) {
		if ( $para_value != '' ) {
			if ( is_numeric( $para_value ) ) {
				if  ( $date_num == 3 ) { return ard_report_error( 'More than 2 dates have been specified', 'Artiss Relative Date', false ); }
				$date[ $date_num ] = $para_value;
				$date_num++;
			} else {
				if ( $divider != '' ) { return ard_report_error( 'More than 1 divider was specified', 'Artiss Relative Date', false ); }
				$divider = $para_value;
			}
		}
	}

	// Set default divider, if nothing is specified

	if ( $divider == '' ) { $divider = ', '; } else { $divider = htmlspecialchars( $divider ); }

	// Work out which date is greater and subtract appropriately

	if ( $date[ 1 ] > $date[ 2 ] ) {
		$diff = $date[ 1 ] - $date[ 2 ];
	} else {
		$diff = $date[ 2 ] - $date[ 1 ];
	}

	// Work out how many years, months, etc, there are between the dates

	$years	 = floor( $diff / 31449600 );
	$diff	-= $years * 31449600; // Seconds in a year
	$months	 = floor( $diff / 2620800 );
	$diff	-= $months * 2620800; // Seconds in a month (assumes 4.3r weeks in month)
	$weeks	 =  floor( $diff / 604800 );
	$diff	-= $weeks * 604800; // seconds in a week
	$days	 =  floor( $diff / 86400 );
	$diff	-= $days * 86400;	// seconds in a day
	$hours	 =  floor( $diff / 3600 );
	$diff	-= $hours * 3600;  // seconds in an hour
	$minutes = floor( $diff / 60 );
	$diff	-= $minutes * 60; // seconds in a minute
	$seconds = $diff;

	$relative_date = '';

	// Now output the results

	if ( $years > 0 ) {

		// Years and Months
		$relative_date .= ( $relative_date?$divider:'' ) . $years . ' year' . ( $years>1?'s':'' );
		if ( $months > 0 ) { $relative_date .= ( $relative_date?$divider:'' ) . $months . ' month' . ( $months>1?'s':'' ); }
		if ( ( $months = 0 ) && ( $weeks > 0 ) ) { $relative_date .= ( $relative_date?$divider:'' ) . $weeks . ' week' . ( $weeks>1?'s':'' ); }

	} elseif ( $months > 0 ) {

		// Months and weeks
		$relative_date .= ( $relative_date?$divider:'' ) . $months . ' month' . ( $months>1?'s':'' );
		if ( $weeks > 0 ) { $relative_date .= ( $relative_date?$divider:'' ) . $weeks . ' week' . ( $weeks>1?'s':'' ); }
		if ( ( $weeks = 0 ) && ( $days > 0 ) ) { $relative_date .= ( $relative_date?$divider:'' ) . $days . ' day' . ( $days>1?'s':'' ); }

	} elseif ( $weeks > 0 ) {

		// Weeks and days
		$relative_date .= ( $relative_date?$divider:'' ) . $weeks . ' week' . ( $weeks>1?'s':'' );
		if ( $days > 0 ) { $relative_date .= ( $relative_date?$divider:'' ) . $days . ' day'.( $days>1?'s':'' );}

	} elseif ( $days > 0 ) {

		// days and hours
		$relative_date .= ( $relative_date?$divider:'' ) . $days . ' day' . ( $days>1?'s':'' );
		if ( $hours > 0 ) { $relative_date .= ( $relative_date?$divider:'' ) . $hours . ' hr' . ( $hours>1?'s':'' ); }

	} elseif ( $hours > 0 ) {

		// hours and minutes
		$relative_date .= ( $relative_date?$divider:'' ) . $hours . ' hr' . ( $hours>1?'s':'' );
		if ( $minutes > 0 ) { $relative_date .= ( $relative_date?$divider:'' ) . $minutes . ' min' . ( $minutes>1?'s':'' ); }

	} elseif ( $minutes > 0 ) {

		// minutes and seconds
		$relative_date .= ( $relative_date?$divider:'' ) . $minutes . ' min' . ( $minutes>1?'s':'' );
		if ( $seconds > 0 ) { $relative_date .= ( $relative_date?$divider:'' ) . $seconds . ' sec' . ( $seconds>1?'s':'' ); }

	} else {
		// seconds only
		$relative_date .= ( $relative_date?$divider:'' ) . $seconds . ' sec' . ( $seconds>1?'s':'' );

	}

	return $relative_date;
}

/**
* Report an error
*
* Function to report an error
*
* @package	ArtissRelativeDate
* @since	1.1
*
* @param	$error			string	Error message
* @param	$plugin_name	string	The name of the plugin
* @param	$echo			string	True or false, depending on whether you wish to return or echo the results
* @return					string	True
*/

function ard_report_error( $error, $plugin_name, $echo = true ) {
	$output = '<p style="color: #f00; font-weight: bold;">' . $plugin_name . ': ' . __( $error ) . "</p>\n";
	if ( $echo ) {
		echo $output;
		return true;
	} else {
		return $output;
	}
}

/**
* Relative Date Debug Function
*
* Function call to return a string of useful debug information
*
* @package	ArtissRelativeDate
* @since	1.1
*
* @param	string	$date1		First date (optional)
* @param	string	$date2		Second date (optional)
* @return	string				Debug information
*/

function ard_debug( $date1, $date2 ) {
	return 'Date 1: ' . $date1 . ' / Date 2: ' . $date2 . ' / Current Server GMT Time: '. gmmktime() . ' / GMT offset (hours): ' . get_option( 'gmt_offset' );
}
?>