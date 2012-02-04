[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign }]

<script type="text/javascript">
<!--

[{ if $updatelist == 1}]
    UpdateList('[{ $oxid }]');
[{ /if}]

function UpdateList( sID)
{
    var oSearch = parent.list.document.getElementById("search");
    oSearch.oxid.value=sID;
    oSearch.submit();
}

function _groupExp(el) {
    var _cur = el.parentNode;

    if (_cur.className == "exp") _cur.className = "";
      else _cur.className = "exp";
}

//-->
</script>

[{ if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

[{cycle assign="_clear_" values=",2" }]


<form name="transfer" id="transfer" action="[{ $shop->selflink }]" method="post">
    [{ $shop->hiddensid }]
    <input type="hidden" name="oxid" value="[{ $shopid }]" />
    <input type="hidden" name="cl" value="eulanda" />
    <input type="hidden" name="actshop" value="[{ $shopid }]" />
    <input type="hidden" name="editlanguage" value="[{ $editlanguage }]" />
</form>

<form name="myedit" id="myedit" action="[{ $shop->selflink }]" method="post">
[{ $shop->hiddensid }]
<input type="hidden" name="cl" value="marm_laterreview_config" />
<input type="hidden" name="fnc" value="save" />
<input type="hidden" name="oxid" value="[{$shopid}]" />

  [{if $result }] <div class="errorbox"><p>[{ $result}] Dateien entfernt</p></div>[{/if}]
   
   <div class="groupExp">
        <div class="exp"> 
            <a href="#" onclick="_groupExp(this);return false;" class="rc"><b>[{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_OPTION }]</b></a>
             <dl>
                <dt>
                   <input type="hidden" name="confbools[marmLaterreviewDebug]" value="false" />
                    <input type="checkbox" name="confbools[marmLaterreviewDebug]" value="true"  [{if ($confbools.marmLaterreviewDebug)}]checked[{/if}] [{ $readonly}]>
                </dt>
                <dd>
                    [{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_DEBUG }]
                </dd>
                <div class="spacer"></div>
            </dl>
            <dl>
                <dt>
                   <input size="10" type="text" name="confstrs[marmLaterreviewCount]" value="[{ $confstrs.marmLaterreviewCount }]" />
                </dt>
                <dd>
                   [{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_COUNT }]
                </dd>
                <div class="spacer"></div>
            </dl>
			 <dl>
                <dt>
                   <input size="10" type="text" name="confstrs[marmLaterreviewLastorder]" value="[{ $confstrs.marmLaterreviewLastorder }]" />
                </dt>
                <dd>
                    [{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_LASTORDER }]
                </dd>
                <div class="spacer"></div>
            </dl>
            
            <dl>
                <dt>
                   <input size="10" type="text" name="confstrs[marmLaterreviewDelay]" value="[{ $confstrs.marmLaterreviewDelay }]" />
                </dt>
                <dd>
                   [{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_DELAY }] 
                </dd>
                <div class="spacer"></div>
            </dl>           
            
            <dl>
                <dt>
                   [{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_TOKEN }]<br />
				   <input size="100" type="text" name="confstrs[marmLaterreviewHidden]" value="[{ $confstrs.marmLaterreviewHidden }]" />
                </dt>
                <dd>
                    
                </dd>
                <div class="spacer"></div>
            </dl>
            
            <dl>
                <dt>
                   [{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_URL }]: <a target="_blank" href="[{$oViewConf->getBaseDir()}]modules/marm/laterreview/marm_laterreview_do.php?token=[{ $confstrs.marmLaterreviewHidden }]">[{$oViewConf->getBaseDir()}]modules/marm/laterreview/marm_laterreview_do.php?token=[{ $confstrs.marmLaterreviewHidden }]</a>
                </dt>
                <dd>
                    
                </dd>
                <div class="spacer"></div>
            </dl>
            
            <dl>
            	<dt>
            		[{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_MOD }]
            		<select name="confstrs[marmLaterreviewMod]" >
            			<option value="product" [{if ($confstrs.marmLaterreviewMod == "product")}]selected[{/if}] >[{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_MOD_PRODUCT }]</option>
            			<option value="trustedshop" [{if ($confstrs.marmLaterreviewMod == "trustedshop")}]selected[{/if}] >[{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_MOD_TRUSTEDSHOP }]</option>
            			<option value="random"  [{if ($confstrs.marmLaterreviewMod == "random")}]selected[{/if}] >[{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_MOD_RANDOM }]</option>
            		</select>
            	</dt>
            	<dd>
            	
            	</dd>
            	<div class="spacer"></div>
            </dl>
            <dl>
                <dt></dt>
                <dd><input type="submit" value="[{ oxmultilang ident=MARM_LATERREVIEW_CONFIG_SAVE }]"  /></dd>
                <div class="spacer"></div>
            </dl>
         </div>
    </div>
    
</form>
[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
