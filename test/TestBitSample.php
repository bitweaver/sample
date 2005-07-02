<?php
require_once('../../bit_setup_inc.php');
require_once(SAMPLE_PKG_PATH.'BitSample.php');

class TestBitSample extends Test {
    
    var $test;
    var $id;
    var $count;
    
    function TestBitSample()
    {
        global $gBitSystem;
        Assert::equalsTrue($gBitSystem->isPackageActive( 'sample' ), 'Package not active');
    }

    function testCreateItem()
    {
        $this->test = new BitSample();
        Assert::equalsTrue($this->test != NULL, 'Error during initialisation');
    }

    function testGetItems()
    {
	$filter = array();
        $list = $this->test->getList($filter);
        $this->count = count($list);
        Assert::equalsTrue(is_array($list));
    }

    function testStoreItem()
    {
	$newItemHash = array(
		"title" => "Test Title",
		"description" => "Test Description",
		"data" => "Test Text"
	);
        Assert::equalsTrue($this->test->store($newItemHash));
    }
    
    function testIsValidItem()
    {
        Assert::equalsTrue($this->test->isValid());
    }
    
    function testNullItem()
    {
	$this->id = $this->test->mSampleId;
        $this->test = NULL;
        Assert::equals($this->test, NULL);
    }
    
    function testLoadItem()
    {
        $this->test = new BitSample($this->id);
        Assert::equals($this->test->load(), 23);
    }

    function testUrlItem()
    {
        Assert::equalsTrue($this->test->getDisplayUrl() != "");
    }

    function testExpungeItem()
    {
        Assert::equalsTrue($this->test->expunge());
    }

    function testCountItems()
    {
	$filter = array();
        $count = count($this->test->getList($filter));
        Assert::equals($this->count, $count);
    }

}
?>
