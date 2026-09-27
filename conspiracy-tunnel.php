<?php
/**
 * Plugin Name: Conspiracy Tunnel
 * Description: Replaces the Hermes Terminal page with the Christopher/itzninjafool conspiracy tunnel — click-through origin story, physics-rope route selector (Fact / Partially True / Mostly False / False), verdict vaults, and the New Claims investigation board.
 * Version: 1.0.0
 * Author: The Ink Muse
 * License: GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CTUNNEL_VERSION', '1.0.0' );
define( 'CTUNNEL_PAGE_SLUG', 'hermes-terminal' );

/**
 * Serve the tunnel on the Hermes Terminal page, bypassing the theme and the
 * old Conspiracy Terminal Route UI. The old plugin stays active (its REST API
 * and archive data are untouched); its scripts never load here because we exit
 * before template rendering. Rollback = deactivate this plugin.
 */
add_action( 'template_redirect', function () {
	if ( ! is_page( CTUNNEL_PAGE_SLUG ) ) return;

	$file = plugin_dir_path( __FILE__ ) . 'tunnel.html';
	if ( ! file_exists( $file ) ) return;

	$html = file_get_contents( $file );
	// Point relative asset paths at this plugin's assets directory.
	$html = str_replace( 'assets/', plugins_url( 'assets/', __FILE__ ), $html );

	status_header( 200 );
	header( 'Content-Type: text/html; charset=utf-8' );
	echo $html;
	exit;
} );
