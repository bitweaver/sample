<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_sample/admin/schema_inc.php,v 1.20 2009/01/29 16:23:34 dansut Exp $
 * @package sample
 */
$tables = array(
	'sample_data' => "
		sample_id I4 PRIMARY,
		content_id I4 NOTNULL,
		description C(160)
	",
);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( SAMPLE_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( SAMPLE_PKG_NAME, array(
	'description' => "Sample package to demonstrate how to build a bitweaver package.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
));

// $indices = array();
// $gBitInstaller->registerSchemaIndexes( ARTICLES_PKG_NAME, $indices );

// Sequences
$gBitInstaller->registerSchemaSequences( SAMPLE_PKG_NAME, array (
	'sample_data_id_seq' => array( 'start' => 1 )
));

/* // Schema defaults
$gBitInstaller->registerSchemaDefault( SAMPLE_PKG_NAME, array(
	"INSERT INTO `".BIT_DB_PREFIX."bit_sample_types` (`type`) VALUES ('Sample')",
)); */

// User Permissions
$gBitInstaller->registerUserPermissions( SAMPLE_PKG_NAME, array(
	array ( 'p_sample_admin'  , 'Can admin sample'           , 'admin'      , SAMPLE_PKG_NAME ),
	array ( 'p_sample_update' , 'Can update any sample entry', 'editors'    , SAMPLE_PKG_NAME ),
	array ( 'p_sample_create' , 'Can create a sample entry'  , 'registered' , SAMPLE_PKG_NAME ),
	array ( 'p_sample_view'   , 'Can view sample data'       , 'basic'      , SAMPLE_PKG_NAME ),
	array ( 'p_sample_expunge', 'Can delete any sample entry', 'admin'      , SAMPLE_PKG_NAME ),
));

// Default Preferences
$gBitInstaller->registerPreferences( SAMPLE_PKG_NAME, array(
	array ( SAMPLE_PKG_NAME , 'sample_default_ordering' , 'sample_id_desc' ),
	array ( SAMPLE_PKG_NAME , 'sample_list_sample_id'   , 'y'              ),
	array ( SAMPLE_PKG_NAME , 'sample_list_title'       , 'y'              ),
	array ( SAMPLE_PKG_NAME , 'sample_list_description' , 'y'              ),
	array ( SAMPLE_PKG_NAME , 'sample_home_id'          , 0                ),
));

// Version - now use upgrades dir to set package version number.
// $gBitInstaller->registerPackageVersion( SAMPLE_PKG_NAME, '0.5.1' );

// Requirements
$gBitInstaller->registerRequirements( SAMPLE_PKG_NAME, array(
	'liberty' => array( 'min' => '2.1.0' ),
));
?>
