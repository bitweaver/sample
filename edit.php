<?php
// $Header: /cvsroot/bitweaver/_bit_sample/edit.php,v 1.14 2009/10/01 13:45:47 wjames5 Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

require_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

// Now check permissions to access this page
if( $gContent->isValid() ){
	$gContent->verifyUpdatePermission();
}else{
	$gContent->verifyCreatePermission();
}

if( isset( $_REQUEST['sample']["title"] ) ) {
	$gContent->mInfo["title"] = $_REQUEST['sample']["title"];
}

if( isset( $_REQUEST['sample']["description"] ) ) {
	$gContent->mInfo["description"] = $_REQUEST['sample']["description"];
}

if( isset( $_REQUEST["format_guid"] ) ) {
	$gContent->mInfo['format_guid'] = $_REQUEST["format_guid"];
}

if( isset( $_REQUEST['sample']["edit"] ) ) {
	$gContent->mInfo["data"] = $_REQUEST['sample']["edit"];
	$gContent->mInfo['parsed_data'] = $gContent->parseData();
}

// If we are in preview mode then preview it!
if( isset( $_REQUEST["preview"] ) ) {
	$gContent->invokeServices( 'content_preview_function' );
} else {
	$gContent->invokeServices( 'content_edit_function' );
}

// Pro
// Check if the page has changed
if( !empty( $_REQUEST["save_sample"] ) ) {

	// Check if all Request values are delivered, and if not, set them
	// to avoid error messages. This can happen if some features are
	// disabled
	if( $gContent->store( $_REQUEST['sample'] ) ) {
		header( "Location: ".$gContent->getDisplayUrl() );
		die;
	} else {
		$gBitSmarty->assign_by_ref( 'errors', $gContent->mErrors );
	}
}

// Display the template
$gBitSystem->display( 'bitpackage:sample/edit_sample.tpl', tra('Sample') , array( 'display_mode' => 'edit' ));
?>
