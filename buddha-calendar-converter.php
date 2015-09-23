<?php
/*
Plugin Name: Buddha-calendar-converter
Version: 0.1
Description: This plugin will convert the date to Thai Buddha calendar when needed.
Author: Shinichi Nishikawa
Author URI: http://th-daily.shinichi.me
Plugin URI: https://github.com/ShinichiNishikawa/Buddha-Calendar-Converter
Text Domain: bcc
Domain Path: /languages
*/

add_filter( 'get_the_date', 'bcc_date_543', 10, 3 );
function bcc_date_543( $the_date, $d, $post ) {

	if ( is_admin() ) {
		return $the_date;
	}

	// Set the format
	$d = $d ? $d : get_option( 'date_format' );

	// We filter the date only when it has something to do with Year.
	// This is to avoid changing dates time in timestamp for systems like googles.
	$parameters = apply_filters( 'bcc_date_format_to_search', "/Y|y|o/" );
	if ( preg_match( $parameters, $d, $matches ) ) {

		$format_only_year    = $matches[0];
		$format_without_year = str_replace( $format_only_year, '______', $d );

		$no_year = mysql2date( $format_without_year, $post->post_date );
		$year    = mysql2date( $format_only_year,    $post->post_date ) + 543;

		$the_date = str_replace( '______', $year, $no_year );

	}

	return $the_date;
}

add_filter( 'get_the_time', 'bcc_time_543', 10, 3 );
function bcc_time_543( $the_time, $d, $post ) {

	if ( is_admin() ) {
		return $the_time;
	}

	// We don't need to care this when time_format is specified by the function caller.
	if ( ! $d ) {
		return $the_time;
	}

	// We filter the date only when it has something to do with Year.
	// This is to avoid changing dates time in timestamp for systems like googles.
	$parameters = apply_filters( 'bcc_date_format_to_search', "/Y|y|o/" );
	if ( preg_match( $parameters, $d, $matches ) ) {

		$format_only_year    = $matches[0];
		$format_without_year = str_replace( $format_only_year, '______', $d );

		$no_year = get_post_time( $format_without_year, false, $post, true );
		$year    = get_post_time( $format_only_year,    false, $post, true ) + 543;

		$the_time = str_replace( '______', $year, $no_year );

	}

	return $the_time;

}
