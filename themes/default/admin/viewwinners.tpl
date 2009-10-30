<html>
<head>
    <link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
    <td background="{SITEURL}admin/images/bac_barint.gif">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr> 
                <td width="30"><img src="{SITEURL}admin/images/i_auc.gif"></td>
                <td class="white">{L_239}&nbsp;&gt;&gt;&nbsp;{L_30_0176}</td>
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
            <td align="center" class="title">{L_30_0176}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <table width="100%" cellpadding="2" border="0">
                <tr>
                    <td><b>{L_113}: </b> {ID}</td>
                </tr>
                <tr>
                    <td><b>{L_197}: </b> {TITLE}</td>
                </tr>
                <tr>
                    <td><b>{L_125}: </b> {S_NICK} ({S_NAME})</td>
                </tr>
                <tr>
                    <td><b>{L_127}: </b> {MIN_BID}</td>
                </tr>
                <tr>
                    <td><b>{L_111}: </b> {STARTS}</td>
                </tr>
                <tr>
                    <td><b>{L_30_0177}: </b> {ENDS}</td>
                </tr>
                <tr>
                    <td><b>{L_257}: </b> {AUCTION_TYPE}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFCC00">
                    <td><b>{L_453}</b></td>
                </tr>
                <tr>
                    <td>
<!-- IF B_WINNERS -->
                        <table width="65%" align="center" cellpadding="4" cellspacing="1" border="0">
                        <tr bgcolor="#DDDDDD">
                            <td><b>{L_176}</b></td>
                            <td><b>{L_30_0179}</b></td>
                            <td><b>{L_284}</b></td>
                        </tr>
    <!-- BEGIN winners -->
                        <tr>
                            <td>{winners.W_NICK} ({winners.W_NAME})</td>
                            <td>{winners.BID}</td>
                            <td align="center">{winners.QTY}</td>
                        </tr>
    <!-- END winners -->
                        </table>
<!-- ELSE -->
                        {L_30_0178}
<!-- ENDIF -->
                    </td>
                </tr>
                <tr bgcolor="#FFCC00">
                    <td><b>{L_30_0180}</b></td>
                </tr>
                <tr>
                    <td>
<!-- IF B_BIDS -->
                        <table width="65%" align="center" cellpadding="4" cellspacing="1" border="0">
                        <tr bgcolor="#DDDDDD">
                            <td><b>{L_176}</b></td>
                            <td><b>{L_30_0179}</b></td>
                            <td><b>{L_284}</b></td>
                        </tr>
    <!-- BEGIN bids -->
                        <tr>
                            <td>{bids.W_NICK} ({bids.W_NAME})</td>
                            <td>{bids.BID}</td>
                            <td align="center">{bids.QTY}</td>
                        </tr>
    <!-- END bids -->
                        </table>
<!-- ELSE -->
                        {L_30_0178}
<!-- ENDIF -->
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->