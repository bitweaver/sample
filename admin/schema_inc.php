<?php
$tables = array(
	'samples' => "
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

// Indexes
$gBitInstaller->registerSchemaIndexes( SAMPLE_PKG_NAME, array(
	'bit_samples_sample_id_idx' => array( 'table' => 'samples', 'cols' => 'sample_id', 'opts' => NULL ),
));

// Sequences
$gBitInstaller->registerSchemaSequences( SAMPLE_PKG_NAME, array (
	'sample_sample_id_seq'      => array( 'start' => 1 )
));

/* // Schema defaults
$gBitInstaller->registerSchemaDefault( SAMPLE_PKG_NAME, array(
	"INSERT INTO `".BIT_DB_PREFIX."bit_sample_types` (`type`) VALUES ('Sample')",
)); */

// User Permissions
$gBitInstaller->registerUserPermissions( SAMPLE_PKG_NAME, array(
	array ( 'p_sample_admin'  , 'Can admin sample'      , 'admin'      , SAMPLE_PKG_NAME ),
	array ( 'p_sample_update' , 'Can update any sample' , 'editors'    , SAMPLE_PKG_NAME ),
	array ( 'p_sample_create' , 'Can create a sample'   , 'registered' , SAMPLE_PKG_NAME ),
	array ( 'p_sample_view'   , 'Can view sample'       , 'basic'      , SAMPLE_PKG_NAME ),
));

// Default Preferences
$gBitInstaller->registerPreferences( SAMPLE_PKG_NAME, array(
	array ( SAMPLE_PKG_NAME , 'sample_default_ordering' , 'sample_id_desc' ),
	array ( SAMPLE_PKG_NAME , 'sample_list_sample_id'   , 'y'              ),
	array ( SAMPLE_PKG_NAME , 'sample_list_title'       , 'y'              ),
	array ( SAMPLE_PKG_NAME , 'sample_list_description' , 'y'              ),
	array ( SAMPLE_PKG_NAME , 'sample_list_samples'     , 'y'              ),
));

// Version
$gBitInstaller->registerPackageVersion( SAMPLE_PKG_NAME, '0.5.1' );

// Requirements
$gBitInstaller->registerRequirements( SAMPLE_PKG_NAME, array(
	'liberty' => array( 'min' => '2.1.0' ),
));
?>
