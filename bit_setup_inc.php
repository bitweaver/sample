<?php
global $gBitSystem;

$registerHash = array(
	'package_name' => 'sample',
	'package_path' => dirname( __FILE__ ).'/',
	'homeable' => TRUE,
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'sample' ) ) {
	$gBitSystem->registerAppMenu( SAMPLE_PKG_NAME, ucfirst( SAMPLE_PKG_DIR ), SAMPLE_PKG_URL.'index.php', 'bitpackage:sample/menu_sample.tpl', SAMPLE_PKG_NAME );
}
?>
