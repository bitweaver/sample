<?php
// $Header: /cvsroot/bitweaver/_bit_sample/admin/admin_sample_inc.php,v 1.11 2009/01/20 22:21:15 dansut Exp $

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

// Process the form if we've made some changes
if( !empty( $_REQUEST['sample_settings'] )) {
	$sampleToggles = array_merge( $formSampleLists );
	foreach( $sampleToggles as $item => $data ) {
		simple_set_toggle( $item, SAMPLE_PKG_NAME );
	}
	simple_set_int( 'home_sample', SAMPLE_PKG_NAME );
}

// The list of samples is used to pick one to set the home
// we need to make sure that all samples are displayed
$_REQUEST['max_records'] = 0;

$sample = new BitSample();
$samples = $sample->getList( $_REQUEST );
$gBitSmarty->assign_by_ref( 'samples', $samples);
?>
