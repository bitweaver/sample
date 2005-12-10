<?php
global $gBitSystem;
$gBitSystem->registerPackage( 'sample', dirname(__FILE__).'/' );

if ($gBitSystem->isPackageActive( 'sample' ) ) {
    $gBitSystem->registerAppMenu( SAMPLE_PKG_DIR, 'Sample', SAMPLE_PKG_URL.'index.php', 'bitpackage:sample/menu_sample.tpl', 'sample' );
}

?>
