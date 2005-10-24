<?php
// $Header: /cvsroot/bitweaver/_bit_sample/Attic/list_samples.php,v 1.3 2005/10/24 19:47:32 squareing Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// Initialization
require_once('../bit_setup_inc.php' );
require_once(SAMPLE_PKG_PATH.'BitSample.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage('sample' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('bit_p_read_sample' );

/* mass-remove:
   the checkboxes are sent as the array $_REQUEST["checked[]"], values are the wiki-PageNames,
   e.g. $_REQUEST["checked"][3]="HomePage"
   $_REQUEST["submit_mult"] holds the value of the "with selected do..."-option list
   we look if any page's checkbox is on and if remove_samples is selected.
   then we check permission to delete samples.
   if so, we call histlib's method remove_all_versions for all the checked samples.
*/
if (isset($_REQUEST["submit_mult"]) && isset($_REQUEST["checked"]) && $_REQUEST["submit_mult"] == "remove_samples") {
        

        // Now check permissions to remove the selected samples
        $gBitSystem->verifyPermission( 'bit_p_remove_sample' );
                                                                                                                                                                            
        if( !empty( $_REQUEST['cancel'] ) ) {
                // user cancelled - just continue on, doing nothing
        } elseif( empty( $_REQUEST['confirm'] ) ) {
                $formHash['delete'] = TRUE;
                $formHash['submit_mult'] = 'remove_samples';
                foreach( $_REQUEST["checked"] as $del ) {
                        $formHash['input'][] = '<input type="hidden" name="checked[]" value="'.$del.'"/>';
                }
                $gBitSystem->confirmDialog( $formHash, array( 'warning' => 'Are you sure you want to delete '.count($_REQUEST["checked"]).' samples?', 'error' => 'This cannot be undone!' ) );
        } else {
                foreach ($_REQUEST["checked"] as $deleteId) {
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


$sample = new BitSample();
$listsamples = $sample->getList( $_REQUEST );



$gBitSmarty->assign_by_ref('control', $_REQUEST["control"]);
$gBitSmarty->assign_by_ref('list', $listsamples["data"]);

// Display the template
$gBitSystem->display('bitpackage:sample/list_samples.tpl', tra('Sample') );

?>
