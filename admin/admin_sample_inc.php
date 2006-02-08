<?php
// $Header: /cvsroot/bitweaver/_bit_sample/admin/admin_sample_inc.php,v 1.7 2006/02/08 21:51:15 squareing Exp $
// Copyright (c) 2005 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// is this used?
//if (isset($_REQUEST["sampleset"]) && isset($_REQUEST["homeSample"])) {
//	$gBitSystem->storePreference("home_sample", $_REQUEST["homeSample"]);
//	$gBitSmarty->assign('home_sample', $_REQUEST["homeSample"]);
//}

require_once( SAMPLE_PKG_PATH.'BitSample.php' );

$formSampleLists = array(
	"sample_list_sample_id" => array(
		'label' => 'Id',
		'note' => 'Display the sample id.',
	),
	"sample_list_title" => array(
		'label' => 'Title',
		'note' => 'Display the title.',
	),
	"sample_list_description" => array(
		'label' => 'Description',
		'note' => 'Display the description.',
	),
	"sample_list_data" => array(
		'label' => 'Text',
		'note' => 'Display the text.',
	),
);
$gBitSmarty->assign( 'formSampleLists',$formSampleLists );

$processForm = set_tab();

if( $processForm ) {
	$sampleToggles = array_merge( $formSampleLists );
	foreach( $sampleToggles as $item => $data ) {
		simple_set_toggle( $item, 'samples' );
	}

}

$sample = new BitSample();
$samples = $sample->getList( $_REQUEST );
$gBitSmarty->assign_by_ref('samples', $samples['data']);
?>
