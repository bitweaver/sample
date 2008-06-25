<?php
// $Header: /cvsroot/bitweaver/_bit_sample/index.php,v 1.7 2008/06/25 22:21:23 spiderr Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

// Get the default content if none is requested 
if( !isset( $_REQUEST['sample_id'] ) ) {
	$_REQUEST['sample_id'] = $gBitSystem->getConfig( "home_sample" );
}

// Look up the content
require_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

if( !$gContent->isValid() ) {
	$gBitSystem->setHttpStatus( 404 );
	$gBitSystem->fatalError( "The sample you requested could not be found." );
}

// Now check permissions to access this content 
$gContent->verifyViewPermission();

// Add a hit to the counter
$gContent->addHit();

// Display the template
$gBitSystem->display( 'bitpackage:sample/sample_display.tpl', tra( 'Sample' ) , array( 'display_mode' => 'display' ));
?>
