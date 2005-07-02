<?php
// $Header: /cvsroot/bitweaver/_bit_sample/edit.php,v 1.1 2005/07/02 14:56:31 bitweaver Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once('../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage('sample' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('bit_p_edit_sample' );

require_once(SAMPLE_PKG_PATH.'lookup_sample_inc.php' );

if (isset($_REQUEST["title"])) {
    $gContent->mInfo["title"] = $_REQUEST["title"];
}

if (isset($_REQUEST["description"])) {
    $gContent->mInfo["description"] = $_REQUEST["description"];
}

if (isset($_REQUEST["data"])) {
    $gContent->mInfo["data"] = $_REQUEST["data"];
}

// If we are in preview mode then preview it!
if (isset($_REQUEST["preview"])) {
    $smarty->assign('preview', 'y');
}

// Pro
// Check if the page has changed
if (!empty($_REQUEST["save_sample"])) {
    
    // Check if all Request values are delivered, and if not, set them
    // to avoid error messages. This can happen if some features are
    // disabled
    if ($gContent->store( $_REQUEST ) ) {
        header("Location: ".$gContent->getDisplayUrl() );
        die;
    } else {
        $smarty->assign_by_ref('errors', $gContent->mErrors );
    }
}

// WYSIWYG and Quicktag variable
$smarty->assign( 'textarea_id', 'editsample' );



// Display the template
$gBitSystem->display('bitpackage:sample/edit_sample.tpl', tra('Sample') );
?>
