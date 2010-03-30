<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td background="images/bac_barint.gif">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr>
                <td width="30"><img src="images/i_auc.gif"></td>
                <td class="white">{L_239}&nbsp;&gt;&gt;&nbsp;{PAGE_TITLE}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td align="center" valign="middle">
        <table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title">{PAGE_TITLE}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <table width="100%" cellspacing="0" border="0" align="center">
                <tr>
                    <td colspan="3"><b>{NUM_AUCTIONS} {L_311}<!-- IF B_SEARCHUSER --> {L_934}{USERNAME}<!-- ENDIF --></b></td>
                </tr>
                <tr bgcolor="#FFCC00">
                    <td align="center"><b>{L_017}</b></td>
                    <td align="center"><b>{L_557}</b></td>
                    <td align="left"><b>{L_297}</b></td>
                <tr>
                <!-- BEGIN auctions -->
                <tr style="background-color:{auctions.BGCOLOUR};">
                    <td>
                        <!-- IF auctions.SUSPENDED eq 1 -->
                        <span style="color:#FF0000">{auctions.TITLE}</span>
                        <!-- ELSE -->
                        {auctions.TITLE}
                        <!-- ENDIF -->
                        <p>[ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</p>
                    </td>
                    <td>
                        <b>{L_003}:</b> {auctions.USERNAME}<br>
                        <b>{L_625}:</b> {auctions.START_TIME}<br>
                        <b>{L_626}:</b> {auctions.END_TIME}<br>
                        <b>{L_041}:</b> {auctions.CATEGORY}
                    </td>
                    <td align="left">
                        <a href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a><br>
                        <a href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a><br>
                        <a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">
                    <!-- IF auctions.SUSPENDED eq 0 -->
                        {L_300}
                    <!-- ELSE -->
                        {L_310}
                    <!-- ENDIF -->
                    	</a>
                    <!-- IF auctions.B_HASWINNERS -->
                        <br><a href="viewwinners.php?id={auctions.ID}&offset={PAGE}">{L__0163}</a>
                    <!-- ENDIF -->
                    </td>
                </tr>
                <!-- END auctions -->
                </table>
            </td>
        </tr>
        </table>
        <div class="navigation">{PAGNATION}</div>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->