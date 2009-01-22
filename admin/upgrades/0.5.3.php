<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sample/admin/upgrades/0.5.3.php,v 1.1 2009/01/22 21:18:30 dansut Exp $
 */
global $gBitInstaller; $infoHash = array(
	'package' => SAMPLE_PKG_NAME,
	'version' => str_replace( '.php', '', basename( __FILE__ )),
	'description' => "Update the kernel_config home_sample to be sample_home_id for naming consistency",
	'post_upgrade' => NULL,
);

$gBitInstaller->registerPackageUpgrade( $infoHash, array(

array( 'QUERY' =>
	array(
		'SQL92' => array("UPDATE `".BIT_DB_PREFIX."kernel_config` SET `package`='home_sample' WHERE `package`='sample_home_id';"),
	),
),

)); // registerPackageUpgrade
?>
