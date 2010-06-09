<?php
/**
* $Header$
* $Id$
*/

/**
* Sample class to illustrate best practices when creating a new bitweaver package that
* builds on core bitweaver functionality, such as the Liberty CMS engine
*
* date created 2004/8/15
* @author spider <spider@steelsun.com>
* @version $Revision$
* @class BitSample
*/

require_once( LIBERTY_PKG_PATH.'LibertyMime.php' );

/**
* This is used to uniquely identify the object
*/
define( 'BITSAMPLE_CONTENT_TYPE_GUID', 'bitsample' );

class BitSample extends LibertyMime {
	/**
	 * mSampleId Primary key for our mythical Sample class object & table
	 * 
	 * @var array
	 * @access public
	 */
	var $mSampleId;

	/**
	 * BitSample During initialisation, be sure to call our base constructors
	 * 
	 * @param numeric $pSampleId 
	 * @param numeric $pContentId 
	 * @access public
	 * @return void
	 */
	function BitSample( $pSampleId=NULL, $pContentId=NULL ) {
		LibertyMime::LibertyMime();
		$this->mSampleId = $pSampleId;
		$this->mContentId = $pContentId;
		$this->mContentTypeGuid = BITSAMPLE_CONTENT_TYPE_GUID;
		$this->registerContentType( BITSAMPLE_CONTENT_TYPE_GUID, array(
			'content_type_guid'   => BITSAMPLE_CONTENT_TYPE_GUID,
			'content_name' => 'Bitweaver sample package data',
			'content_name_plural' => 'Bitweaver sample package data',
			'handler_class'       => 'BitSample',
			'handler_package'     => 'sample',
			'handler_file'        => 'BitSample.php',
			'maintainer_url'      => 'http://www.bitweaver.org'
		));
		// Permission setup
		$this->mViewContentPerm    = 'p_sample_view';
		$this->mCreateContentPerm  = 'p_sample_create';
		$this->mUpdateContentPerm  = 'p_sample_update';
		$this->mAdminContentPerm   = 'p_sample_admin';
		$this->mExpungeContentPerm = 'p_sample_expunge';
	}

	/**
	 * load Load the data from the database
	 * 
	 * @access public
	 * @return boolean TRUE on success, FALSE on failure - mErrors will contain reason for failure
	 */
	function load() {
		if( $this->verifyId( $this->mSampleId ) || $this->verifyId( $this->mContentId ) ) {
			// LibertyContent::load()assumes you have joined already, and will not execute any sql!
			// This is a significant performance optimization
			$lookupColumn = $this->verifyId( $this->mSampleId ) ? 'sample_id' : 'content_id';
			$bindVars = array();
			$selectSql = $joinSql = $whereSql = '';
			array_push( $bindVars, $lookupId = @BitBase::verifyId( $this->mSampleId ) ? $this->mSampleId : $this->mContentId );
			$this->getServicesSql( 'content_load_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

			$query = "
				SELECT sample.*, lc.*,
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name
				$selectSql
				FROM `".BIT_DB_PREFIX."sample_data` sample
					INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = sample.`content_id` ) $joinSql
					LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON( uue.`user_id` = lc.`modifier_user_id` )
					LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON( uuc.`user_id` = lc.`user_id` )
				WHERE sample.`$lookupColumn`=? $whereSql";
			$result = $this->mDb->query( $query, $bindVars );

			if( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = $result->fields['content_id'];
				$this->mSampleId = $result->fields['sample_id'];

				$this->mInfo['creator'] = ( !empty( $result->fields['creator_real_name'] ) ? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
				$this->mInfo['editor'] = ( !empty( $result->fields['modifier_real_name'] ) ? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
				$this->mInfo['display_name'] = BitUser::getTitle( $this->mInfo );
				$this->mInfo['display_url'] = $this->getDisplayUrl();
				$this->mInfo['parsed_data'] = $this->parseData();

				LibertyMime::load();
			}
		}
		return( count( $this->mInfo ) );
	}

	/**
	 * store Any method named Store inherently implies data will be written to the database
	 * @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	 * This is the ONLY method that should be called in order to store( create or update )an sample!
	 * It is very smart and will figure out what to do for you. It should be considered a black box.
	 * 
	 * @param array $pParamHash hash of values that will be used to store the page
	 * @access public
	 * @return boolean TRUE on success, FALSE on failure - mErrors will contain reason for failure
	 */
	function store( &$pParamHash ) {
		if( $this->verify( $pParamHash ) ) {
			$this->mDb->StartTrans();
			if( LibertyMime::store( $pParamHash ) ) {
				$table = BIT_DB_PREFIX."sample_data";
				if( $this->mSampleId ) {
					$locId = array( "sample_id" => $this->mSampleId );
					$this->mDb->associateUpdate( $table, $pParamHash['sample_store'], $locId );
				} else {
					$pParamHash['sample_store']['content_id'] = $pParamHash['content_id'];
					$pParamHash['sample_store']['sample_id'] = $this->mDb->GenID( 'sample_data_id_seq' );
					$this->mSampleId = $pParamHash['sample_store']['sample_id'];
					$this->mDb->associateInsert( $table, $pParamHash['sample_store'] );
				}
			} else {
				$this->mErrors['store'] = 'Could not store Liberty data to save this sample.';
			}
			if( !$this->mDb->CompleteTrans() ) {
				$this->mErrors['store'] = 'Sample store: '.$this->mDb->ErrorMsg();
			}
			$this->load();
		} else {
			$this->mErrors['store'] = 'Could not verify data to save this sample.';
		}

		return( count( $this->mErrors )== 0 );
	}

	/**
	 * verify Make sure the data is safe to store
	 * @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	 * This function is responsible for data integrity and validation before any operations are performed with the $pParamHash
	 * NOTE: This is a PRIVATE METHOD!!!! do not call outside this class, under penalty of death!
	 * 
	 * @param array $pParamHash reference to hash of values that will be used to store the page, they will be modified where necessary
	 * @access private
	 * @return boolean TRUE on success, FALSE on failure - $this->mErrors will contain reason for failure
	 */
	function verify( &$pParamHash ) {
		// make sure we're all loaded up if we have a mSampleId
		if( $this->verifyId( $this->mSampleId ) && empty( $this->mInfo ) ) {
			$this->load();
		}

		if( @$this->verifyId( $this->mInfo['content_id'] ) ) {
			$pParamHash['content_id'] = $this->mInfo['content_id'];
		}

		// It is possible a derived class set this to something different
		if( @$this->verifyId( $pParamHash['content_type_guid'] ) ) {
			$pParamHash['content_type_guid'] = $this->mContentTypeGuid;
		}

		if( @$this->verifyId( $pParamHash['content_id'] ) ) {
			$pParamHash['sample_store']['content_id'] = $pParamHash['content_id'];
		}

		// check some lengths, if too long, then truncate
		if( $this->isValid() && !empty( $this->mInfo['description'] ) && empty( $pParamHash['sample']['description'] ) ) {
			// someone has deleted the description, we need to null it out
			$pParamHash['sample_store']['description'] = '';
		} else if( empty( $pParamHash['sample']['description'] ) ) {
			unset( $pParamHash['sample']['description'] );
		} else {
			$pParamHash['sample_store']['description'] = substr( $pParamHash['sample']['description'], 0, 200 );
		}

		if( !empty( $pParamHash['data'] ) ) {
			$pParamHash['edit'] = $pParamHash['data'];
		}

		// If title specified truncate to make sure not too long
		if( !empty( $pParamHash['title'] ) ) {
			$pParamHash['content_store']['title'] = substr( $pParamHash['title'], 0, 160 );
		} else if( empty( $pParamHash['title'] ) ) { // else is error as must have title
			$this->mErrors['title'] = 'You must enter a title for this sample.';
		}

		return( count( $this->mErrors )== 0 );
	}

	/**
	 * expunge 
	 * 
	 * @access public
	 * @return boolean TRUE on success, FALSE on failure
	 */
	function expunge() {
		global $gBitSystem;
		$ret = FALSE;
		if( $this->isValid() ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."sample_data` WHERE `content_id` = ?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );
			if( LibertyMime::expunge() ) {
				$ret = TRUE;
			}
			$this->mDb->CompleteTrans();
			// If deleting the default/home sample record then unset this.
			if( $ret && $gBitSystem->getConfig( 'sample_home_id' ) == $this->mSampleId ) {
				$gBitSystem->storeConfig( 'sample_home_id', 0, SAMPLE_PKG_NAME );
			}
		}
		return $ret;
	}

	/**
	 * isValid Make sure sample is loaded and valid
	 * 
	 * @access public
	 * @return boolean TRUE on success, FALSE on failure
	 */
	function isValid() {
		return( @BitBase::verifyId( $this->mSampleId ) && @BitBase::verifyId( $this->mContentId ));
	}

	/**
	 * getList This function generates a list of records from the liberty_content database for use in a list page
	 * 
	 * @param array $pParamHash 
	 * @access public
	 * @return array List of sample data
	 */
	function getList( &$pParamHash ) {
		// this makes sure parameters used later on are set
		LibertyContent::prepGetList( $pParamHash );

		$selectSql = $joinSql = $whereSql = '';
		$bindVars = array();
		array_push( $bindVars, $this->mContentTypeGuid );
		$this->getServicesSql( 'content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		if( is_array( $find ) ) {
			// you can use an array of pages
			$whereSql .= " AND lc.`title` IN( ".implode( ',',array_fill( 0,count( $find ),'?' ) )." )";
			$bindVars = array_merge ( $bindVars, $find );
		} elseif( is_string( $find ) ) {
			// or a string
			$whereSql .= " AND UPPER( lc.`title` )like ? ";
			$bindVars[] = '%' . strtoupper( $find ). '%';
		}

		$query = "
			SELECT sample.*, lc.`content_id`, lc.`title`, lc.`data` $selectSql
			FROM `".BIT_DB_PREFIX."sample_data` sample
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = sample.`content_id` ) $joinSql
			WHERE lc.`content_type_guid` = ? $whereSql
			ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
		$query_cant = "
			SELECT COUNT(*)
			FROM `".BIT_DB_PREFIX."sample_data` sample
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = sample.`content_id` ) $joinSql
			WHERE lc.`content_type_guid` = ? $whereSql";
		$result = $this->mDb->query( $query, $bindVars, $max_records, $offset );
		$ret = array();
		while( $res = $result->fetchRow() ) {
			$ret[] = $res;
		}
		$pParamHash["cant"] = $this->mDb->getOne( $query_cant, $bindVars );

		// add all pagination info to pParamHash
		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}

	/**
	 * getDisplayUrl Generates the URL to the sample page
	 * 
	 * @access public
	 * @return string URL to the sample page
	 */
	function getDisplayUrl() {
		global $gBitSystem;
		$ret = NULL;
		if( @$this->isValid() ) {
			if( $gBitSystem->isFeatureActive( 'pretty_urls' ) || $gBitSystem->isFeatureActive( 'pretty_urls_extended' )) {
				$ret = SAMPLE_PKG_URL.$this->mSampleId;
			} else {
				$ret = SAMPLE_PKG_URL."index.php?sample_id=".$this->mSampleId;
			}
		}
		return $ret;
	}
}
?>
