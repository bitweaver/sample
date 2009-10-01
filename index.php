<?php
// $Header: /cvsroot/bitweaver/_bit_sample/index.php,v 1.11 2009/10/01 14:17:04 wjames5 Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

// Check permissions to access this page before even try to get content
$gBitSystem->verifyPermission( 'p_sample_view' );

// Get the default content if none is requested 
if( !isset( $_REQUEST['sample_id'] ) ) {
	$_REQUEST['sample_id'] = $gBitSystem->getConfig( "sample_home_id" );
}

// If there is a sample id to get, specified or default, then attempt to get it and display
if( !empty( $_REQUEST['sample_id'] ) ) {
	// Look up the content
	require_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

	if( !$gContent->isValid() ) {
		$gBitSystem->setHttpStatus( 404 );
		$gBitSystem->fatalError( tra( "The requested sample (id=".$_REQUEST['sample_id'].") could not be found." ) );
	}

	// Now check permissions to access this content 
	$gContent->verifyViewPermission();

	// Add a hit to the counter
	$gContent->addHit();

	// Display the template
	$gBitSystem->display( 'bitpackage:sample/sample_display.tpl', tra( 'Sample' ) , array( 'display_mode' => 'display' ));

} else if ( $gBitUser->hasPermission( 'p_sample_admin' ) ) {
    // Redirect to det up the default sample data to display
	header( "Location: ".KERNEL_PKG_URL.'admin/index.php?page='.SAMPLE_PKG_NAME );

} else {
	$gBitSystem->setHttpStatus( 404 );
	$gBitSystem->fatalError( tra( "The default sample data has not been configured." ) );
}

?>
