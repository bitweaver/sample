<?php
// $Header: /cvsroot/bitweaver/_bit_sample/edit.php,v 1.17 2010/04/14 20:03:40 dansut Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.

// Initialization
require_once( '../kernel/setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

require_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

// Now check permissions to access this page
if( $gContent->isValid() ){
	$gContent->verifyUpdatePermission();
}else{
	$gContent->verifyCreatePermission();
}

// If we are in preview mode then preview it!
if( isset( $_REQUEST["preview"] ) ) {
	if( isset( $_REQUEST["title"] ) ) $gContent->mInfo["title"] = $_REQUEST["title"];
	if( isset( $_REQUEST['sample']["description"] ) ) $gContent->mInfo["description"] = $_REQUEST['sample']["description"];
	if( isset( $_REQUEST["format_guid"] ) ) $gContent->mInfo['format_guid'] = $_REQUEST["format_guid"];
	if( isset( $_REQUEST["edit"] ) ) {
		$gContent->mInfo["data"] = $_REQUEST["edit"];
		$gContent->mInfo['parsed_data'] = $gContent->parseData();
	}
	$gContent->invokeServices( 'content_preview_function' );
} else {
	$gContent->invokeServices( 'content_edit_function' );
}

// If a data save has been requested then perform a 'store'
if( !empty( $_REQUEST["save_sample"] ) ) {
	if( $gContent->store( $_REQUEST ) ) {
		bit_redirect( $gContent->getDisplayUrl() );
	} else {
		$gBitSmarty->assign_by_ref( 'errors', $gContent->mErrors );
	}
}

// Display the template
$gBitSystem->display( 'bitpackage:sample/edit_sample.tpl', tra('Sample') , array( 'display_mode' => 'edit' ));
?>
