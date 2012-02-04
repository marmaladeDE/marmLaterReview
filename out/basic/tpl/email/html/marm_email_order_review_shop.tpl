<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
  <title>[{$subject}]</title>
  <meta http-equiv="Content-Type" content="text/html; charset="utf-8">
  </head>
  <body bgcolor="#FFFFFF" link="#355222" alink="#355222" vlink="#355222" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;">
    <img src="[{$oViewConf->getImageUrl()}]logo_white.gif" border="0" hspace="0" vspace="0" alt="[{ $shop->oxshops__oxname->value }]" align="texttop"><br><br>
    <br>
    [{ oxmultilang ident="MARM_LATERREVIEW_START" }]
    <br><br>
    <table border="0" cellspacing="0" cellpadding="0">
    [{foreach from=$articels item=oProduct}]
      <tr>
        <td valign="top" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; padding-top: 10px;">
          <b>[{ $oProduct->oxorderarticles__oxtitle->value }] [{ $oProduct->oxorderarticles__oxselvariant->value }]</b>
          <br>[{ oxmultilang ident="MARM_LATERREVIEW_ARTNUM" }] [{ $oProduct->oxorderarticles__oxartnum->value }]
        </td>
        <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; padding-top: 10px;" valign="top" align="right">
          <a href="[{ $oViewConf->getBaseDir() }]index.php?shp=[{$shop->oxshops__oxid->value}]&amp;anid=[{$oProduct->oxorderarticles__oxartid->value}]&amp;cl=review&amp;reviewuserhash=[{$user->getReviewUserHash($user->getId())}]" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;" target="_blank">[{ oxmultilang ident="MARM_LATERREVIEW_REVIEW" }]</a>
        </td>
      </tr>
    [{/foreach}]
    </table>
    <br>
    <br>
    [{ oxcontent ident="oxemailfooter" }]
  </body>
</html>