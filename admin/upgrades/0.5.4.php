<?php
/**
 * $Header$
 */
global $gBitInstaller;

$infoHash = array(
	'package' => SAMPLE_PKG_NAME,
	'version' => str_replace( '.php', '', basename( __FILE__ )),
	'description' => "Remove most of plural usage of package name, and fix admin home id initial selection",
	'post_upgrade' => NULL,
);

$gBitInstaller->registerPackageUpgrade( $infoHash, array(

array( 'DATADICT' => array(
	array( 'RENAMETABLE' => array(
			'samples' => 'sample_data',
			'samples_sample_id_seq' => 'sample_data_id_seq',
		),
	)),
), // DATDICT

array( 'QUERY' =>
	array( 'SQL92' => array(
			"DELETE FROM `".BIT_DB_PREFIX."kernel_config` WHERE `config_name` = 'sample_list_samples'",
		),
	),
), // QUERY

)); // registerPackageUpgrade
?>
