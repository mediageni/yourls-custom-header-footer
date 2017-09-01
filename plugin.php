<?php
/*
Plugin Name: Custom Header & Footer
Plugin URI: http://scriptgeni.com/
Description: A Yourls plugin administration page to add custom header and footer code
Version: 1.0
Author: ScriptGeni
Author URI: http://scriptgeni.com
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();


// Add the inline style
yourls_add_action( 'html_head', 'geni_yourls_bootstrap_head' );

function geni_yourls_bootstrap_head() {
$head_option = yourls_get_option( 'head_option' );
	echo <<<CSS

$head_option

CSS;
}

// Add the inline style
yourls_add_action( 'html_footer', 'geni_yourls_bootstrap_foot' );

function geni_yourls_bootstrap_foot() {
$foot_option = yourls_get_option( 'foot_option' );
	echo <<<HTML

$foot_option

HTML;
}



// Register our plugin admin page
yourls_add_action( 'plugins_loaded', 'geni_yourls_head_foot_code' );
function geni_yourls_head_foot_code() {
	yourls_register_plugin_page( 'head_foot_page', 'Header & Footer Admin Page', 'geni_yourls_head_foot_do_page' );
	// parameters: page slug, page title, and function that will display the page itself
}

// Display admin page
function geni_yourls_head_foot_do_page() {

	// Check if a form was submitted
	if( isset( $_POST['head_option'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'head_foot_page' );
		
		// Process form
		geni_yourls_head_foot_update_option();
	}


	if( isset( $_POST['foot_option'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'head_foot_page' );
		
		// Process form
		geni_yourls_head_foot_update_option();
	}

	// Get value from database
	$head_option = yourls_get_option( 'head_option' );
	$foot_option = yourls_get_option( 'foot_option' );

	
	// Create nonce
	$nonce = yourls_create_nonce( 'head_foot_page' );

	echo <<<HTML
		<h2>Header code</h2>
		<p>Add extra code to the head</p>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />
		<p><textarea name="head_option">$head_option</textarea></p>
		<p><input type="submit" value="Update value" /></p>
		</form>

		<h2>Footer code</h2>
		<p>Add extra code to your footer</p>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />
		<p><textarea name="foot_option">$foot_option</textarea></p>
		<p><input type="submit" value="Update value" /></p>
		</form>

HTML;
}

// Update option in database
function geni_yourls_head_foot_update_option() {
	$head = $_POST['head_option'];
	
	if( $head ) {
		// Validate head_option. ALWAYS validate and sanitize user input.
		// Here, we want the value
		$head = $head;
		
		// Update value in database
		yourls_update_option( 'head_option', $head );

	}
	$foot = $_POST['foot_option'];
	
	if( $foot ) {
		// Validate head_option. ALWAYS validate and sanitize user input.
		// Here, we want the value
		$foot = $foot;
		
		// Update value in database
		yourls_update_option( 'foot_option', $foot );

	}





}