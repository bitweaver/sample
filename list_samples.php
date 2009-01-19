<?php
// $Header: /cvsroot/bitweaver/_bit_sample/Attic/list_samples.php,v 1.16 2009/01/19 17:06:37 dansut Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// Initialization
require_once( '../bit_setup_inc.php' );
require_once( SAMPLE_PKG_PATH.'BitSample.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

// Look up the content
require_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

// Now check permissions to access this page
$gContent->verifyViewPermission();

// Remove samples if we don't want them anymore
if( isset( $_REQUEST["submit_mult"] ) && isset( $_REQUEST["checked"] ) && $_REQUEST["submit_mult"] == "remove_samples" ) {

	// Now check permissions to remove the selected samples
	$gBitSystem->verifyPermission( 'p_sample_update' );

	if( !empty( $_REQUEST['cancel'] ) ) {
		// user cancelled - just continue on, doing nothing
	} elseif( empty( $_REQUEST['confirm'] ) ) {
		$formHash['delete'] = TRUE;
		$formHash['submit_mult'] = 'remove_samples';
		foreach( $_REQUEST["checked"] as $del ) {
			$tmpPage = new BitSample( $del);
			if ( $tmpPage->load() && !empty( $tmpPage->mInfo['title'] )) {
				$info = $tmpPage->mInfo['title'];
			} else {
				$info = $del;
			}
			$formHash['input'][] = '<input type="hidden" name="checked[]" value="'.$del.'"/>'.$info;
		}
		$gBitSystem->confirmDialog( $formHash, 
			array(
				'warning' => tra('Are you sure you want to delete ').count( $_REQUEST["checked"] ).' samples?',
				'error' => tra('This cannot be undone!')
			)
		);
	} else {
		foreach( $_REQUEST["checked"] as $deleteId ) {
			$tmpPage = new BitSample( $deleteId );
			if( !$tmpPage->load() || !$tmpPage->expunge() ) {
				array_merge( $errors, array_values( $tmpPage->mErrors ) );
			}
		}
		if( !empty( $errors ) ) {
			$gBitSmarty->assign_by_ref( 'errors', $errors );
		}
	}
}

// Create new sample object
$sample = new BitSample();
$samplesList = $sample->getList( $_REQUEST );
$gBitSmarty->assign_by_ref( 'samplesList', $samplesList );

// getList() has now placed all the pagination information in $_REQUEST['listInfo']
$gBitSmarty->assign_by_ref( 'listInfo', $_REQUEST['listInfo'] );

// Display the template
$gBitSystem->display( 'bitpackage:sample/list_samples.tpl', tra( 'Sample' ) , array( 'display_mode' => 'list' ));

?>
