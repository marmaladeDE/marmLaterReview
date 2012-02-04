<?php

//setting basic configuration parameters
ini_set('session.name', 'sid' );
ini_set('session.use_cookies', 0 );
ini_set('session.use_trans_sid', 0);
ini_set('url_rewriter.tags', '');
ini_set('magic_quotes_runtime', 0);

if (!function_exists('getShopBasePath')) {
    /**
     * Returns shop base path.
     *
     * @return string
     */
    function getShopBasePath()
    {
        return dirname(__FILE__).'/../../../';
    }
}

// START INCLUDE OXID FRAMEWORK BLOCK - DELETE IF NOT NEEDED

set_include_path(get_include_path() . PATH_SEPARATOR . getShopBasePath());

/**
 * Returns true.
 *
 * @return bool
 */
if ( !function_exists( 'isAdmin' )) {
    function isAdmin()
    {
        return true;
    }
}

error_reporting( E_ALL ^ E_NOTICE );

// custom functions file
include getShopBasePath() . 'modules/functions.php';
// Generic utility method file
require_once getShopBasePath() . 'core/oxfunctions.php';
// Including main ADODB include
require_once getShopBasePath() . 'core/adodblite/adodb.inc.php';

// END INCLUDE OXID FRAMEWORK BLOCK - DELETE IF NOT NEEDED


class marm_laterreview_do {    
    
    public function startSending(){
    
        $oOxidConfig = oxConfig::getInstance();
        $marmLaterreviewCount = $oOxidConfig->getConfigParam( "marmLaterreviewCount" );
        $marmLaterreviewDebug = $oOxidConfig->getConfigParam( "marmLaterreviewDebug" );
        $marmLaterreviewLastorder = $oOxidConfig->getConfigParam( "marmLaterreviewLastorder" );
        $marmLaterreviewDelay = $oOxidConfig->getConfigParam( "marmLaterreviewDelay" );
        $marmLaterreviewHidden = $oOxidConfig->getConfigParam( "marmLaterreviewHidden" );
        $marmLaterreviewMod = $oOxidConfig->getConfigParam( "marmLaterreviewMod" );
        $marmLaterreviewSubject = $oOxidConfig->getConfigParam( "marmLaterreviewSubject" );
        
        if($marmLaterreviewHidden != $_REQUEST['token']){
            die('forbidden');
        }
        
        
        $oDb = oxDb::getDb();
		$cats = array();
		
		$oOrder = oxNew( 'oxorder' );
        $sTable = $oOrder->getViewName();
        
		$sSelect = "SELECT * FROM {$sTable} WHERE marm_laterreview_status = 0 
		                                      AND OXSENDDATE != 0 
		                                      AND DATEDIFF(OXSENDDATE ,now()) < -".(int)$marmLaterreviewDelay."
		                                      AND OXORDERNR >=".(int)$marmLaterreviewLastorder."
		                                      LIMIT ".(int)$marmLaterreviewCount;


		$oOrders = oxNew( "oxlist" );
		$oOrders->init( 'oxorder' );
		$oOrders->selectString($sSelect);
		
        if($marmLaterreviewDebug && $oOrders->count() < 1)
        {
            die('Keine Mails zum Versand gefunden.');
        }
        
		$oEmail = oxNew( "oxemail" );
		
        foreach($oOrders as $oOrd){
            
            $wasSent = $oEmail->sendReviewEmailToUser($oOrd, $marmLaterreviewSubject);
            if($marmLaterreviewDebug){
                echo "Order mit id ".$oOrd->oxorder__oxid->value." send result: ".(int)$wasSent."<br/>";
            }
            if($wasSent){
                $sUpdate = "UPDATE {$sTable} set marm_laterreview_status = 1 WHERE OXID =".$oDb->quote($oOrd->oxorder__oxid->value);
                $oDb->Execute($sUpdate);
            }
        }
        
    }
}


$oMarmReview = new marm_laterreview_do();
$oMarmReview->startSending();