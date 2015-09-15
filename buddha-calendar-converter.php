<?php
/*
Plugin Name: Buddha Calendar Converter
Version: 1.0
Description: This plugin will convert the date to Buddha calendar when needed.
Author: Shinichi Nishikawa
Author URI: http://th-daily.shinichi.me
Plugin URI: https://github.com/ShinichiNishikawa/Buddha-Calendar-Converter
Text Domain: bcc
Domain Path: /languages
*/

add_filter( 'get_the_date', 'bcc_buddha_date', 10, 3 );
function bcc_buddha_date( $the_date, $d, $post ) {

	if ( empty($d) ) {

		$the_date = date( get_option( 'date_format' ), strtotime("+543 year", strtotime($post->post_date)));

	} elseif ( preg_match( "/Y|y|o/", $d, $matches ) ) {

		$the_date = date( $d, strtotime("+543 year", strtotime($post->post_date)));

	}

	return $the_date;
}