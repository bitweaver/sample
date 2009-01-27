<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sample/admin/upgrades/0.5.4.php,v 1.1 2009/01/27 22:28:09 dansut Exp $
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
