<?php
class marm_laterreview extends oxUBase {    
    
    public function render(){
        $oOxidConfig = oxConfig::getInstance();
        $marmLaterreviewCount = $oOxidConfig->getConfigParam( "marmLaterreviewCount" );
        $marmLaterreviewDebug = $oOxidConfig->getConfigParam( "marmLaterreviewDebug" );
        $marmLaterreviewLastorder = $oOxidConfig->getConfigParam( "marmLaterreviewLastorder" );
        $marmLaterreviewDelay = $oOxidConfig->getConfigParam( "marmLaterreviewDelay" );
        $marmLaterreviewHidden = $oOxidConfig->getConfigParam( "marmLaterreviewHidden" );
        $marmLaterreviewMod = $oOxidConfig->getConfigParam( "marmLaterreviewMod" );
        
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
		
		$oEmail = oxNew( "oxemail" );
		
        foreach($oOrders as $oOrd){
            
            $wasSent = $oEmail->sendReviewEmailToUser($oOrd, 'Bitte bewerten');
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