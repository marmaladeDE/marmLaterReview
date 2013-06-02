<?php
class marm_laterreview_oxemail extends marm_laterreview_oxemail_parent{


    /**
     * Name of template used for review email for comments in shop
     *
     * @var string
     */
    protected $_sReviewTemplateShop = 'marm_email_order_review_shop.tpl';

    /**
     * Name of plain template used for review email for comments in shop
     *
     * @var string
     */
    protected $_sReviewTemplatePlainShop = 'marm_email_order_review_shop_plain.tpl'; 

    /**
     * Name of template used for review email with trusted shops link
     *
     * @var string
     */
    protected $_sReviewTemplateTS = 'marm_email_order_review_ts.tpl';

    /**
     * Name of plain template used for review email with trusted shops link
     *
     * @var string
     */
    protected $_sReviewTemplatePlainTS = 'marm_email_order_review_ts_plain.tpl'; 
    
    
    
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
        
        // Just temp!!!!!
        $sMarmTempTsUrl = $this->getTempTsUrl($oUser->oxuser__oxusername->value,$oOrder->oxorder__oxordernr->value);
        $oSmarty->assign( "sMarmTempTsUrl", $sMarmTempTsUrl);

        $oOrderArt = oxNew( 'oxorderarticle' );
        $oOrderArtTable = $oOrderArt->getViewName();
        
        $sSelect = "SELECT * FROM {$oOrderArtTable} WHERE OXORDERID = '".$oOrder->oxorder__oxid->value."'";

        
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
        
        // Set the template for mail
        $this->setMarmBody();
        
        // #586A
        if ( $sSubject === null ) {
            if ( $oSmarty->template_exists( $this->_sOrderUserSubjectTemplate) ) {
                $sSubject = $oSmarty->fetch( $this->_sOrderUserSubjectTemplate );
            } else {
                $sSubject = $oShop->oxshops__oxordersubject->getRawValue()." (#".$oOrder->oxorder__oxordernr->value.")";
            }
        }

        $this->setSubject( $sSubject );
		
		if ( $oUser->oxuser__oxfname->value )
		{

			$sFullName = $oUser->oxuser__oxfname->getRawValue() . " " . $oUser->oxuser__oxlname->getRawValue();
		} elseif ( $oUser->oxuser__oxlname->value )
		{
			$sFullName = $oUser->oxuser__oxlname->getRawValue();
		} else {
			$sFullName = '';
		}

        $this->setRecipient( $oUser->oxuser__oxusername->value, $sFullName );
        $this->setReplyTo( $oShop->oxshops__oxorderemail->value, $oShop->oxshops__oxname->getRawValue() );

        $blSuccess = $this->send();

        return $blSuccess;
    }
    
    /*
     * Set body depending of users wish for reviewmode
     */
    public function setMarmBody()
    {
        
        $oSmarty = $this->_getSmarty();
        
        $sReviewMode = $this->getReviewMode();
        
        if($sReviewMode == 'shop')
        {
            
            // Set the html template for mail
            if ( $oSmarty->template_exists( $this->_sReviewTemplateShop) ) {
                $this->setBody( $oSmarty->fetch( $this->_sReviewTemplateShop ) );
            } else {
                die('No template for email found. Must be '.$this->_sReviewTemplateShop);
            }
            
            // Set the plain template for mail
            if ( $oSmarty->template_exists( $this->_sReviewTemplatePlainShop) ) {
                $this->setAltBody( $oSmarty->fetch( $this->_sReviewTemplatePlainShop ) );
            } else {
                die('No template for email found. Must be '.$this->_sReviewTemplatePlainShop);
            }
            
        }else {
        
            // Set the html template for mail
            if ( $oSmarty->template_exists( $this->_sReviewTemplateTS) ) {
                $this->setBody( $oSmarty->fetch( $this->_sReviewTemplateTS ) );
            } else {
                die('No template for email found. Must be '.$this->_sReviewTemplateTS);
            }
            
            // Set the plain template for mail
            if ( $oSmarty->template_exists( $this->_sReviewTemplatePlainTS) ) {
                $this->setAltBody( $oSmarty->fetch( $this->_sReviewTemplatePlainTS ) );
            } else {
                die('No template for email found. Must be '.$this->_sReviewTemplatePlainTS);
            }
        }
    }
    
    
    /*
     * How should mails be sent out?
     * For Reviews in Shop, for TrustedShops or random
     */    
    public function getReviewMode()
    {
        $oConf = oxRegistry::getConfig();
            
        $sShopId = $oConf->getShopId();
        
        $sReviewMode = $oConf->getShopConfVar('sMode', $sShopId, 'module:marm/laterreview');
        
        
        if($sReviewMode == 'random')
        {
            if(rand(0,1) == 0)
            {
                $sReviewMode = 'trustedshop';
            }else{
                $sReviewMode = 'shop';
            }
        }
        
        return $sReviewMode;
    }
    
    public function getTempTsUrl($buyerEmail,$shopOrderID)
    {
        $oConf = oxRegistry::getConfig();
            
        $sShopId = $oConf->getShopId();
        
        $sTrustedShopId = $oConf->getShopConfVar('sTrustedShopId', $sShopId, 'module:marm/laterreview');
        
        return 'https://www.trustedshops.de/bewertung/bewerten_' . $sTrustedShopId . '.html&buyerEmail='.urlencode(base64_encode($buyerEmail)).'&shopOrderID='.urlencode(base64_encode($shopOrderID));
    }
    
}