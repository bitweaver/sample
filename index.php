<?php
// $Header: /cvsroot/bitweaver/_bit_sample/index.php,v 1.2 2006/01/26 12:29:30 squareing Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'sample' );

// Now check permissions to access this page
$gBitSystem->verifyPermission( 'bit_p_read_sample' );

if( !isset( $_REQUEST['sample_id'] ) ) {
	$_REQUEST['sample_id'] = $gBitSystem->getPreference( "home_sample" );
}

require_once( SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

// Display the template
$gBitSystem->display( 'bitpackage:sample/sample_display.tpl', tra( 'Sample' ) );
?>
