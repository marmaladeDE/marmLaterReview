<?php
class marm_laterreview_oxemail extends marm_laterreview_oxemail_parent{
    
    public function sendReviewEmailToUser( $oOrder, $sSubject = null )
    {
        $myConfig = $this->getConfig();

        // add user defined stuff if there is any
        //$oOrder = $this->_addUserInfoOrderEMail( $oOrder );

        $oShop = $this->_getShop();
        $this->_setMailParams( $oShop );

        $oUser = $oOrder->getOrderUser(); 
        
        // create messages
        $oSmarty = $this->_getSmarty();
        
        if(method_exists($this, 'setUser')){
            $this->setUser( $oUser );   
        }else{
            $oShop = $this->_getShop();
            $oSmarty->assign( "user", $oUser );
            $oSmarty->assign( "shop", $oShop );
            $oSmarty->assign( "oViewConf", $oShop );
        }

        
        
        $oSmarty->assign( "order", $oOrder);

        $oOrderArt = oxNew( 'oxorderarticle' );
        $oOrderArtTable = $oOrderArt->getViewName();
        
        $sSelect = "SELECT * FROM {$oOrderArtTable} WHERE OXORDERID = ".(int)$oOrder->oxorder__oxid->value;

		$oArticels = oxNew( "oxlist" );
		$oArticels->init( 'oxorderarticle' );
		$oArticels->selectString($sSelect);
        
        $oSmarty->assign( "articels" , $oArticels);
 
        // Process view data array through oxoutput processor
        if(method_exists($this, '_processViewArray')){
            $this->_processViewArray();
        }else{
            $oOutputProcessor = oxNew( "oxoutput" );
            $aNewSmartyArray = $oOutputProcessor->processViewArray( $oSmarty->get_template_vars(), "oxemail" );  
            foreach ( $aNewSmartyArray as $key => $val ) {
                $oSmarty->assign( $key, $val );
            }
        }
        $this->setBody( $oSmarty->fetch( 'email/html/order_review.tpl' ) );
        $this->setAltBody( $oSmarty->fetch( 'email/html/order_review.tpl' ) );

        // #586A
        if ( $sSubject === null ) {
            if ( $oSmarty->template_exists( $this->_sOrderUserSubjectTemplate) ) {
                $sSubject = $oSmarty->fetch( $this->_sOrderUserSubjectTemplate );
            } else {
                $sSubject = $oShop->oxshops__oxordersubject->getRawValue()." (#".$oOrder->oxorder__oxordernr->value.")";
            }
        }

        $this->setSubject( $sSubject );

        $sFullName = $oUser->oxuser__oxfname->getRawValue() . " " . $oUser->oxuser__oxlname->getRawValue();

        $this->setRecipient( $oUser->oxuser__oxusername->value, $sFullName );
        $this->setReplyTo( $oShop->oxshops__oxorderemail->value, $oShop->oxshops__oxname->getRawValue() );

        $blSuccess = $this->send();

        return $blSuccess;
    }
    
}