<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sample/remove_sample.php,v 1.7 2009/10/01 14:17:04 wjames5 Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * $Id: remove_sample.php,v 1.7 2009/10/01 14:17:04 wjames5 Exp $
 * @package sample
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
include_once( SAMPLE_PKG_PATH.'BitSample.php');
include_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

$gBitSystem->verifyPackage( 'sample' );

if( !$gContent->isValid() ) {
	$gBitSystem->fatalError( "No sample indicated" );
}

$gContent->verifyExpungePermission();

if( isset( $_REQUEST["confirm"] ) ) {
	if( $gContent->expunge()  ) {
		header ("location: ".BIT_ROOT_URL );
		die;
	} else {
		vd( $gContent->mErrors );
	}
}

$gBitSystem->setBrowserTitle( tra( 'Confirm delete of: ' ).$gContent->getTitle() );
$formHash['remove'] = TRUE;
$formHash['sample_id'] = $_REQUEST['sample_id'];
$msgHash = array(
	'label' => tra( 'Delete Sample' ),
	'confirm_item' => $gContent->getTitle(),
	'warning' => tra( 'This sample will be completely deleted.<br />This cannot be undone!' ),
);
$gBitSystem->confirmDialog( $formHash,$msgHash );

?>
