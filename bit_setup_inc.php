<?php
global $gBitSystem;

$registerHash = array(
	'package_name' => 'sample',
	'package_path' => dirname( __FILE__ ).'/',
	'homeable' => TRUE,
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'sample' ) ) {
	$menuHash = array(
		'package_name'  => SAMPLE_PKG_NAME,
		'index_url'     => SAMPLE_PKG_URL.'index.php',
		'menu_template' => 'bitpackage:sample/menu_sample.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
}
?>
