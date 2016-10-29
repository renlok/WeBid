

<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_239}</li>
			<li>/</li>
            <li class="current">{PAGE_TITLE}</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End -->

    	<!-- Right Side/Main Content Start -->
    <div id="rightside">
<!-- IF WARNINGREPORT -->
            <!-- Green Status Bar Start -->
        <div class="status error">
        	<p><img src="{SITEURL}themes/{THEME}/img/icons/icon_error.png"  alt="Error" /><span>Error!</span> {WARNINGMESSAGE}</p>
        </div>
        <!-- Green Status Bar End -->
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
        <!-- Blue Status Bar Start -->
        <div class="status info">
        	<p><img src="{SITEURL}themes/{THEME}/img/icons/icon_info.png" alt="Information" /><span>Information:</span>  {ERROR}</p>
        </div>
        <!-- Blue Status Bar End -->
<!-- ENDIF -->

        <!-- Content Box Start -->
        <div class="contentcontainer">
            <div class="contentbox">
      <div class="plain-box">{NUM_AUCTIONS} {L_311}<!-- IF B_SEARCHUSER --> {L_934}{USERNAME}<!-- ENDIF --></div>
                <table width="98%" cellpadding="0" cellspacing="0"  border="0">
                <tr>
                    <th align="center"><b>{L_1404}</b></th>
                    <th align="center"><b>{L_557}</b></th>
                    <th align="center"><b>{L_1402}</b></th>
                    <th align="center"><b>{L_1403}</b></th>
                    <th align="left"><b>{L_297}</b></th>
                <tr>
                <!-- BEGIN auctions -->
                <tr<!-- IF auctions.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF --> style="min-height:130px;"> 
                    <td width="23%" valign="top">

					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
					<td valign="top" >
                        <!-- IF auctions.SUSPENDED eq 1 -->
                        <b>{L_624}:<br></b>&nbsp;<span style="color:#FF0000"><b>{auctions.TITLE}</b></span><br />{L_113}:&nbsp;{auctions.ID}
                        <!-- ELSE -->
                         <b>{L_624}:<br></b>&nbsp;{auctions.TITLE}<br>
                         <b>{L_113}:</b>&nbsp;{auctions.ID}<br>
                        <!-- ENDIF -->
                        <p><b>[ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</b></p>
                    </td>
                    <td width="140" height="120" ><br>{auctions.AUCTIONPIC}
                    </td>
					</tr>
					</table>

					</td>
                    <td width="15% " valign="top">
                        <b>{L_1415}</b> {auctions.SELLERNAME}<br>
                        <b>{L_1414}</b> {auctions.SELLERID}<br>
                       <p><span style="color:#008000"><b>[ <a class="greenlink" href="{auctions.CONTSELLER}{PAGE}">{L_1425}</a> ]</b></span></p>

                    </td>
                    <td width="18%" valign="top">
                      <b>{L_1416}</b> {auctions.REPORTERNAME}<br>
                        <b>{L_1420}</b> {auctions.REPORTERID}<br>
                        <b>{L_1423}</b> {auctions.REPORTDATE}<br>
                        <p><b><span style="color:#008000">[ <a class="greenlink" href="{auctions.CONTREPORTER}{PAGE}">{L_1426}</a> ]</span></b></p>
                    </td>
                    <td width="30%" valign="top" >
					<b>Report ID: </b> {auctions.REPORTID}<br>
                    <b>{L_1421}</b> {auctions.REPORTREASON}<br>
                        <b>{L_1422}</b> {auctions.REPORTCOMMENT}<br>

                    </td>
                    <td align="left" width="14%" >
                        <a href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a><br><br>
                        <a href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a><br>
                        <a href="excludeauction.php?id={auctions.ID}&offset={PAGE}"> <br>
                    <!-- IF auctions.SUSPENDED eq 0 -->
                        {L_300} <br>
                    <!-- ELSE -->
                        {L_310} <br>
                    <!-- ENDIF -->
                        </a><br>
                    <a href="closereportedauctions.php?id={auctions.ID}&offset={PAGE}&reportid={auctions.REPORTID}">{L_1424}</a><br>
                    </td>
                </tr>
                <!-- END auctions -->
                </table>
                <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td align="center">
                            {L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                            <br>
                            {PREV}
<!-- BEGIN pages -->
                            {pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
                            {NEXT}
                        </td>
                    </tr>
				</table>

            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
