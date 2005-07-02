<?php

$tables = array('tiki_samples' => "
sample_id I4 AUTO PRIMARY,
content_id I4 NOTNULL,
description C(160)
",

);

global $gBitInstaller;

$gBitInstaller->makePackageHomeable(SAMPLE_PKG_NAME);

foreach(array_keys($tables ) AS $tableName ) {
    $gBitInstaller->registerSchemaTable(SAMPLE_PKG_DIR, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo(SAMPLE_PKG_DIR, array('description' => "Sample package to demonstrate how to build a bitweaver package.",
'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
'version' => '0.1',
'state' => 'beta',
'dependencies' => '',
) );

// ### Indexes
$indices = array('tiki_samples_sample_id_idx' => array('table' => 'tiki_samples', 'cols' => 'sample_id', 'opts' => NULL ),
);
$gBitInstaller->registerSchemaIndexes(SAMPLE_PKG_DIR, $indices );

/*// ### Sequences
$sequences = array (
'tiki_sample_id_seq' => array( 'start' => 1 )
);
$gBitInstaller->registerSchemaSequences( SAMPLE_PKG_DIR, $sequences );
*/


$gBitInstaller->registerSchemaDefault(SAMPLE_PKG_DIR, array(//      "INSERT INTO `".BIT_DB_PREFIX."tiki_sample_types` (`type`) VALUES ('Sample')",
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions(SAMPLE_PKG_NAME, array(array('bit_p_admin_sample', 'Can admin sample', 'admin', SAMPLE_PKG_NAME),
array('bit_p_create_sample', 'Can create a sample', 'registered', SAMPLE_PKG_NAME),
array('bit_p_edit_sample', 'Can edit any sample', 'editors', SAMPLE_PKG_NAME),
array('bit_p_read_sample', 'Can read sample', 'basic',  SAMPLE_PKG_NAME),
array('bit_p_remove_sample', 'Can delete sample', 'admin',  SAMPLE_PKG_NAME),
) );

// ### Default Preferences
$gBitInstaller->registerPreferences(SAMPLE_PKG_NAME, array(array(SAMPLE_PKG_NAME, 'sample_default_ordering','sample_id_desc'),
array(SAMPLE_PKG_NAME, 'sample_list_sample_id','y'),
array(SAMPLE_PKG_NAME, 'sample_list_title','y'),
array(SAMPLE_PKG_NAME, 'sample_list_description','y'),

array(SAMPLE_PKG_NAME, 'feature_listSamples','y'),
) );
?>
