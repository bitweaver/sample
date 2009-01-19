<?php
// $Header: /cvsroot/bitweaver/_bit_sample/admin/admin_sample_inc.php,v 1.9 2009/01/19 19:27:20 dansut Exp $
// Copyright (c) 2005 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

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
	simple_set_toggle( 'home_sample', 'samples' );
}

$sample = new BitSample();
$samples = $sample->getList( $_REQUEST );
$gBitSmarty->assign_by_ref( 'samples', $samples);
?>
