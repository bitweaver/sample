<?php
// $Header: /cvsroot/bitweaver/_bit_sample/edit.php,v 1.7 2006/05/24 18:11:39 hash9 Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_sample_edit' );

require_once(SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

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
	$gBitSmarty->assign('preview', 'y');
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

// Configure quicktags list
if( $gBitSystem->isPackageActive( 'quicktags' ) ) {
	include_once( QUICKTAGS_PKG_PATH.'quicktags_inc.php' );
}

// WYSIWYG and Quicktag variable
$gBitSmarty->assign( 'textarea_id', 'editsample' );

// Display the template
$gBitSystem->display( 'bitpackage:sample/edit_sample.tpl', tra('Sample') );
?>
