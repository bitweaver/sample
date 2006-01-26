<?php
global $gBitSystem;
$gBitSystem->registerPackage( 'sample', dirname(__FILE__).'/' );

if( $gBitSystem->isPackageActive( 'sample' ) ) {
	$gBitSystem->registerAppMenu( SAMPLE_PKG_NAME, ucfirst( SAMPLE_PKG_DIR ), SAMPLE_PKG_URL.'index.php', 'bitpackage:sample/menu_sample.tpl', SAMPLE_PKG_NAME );
}
?>
