[{ oxcontent ident="marm_laterreview_header_plain" }]

    [{foreach from=$articels item=oProduct}]
        [{ $oProduct->oxorderarticles__oxtitle->value }] [{ $oProduct->oxorderarticles__oxselvariant->value }]([{ oxmultilang ident="EMAIL_SENDEDNOW_HTML_ARTNOMBER" }] [{ $oProduct->oxorderarticles__oxartnum->value }]): [{ $oViewConf->getBaseDir() }]index.php?shp=[{$shop->oxshops__oxid->value}]&amp;anid=[{$oProduct->oxorderarticles__oxartid->value}]&amp;cl=review&amp;reviewuserhash=[{$user->getReviewUserHash($user->getId())}]
    [{/foreach}]

[{ oxcontent ident="oxemailfooterplain" }]