<?php

include('../../../../bootstrap.php');

$oMarmReview = new marm_laterreview_do();
$oMarmReview->startSending();

class marm_laterreview_do {    
    
    public function startSending(){
    
        $oConf = oxRegistry::getConfig();
            
        $sShopId = $oConf->getShopId();
        
        $marmLaterreviewCount       = $oConf->getShopConfVar('iCount', $sShopId, 'module:marm/laterreview');
        $marmLaterreviewDebug       = $oConf->getShopConfVar('blDebugMode', $sShopId, 'module:marm/laterreview');
        $marmLaterreviewLastorder   = $oConf->getShopConfVar('iStartWithOrder', $sShopId, 'module:marm/laterreview');
        $marmLaterreviewDelay       = $oConf->getShopConfVar('iDelay', $sShopId, 'module:marm/laterreview');
        $marmLaterreviewHidden      = $oConf->getShopConfVar('sToken', $sShopId, 'module:marm/laterreview');
        $marmLaterreviewMod         = $oConf->getShopConfVar('sMode', $sShopId, 'module:marm/laterreview');
        $marmLaterreviewSubject     = $oConf->getShopConfVar('sSubject', $sShopId, 'module:marm/laterreview');
        
        if($marmLaterreviewHidden != $_REQUEST['token']){
            die('forbidden');
        }
        
        
        $oDb = oxDb::getDb();
		$cats = array();
		
		$oOrder = oxNew( 'oxorder' );
        $sTable = $oOrder->getViewName();
        
        /*
		$sSelect = "SELECT * FROM {$sTable} WHERE marm_laterreview_status = 0 
		                                      AND OXSENDDATE != 0 
		                                      AND DATEDIFF(OXSENDDATE ,now()) < -".(int)$marmLaterreviewDelay."
		                                      AND OXORDERNR >=".(int)$marmLaterreviewLastorder."
                                              ORDER BY OXORDERNR 
		                                      LIMIT ".(int)$marmLaterreviewCount;
		*/
        // get only from germany or austria
        $sSelect = "SELECT * FROM {$sTable}  											  
											  WHERE marm_laterreview_status = 0
		                                      AND OXSENDDATE != 0 
		                                      AND DATEDIFF(OXSENDDATE ,now()) < -".(int)$marmLaterreviewDelay."
		                                      AND OXORDERNR >=".(int)$marmLaterreviewLastorder."
		                                      AND ( oxorder.OXDELCOUNTRYID IN (SELECT OXID from oxcountry WHERE OXISOALPHA2 IN ('DE', 'AT'))
		                                      OR (OXDELCOUNTRYID = '' AND OXBILLCOUNTRYID IN (SELECT OXID from oxcountry WHERE OXISOALPHA2 IN ('DE', 'AT'))) )
                                              ORDER BY OXORDERNR 
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
            
            if($wasSent)
            {            	
                if($marmLaterreviewDebug){
                    echo "E-Mail f&uuml;r die Bestellung ".$oOrd->oxorder__oxordernr->value." verschickt.<br/>\n";
                }
                $sUpdate = "UPDATE {$sTable} set marm_laterreview_status = 1 WHERE OXID =".$oDb->quote($oOrd->oxorder__oxid->value);             
                $oDb->Execute($sUpdate);
            }else{
                if($marmLaterreviewDebug){
                    echo "Fehler beim Versand der E-Mail f&uuml;r die Bestellung ".$oOrd->oxorder__oxordernr->value."<br />\n";
                }
                $sUpdate = "UPDATE {$sTable} set marm_laterreview_status = 2 WHERE OXID =".$oDb->quote($oOrd->oxorder__oxid->value);
                $oDb->Execute($sUpdate);
            }
        }
        
    }
}
