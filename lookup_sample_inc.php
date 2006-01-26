<?php
global $gContent;
require_once( SAMPLE_PKG_PATH.'BitSample.php');
require_once( LIBERTY_PKG_PATH.'lookup_content_inc.php' );

// if we already have a gContent, we assume someone else created it for us, and has properly loaded everything up.
if( empty( $gContent ) || !is_object( $gContent ) || !$gContent->isValid() ) {
	// if sample_id supplied, use that
	if( @BitBase::verifyId( $_REQUEST['sample_id'] ) ) {
		$gContent = new BitSample( $_REQUEST['sample_id'] );

	// if content_id supplied, use that
	} elseif( @BitBase::verifyId( $_REQUEST['content_id'] ) ) {
		$gContent = new BitSample( NULL, $_REQUEST['content_id'] );

	// otherwise create new object
	} else {
		$gContent = new BitSample();
	}

	$gContent->load();
	$gBitSmarty->assign_by_ref( "gContent", $gContent );
}
?>
