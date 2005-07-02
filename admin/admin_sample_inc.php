<?php
// $Header: /cvsroot/bitweaver/_bit_sample/admin/admin_sample_inc.php,v 1.2 2005/07/02 15:17:22 wolff_borg Exp $
// Copyright (c) 2005 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

if (isset($_REQUEST["sampleset"]) && isset($_REQUEST["homeSample"])) {
    $gBitSystem->storePreference("home_sample", $_REQUEST["homeSample"]);
    $smarty->assign('home_sample', $_REQUEST["homeSample"]);
}

require_once(SAMPLE_PKG_PATH.'BitSample.php' );

$sample = new BitSample();
$samples = $sample->getList( $_REQUEST );
$smarty->assign_by_ref('samples', $samples['data']);
?>
