<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	<td width="22%" valign="top" class="columL">
    <div class="titTable1">
    	{L_276}
    </div>
    <div>
        <!-- BEGIN cat_list -->
           
                <span class="text-shadow minor-header fg-white"  width:100%;">
                <a class="catclass fg-white" style="margin-top:10px; background-color:{cat_list.COLOUR};" href="browse.php?id={cat_list.ID}">{cat_list.IMAGE}{cat_list.NAME} {cat_list.CATAUCNUM}</a>
                </span>
           
<!-- END cat_list -->
       
        <a href="{SITEURL}browse.php?id=0">{L_277}</a>
    </div>
</td>
<td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="maincolum">
    <tr>
  <tr>

   <!-- BEGIN featured -->
 <!-- IF B_FEATURED_ITEMS -->
        <td class="titTable4">{L_NAY_01}</td>
    </tr>
 <!-- ENDIF -->

        <td class="table2">
 <!-- IF B_FEATURED_ITEMS -->

            <div style="float:left;display:block;width:180px;margin:5px;background-color:#FFFEEE;border:#CCCCCC 1px solid;padding:5px;min-height:150px;">
                <div style="display:block;" align="center"><img src="{featured.IMAGE}"></div>
                <div style="display:block;" align="center"><a href="{SITEURL}item.php?id={featured.ID}">{featured.TITLE}</a><br>{featured.BID}</div>
            </div>
<!-- ENDIF -->

        <!-- END featured -->
        </td>
    </tr>  
    <!-- IF B_HOT_ITEMS -->
    <tr>
        <td class="titTable4">{L_279}</td>
    </tr>
    <tr>
        <td class="table2">
        <!-- BEGIN hotitems -->
            <div style="float:left;display:block;width:180px;margin:5px;background-color:#FFFEEE;border:#CCCCCC 1px solid;padding:5px;min-height:150px;">
                <div style="display:block;" align="center"><img src="{hotitems.IMAGE}"></div>
                <div style="display:block;" align="center"><a href="{SITEURL}item.php?id={hotitems.ID}">{hotitems.TITLE}</a><br>{hotitems.BID}</div>
            </div>
        <!-- END hotitems -->
        </td>
    </tr>
    <!-- ENDIF -->
    <!-- IF B_AUC_LAST -->
    <tr>
        <td class="titTable4">{L_278}</td>
    </tr>
    <tr>
        <td class="table2">
        <!-- BEGIN auc_last -->
            <p style="display:block;" {auc_last.BGCOLOUR}>{auc_last.DATE} <a href="{SITEURL}item.php?id={auc_last.ID}">{auc_last.TITLE}</a></p>
        <!-- END auc_last -->
        </td>
    </tr>
    <!-- ENDIF -->
    <!-- IF B_AUC_ENDSOON -->
    <tr>
        <td class="titTable4">{L_280}</td>
    </tr>
    <tr>
        <td class="table2">
        <!-- BEGIN end_soon -->
            <p style="display:block;" {end_soon.BGCOLOUR}>{end_soon.DATE} <a href="{SITEURL}item.php?id={end_soon.ID}">{end_soon.TITLE}</a></p>
        <!-- END end_soon -->
        </td>
    </tr>
    <!-- ENDIF -->
    </table>
</td>
<td width="20%" valign="top" class="columR">
<!-- IF B_MULT_LANGS -->
    <div class="titTable1 rounded-left">
    	{L_2__0001}
    </div>
    <div class="smallpadding">
        {FLAGS}
    </div>
<!-- ENDIF -->
<!-- IF B_LOGIN_BOX -->
	<!-- IF B_LOGGED_IN -->
    <div class="titTable1 rounded-left">
    	{L_200} {YOURUSERNAME}
    </div>
    <div class="smallpadding">
        <ul>
            <li><a href="{SITEURL}edit_data.php?">{L_244}</a></li>
            <li><a href="{SITEURL}user_menu.php">{L_622}</a></li>
            <li><a href="{SITEURL}logout.php">{L_245}</a></li>
        </ul>
    </div>
	<!-- ELSE -->
	<!-- ENDIF -->
<!-- ENDIF -->
<!-- IF B_HELPBOX -->
    <div class="titTable1 rounded-left">
    	{L_281}
    </div>
    <div class="smallpadding">
        <ul>
        <!-- BEGIN helpbox -->
            <li><a href="{SITEURL}viewhelp.php?cat={helpbox.ID}" alt="faqs"  class="new-window">{helpbox.TITLE}</a></li>
        <!-- END helpbox -->
        </ul>
    </div>
<!-- ENDIF -->
<!-- IF B_NEWS_BOX -->
<div class="titTable1 rounded-left">{L_282}</div>
<div class="smallpadding">
<ul>
<!-- BEGIN newsbox -->
<li>{newsbox.DATE} - <a href="viewnews.php?id={newsbox.ID}">{newsbox.TITLE}</a></li> 
<!-- END newsbox --> 
</ul>
<a href="{SITEURL}viewallnews.php">{L_341}</a>
</div>   
<!-- ENDIF -->
	</td>
</tr>
</table>
