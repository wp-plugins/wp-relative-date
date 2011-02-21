<?php
/*
Plugin Name: WP Relative Date
Plugin URI: http://www.artiss.co.uk/wp-relative-date
Description: Display a relative date
Version: 1.0
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/
// Function call to output the results
function relative_date($date1="",$date2="") {
    echo generate_date_code($date1,$date2);
    return;
}

// Function call to return the results
function get_relative_date($date1="",$date2="") {
    return generate_date_code($date1,$date2);
}

// Generate the relative date depending on dates passed
function generate_date_code($date1,$date2) {

    // If either dates are blank, assign the current date
    if (($date1!="")&&($date2=="")) {
        $date2=gmmktime();
    } else {
        if (($date1=="")&&($date2!="")) {$date1=gmmktime();}
    }

    // Work out which date is greater and subtract appropriately
    if ($date1>$date2) {
        $diff = $date1 - $date2;
    } else {
        $diff = $date2 - $date1;
    }

    // Ok, work out how many years, months, etc, there are between the dates
    $years  = floor($diff/31449600);
    $diff -= $years * 31449600; // Seconds in a year
    $months = floor($diff/2620800);
    $diff -= $months * 2620800; // Seconds in a month (assumes 4.3r weeks in month)
    $weeks =  floor($diff/604800);  
    $diff -= $weeks*604800; // seconds in a week
    $days =  floor($diff/86400);
    $diff -= $days * 86400;    // seconds in a day
    $hours =  floor($diff/3600);
    $diff -= $hours * 3600;  // seconds in an hour
    $minutes = floor($diff/60);
    $diff -= $minutes * 60; // seconds in a minute
    $seconds = $diff;
    $relative_date = '';

    // Now output the results
    if ($years > 0) {
        // Years and Months
        $relative_date .= ($relative_date?', ':'').$years.' year'.($years>1?'s':'');
        if ($months > 0) {$relative_date .= ($relative_date?', ':'').$months.' month'.($months>1?'s':'');}
        if (($months = 0)&&($weeks > 0)) {$relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');}
    } elseif ($months > 0) {
        // Months and weeks
        $relative_date .= ($relative_date?', ':'').$months.' month'.($months>1?'s':'');
        if ($weeks > 0) {$relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');}
        if (($weeks = 0)&&($days > 0)) {$relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');}
    } elseif ($weeks > 0) {
        // Weeks and days
        $relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');
        if ($days > 0) {$relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');}
    } elseif ($days > 0) {
        // days and hours
        $relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');
        if ($hours > 0) {$relative_date .= ($relative_date?', ':'').$hours.' hr'.($hours>1?'s':'');}
    } elseif ($hours > 0) {
        // hours and minutes
        $relative_date .= ($relative_date?', ':'').$hours.' hr'.($hours>1?'s':'');
        if ($minutes > 0) {$relative_date .= ($relative_date?', ':'').$minutes.' min'.($minutes>1?'s':'');}
    } elseif ($minutes > 0) {
        // minutes and seconds
        $relative_date .= ($relative_date?', ':'').$minutes.' min'.($minutes>1?'s':'');
        if ($seconds > 0) {$relative_date .= ($relative_date?', ':'').$seconds.' sec'.($seconds>1?'s':'');}
    } else {
        // seconds only
        $relative_date .= ($relative_date?', ':'').$seconds.' sec'.($seconds>1?'s':'');
    }

    return $relative_date;
}
?>