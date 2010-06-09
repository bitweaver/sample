<?php
/**
 * $Header$
 */
global $gBitInstaller;

$infoHash = array(
	'package' => SAMPLE_PKG_NAME,
	'version' => str_replace( '.php', '', basename( __FILE__ )),
	'description' => "Make sure all the package names in the kernel_config use singular of package name",
	'post_upgrade' => NULL,
);

$gBitInstaller->registerPackageUpgrade( $infoHash, array(

array( 'QUERY' =>
	array(
		'SQL92' => array("UPDATE `".BIT_DB_PREFIX."kernel_config` SET `package`='".SAMPLE_PKG_NAME."' WHERE `package`='".SAMPLE_PKG_NAME."s';"),
	),
),

)); // registerPackageUpgrade
?>
