<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
  <title>[{$subject}]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=[{$charset}]">
  </head>
  <body bgcolor="#FFFFFF" link="#355222" alink="#355222" vlink="#355222" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;">
  <img src="[{$shop->imagedir}]logo_white.gif" border="0" hspace="0" vspace="0" alt="[{ $shop->oxshops__oxname->value }]" align="texttop"><br><br>

    <br>
    [{ oxmultilang ident="MARM_LATERREVIEW_START" }]
     <a href="[{ $oViewConf->getTsRatingUrl() }]" title="[{ oxmultilang ident="MARM_LATERREVIEW_TS_YOU" }]">[{$shop->imagedir}]marm_laterreview_ts_de.jpg</a>

    <br><br>
    [{ oxmultilang ident="EMAIL_SENDEDNOW_HTML_YUORTEAM1" }] [{ $shop->oxshops__oxname->value }] [{ oxmultilang ident="EMAIL_SENDEDNOW_HTML_YUORTEAM2" }]<br>
    <br><br>
    [{ oxcontent ident="oxemailfooter" }]
    
  </body>
</html>
