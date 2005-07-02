<?php
/**
* $Header: /cvsroot/bitweaver/_bit_sample/Attic/TikiSample.php,v 1.1 2005/07/02 14:56:31 bitweaver Exp $
*
* Copyright (c) 2004 bitweaver.org
* Copyright (c) 2003 tikwiki.org
* Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
* All Rights Reserved. See copyright.txt for details and a complete list of authors.
* Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
*
* $Id: TikiSample.php,v 1.1 2005/07/02 14:56:31 bitweaver Exp $
*/

/**
* Sample class to illustrate best practices when creating a new bitweaver package that
* builds on core bitweaver functionality, such as the Liberty CMS engine
*
* @date created 2004/8/15
*
* @author spider <spider@steelsun.com>
*
* @version $Revision: 1.1 $ $Date: 2005/07/02 14:56:31 $ $Author: bitweaver $
*
* @class TikiSample
*/

require_once(LIBERTY_PKG_PATH.'LibertyAttachable.php' );

    /**
* This is used to uniquely identify the object
*/
define('TIKISAMPLE_CONTENT_TYPE_GUID', 'tikisample' );

class TikiSample extends LibertyAttachable {
    /**
* Primary key for our mythical Sample class object & table
* @public
*/
    var $mSampleId;
    
    /**
* During initialisation, be sure to call our base constructors
**/
    function TikiSample($pSampleId=NULL, $pContentId=NULL )
    {
        LibertyAttachable::LibertyAttachable();
        $this->mSampleId = $pSampleId;
        $this->mContentId = $pContentId;
        $this->mContentTypeGuid = TIKISAMPLE_CONTENT_TYPE_GUID;
        $this->registerContentType(TIKISAMPLE_CONTENT_TYPE_GUID, array('content_type_guid' => TIKISAMPLE_CONTENT_TYPE_GUID,
        'content_description' => 'Sample package with bare essentials',
        'handler_class' => 'TikiSample',
        'handler_package' => 'sample',
        'handler_file' => 'TikiSample.php',
        'maintainer_url' => 'http://www.bitweaver.org'
        ) );
}

    /**
* Load the data from the database
* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
**/
    function load()
    {
        if (!empty($this->mSampleId ) || !empty($this->mContentId ) ) {
            // LibertyContent::load() assumes you have joined already, and will not execute any sql!
            // This is a significant performance optimization
            $lookupColumn = !empty($this->mSampleId ) ? 'sample_id' : 'content_id';
            $lookupId = !empty($this->mSampleId ) ? $this->mSampleId : $this->mContentId;
            $query = "SELECT ts.*, tc.*, " .
            "uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name, " .
            "uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name " .
            "FROM `".BIT_DB_PREFIX."tiki_samples` ts " .
            "INNER JOIN `".BIT_DB_PREFIX."tiki_content` tc ON (tc.`content_id` = ts.`content_id`) " .
            "LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = tc.`modifier_user_id`) " .
            "LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = tc.`user_id`) " .
            "WHERE ts.`$lookupColumn`=?";
            $result = $this->query($query, array($lookupId ) );
            
            if ($result && $result->numRows() ) {
                $this->mInfo = $result->fields;
                $this->mContentId = $result->fields['content_id'];
                $this->mSampleId = $result->fields['sample_id'];
                
                $this->mInfo['creator'] = (isset($result->fields['creator_real_name'] ) ? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
                $this->mInfo['editor'] = (isset($result->fields['modifier_real_name'] ) ? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
                $this->mInfo['display_url'] = $this->getDisplayUrl();
                
                LibertyAttachable::load();
            }
        }
        return(count($this->mInfo ) );
    }
    
    /**
* Any method named Store inherently implies data will be written to the database
* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
* This is the ONLY method that should be called in order to store (create or update) an sample!
* It is very smart and will figure out what to do for you. It should be considered a black box.
*
* @param array pParams hash of values that will be used to store the page
*
* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
*
* @access public
**/
    function store(&$pParamHash )
    {
        if ($this->verify($pParamHash ) && LibertyAttachable::store($pParamHash ) ) {
            $table = BIT_DB_PREFIX."tiki_samples";
            $this->mDb->StartTrans();
            if ($this->mSampleId ) {
                $locId = array("name" => "sample_id", "value" => $pParamHash['sample_id'] );
                $result = $this->associateUpdate($table, $pParamHash['sample_store'], $locId );
            } else {
                $pParamHash['sample_store']['content_id'] = $pParamHash['content_id'];
                if (isset($pParamHash['sample_id'] ) && is_numeric($pParamHash['sample_id'] ) ) {
                    // if pParamHash['sample_id'] is set, some is requesting a particular sample_id. Use with caution!
                    $pParamHash['sample_store']['sample_id'] = $pParamHash['sample_id'];
                } else {
                    $pParamHash['sample_store']['sample_id'] = $this->GenID('tiki_samples_sample_id_seq');
                }
                $this->mSampleId = $pParamHash['sample_store']['sample_id'];
                
                $result = $this->associateInsert($table, $pParamHash['sample_store'] );
            }
            
            
            $this->mDb->CompleteTrans();
            $this->load();
        }
        return(count($this->mErrors ) == 0 );
    }
    
    /**
* Make sure the data is safe to store
* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
* This function is responsible for data integrity and validation before any operations are performed with the $pParamHash
* NOTE: This is a PRIVATE METHOD!!!! do not call outside this class, under penalty of death!
*
* @param array pParams reference to hash of values that will be used to store the page, they will be modified where necessary
*
* @return bool TRUE on success, FALSE if verify failed. If FALSE, $this->mErrors will have reason why
*
* @access private
**/
    function verify(&$pParamHash )
    {
        global $gBitUser, $gBitSystem;
        
        // make sure we're all loaded up of we have a mSampleId
        if ($this->mSampleId && empty($this->mInfo ) ) {
            $this->load();
        }
        
        if (!empty($this->mInfo['content_id'] ) ) {
            $pParamHash['content_id'] = $this->mInfo['content_id'];
        }
        
        // It is possible a derived class set this to something different
        if (empty($pParamHash['content_type_guid'] ) ) {
            $pParamHash['content_type_guid'] = $this->mContentTypeGuid;
        }
        
        if (!empty($pParamHash['content_id'] ) ) {
            $pParamHash['sample_store']['content_id'] = $pParamHash['content_id'];
        }
        
        // check some lengths, if too long, then truncate
        if ($this->isValid() && !empty($this->mInfo['description'] ) && empty($pParamHash['description'] ) ) {
            // someone has deleted the description, we need to null it out
            $pParamHash['sample_store']['description'] = '';
        } else if (empty($pParamHash['description'] ) ) {
            unset($pParamHash['description'] );
        } else {
            $pParamHash['sample_store']['description'] = substr($pParamHash['description'], 0, 200 );
        }

        if (!empty($pParamHash['data'] ) ) {
            $pParamHash['content_store']['data'] = $pParamHash['data'];
        }
        
        // check for name issues, first truncate length if too long
        if (!empty($pParamHash['title']) ) {
            if (empty($this->mSampleId ) ) {
                if (empty($pParamHash['title'] ) ) {
                    $this->mErrors['title'] = 'You must enter a name for this page.';
                } else {
                    $pParamHash['content_store']['title'] = substr($pParamHash['title'], 0, 160 );
                }
            } else {
                $pParamHash['content_store']['title'] = ( isset($pParamHash['title'] ) ) ? substr($pParamHash['title'], 0, 160 ) : '';
            }
        } else if (empty($pParamHash['title'] ) ) {
            // no name specified
            $this->mErrors['title'] = 'You must specify a name';
        }
        
        return(count($this->mErrors ) == 0 );
    }
    
    function expunge()
    {
        $ret = FALSE;
        if ($this->isValid() ) {
            $this->mDb->StartTrans();
            $query = "DELETE FROM `".BIT_DB_PREFIX."tiki_samples` WHERE `content_id` = ?";
            $result = $this->query($query, array($this->mContentId ) );
            if (LibertyAttachable::expunge() ) {
                $ret = TRUE;
                $this->mDb->CompleteTrans();
            } else {
                $this->mDb->RollbackTrans();
            }
        }
        return $ret;
    }
    
    function isValid()
    {
        return(!empty($this->mSampleId ) );
    }
    
    /**
* This function generates a list of records from the tiki_content database for use in a list page
**/
    function getList(&$pParamHash )
    {
        
        LibertyContent::prepGetList($pParamHash );
        
        $find = $pParamHash['find'];
        $sort_mode = $pParamHash['sort_mode'];
        $max_records = $pParamHash['max_records'];
        $offset = $pParamHash['offset'];
        
        if (is_array($find)) {
            // you can use an array of pages
            $mid = " WHERE tc.`title` IN (".implode(',',array_fill(0,count($find),'?')).")";
            $bindvars = $find;
        } else if (is_string($find)) {
            // or a string
            $mid = " WHERE UPPER(tc.`title`) like ? ";
            $bindvars = array('%' . strtoupper( $find ) . '%');
        } else if (!empty($pUserId ) ) {
            // or a string
            $mid = " WHERE tc.`creator_user_id` = ? ";
            $bindvars = array($pUserId );
        } else {
            $mid = "";
            $bindvars = array();
        }
        
        $query = "SELECT ts.*, tc.`content_id`, tc.`title`, tc.`data`
FROM `".BIT_DB_PREFIX."tiki_samples` ts INNER JOIN `".BIT_DB_PREFIX."tiki_content` tc ON (tc.`content_id` = ts.`content_id`)
".(!empty($mid ) ? $mid.' AND ' : ' WHERE ')." tc.`content_type_guid` = '".TIKISAMPLE_CONTENT_TYPE_GUID."'
ORDER BY ".$this->convert_sortmode($sort_mode);
        $query_cant = "select count(*) from `".BIT_DB_PREFIX."tiki_content` tc ".(!empty($mid ) ? $mid.' AND ' : ' WHERE ')." tc.`content_type_guid` = '".TIKISAMPLE_CONTENT_TYPE_GUID."'";
        $result = $this->query($query,$bindvars,$max_records,$offset);
        $ret = array();
        while ($res = $result->fetchRow()) {
            $ret[] = $res;
        }
        $pParamHash["data"] = $ret;
        
        $pParamHash["cant"] = $this->getOne($query_cant,$bindvars);
        
        LibertyContent::postGetList($pParamHash );
        return $pParamHash;
    }

    /**
* Generates the URL to the sample page
* @param pExistsHash the hash that was returned by LibertyContent::pageExists
* @return the link to display the page.
*/
    function getDisplayUrl()
    {
        $ret = NULL;
        if (!empty($this->mSampleId ) ) {
            $ret = SAMPLE_PKG_URL."index.php?sample_id=".$this->mSampleId;
        }
        return $ret;
    }
    
}
?>
