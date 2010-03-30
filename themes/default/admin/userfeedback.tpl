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
                <td width="30"><img src="{SITEURL}admin/images/i_use.gif" ></td>
                <td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}</td>
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
            <td align="center" class="title">{L_222}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <table width="100%" cellpadding="2" border="0">
                <tr>
                    <td align="right" colspan="2"><b>{NICK} ({FB_NUM}) {FB_IMG}</b></td>
                </tr>
<!-- BEGIN feedback -->
				<tr bgcolor="{feedback.BGCOLOUR}">
                	<td valign="top">
                    	<img align="middle" src="{SITEURL}images/{feedback.FB_TYPE}.gif">&nbsp;&nbsp;<b>{feedback.FB_FROM}</b>&nbsp;&nbsp;<span class="small">({L_506}{feedback.FB_TIME})</span>
                        <p>{feedback.FB_MSG}</p>
                    </td>
                    <td align="right">
                    	<a href="edituserfeed.php?id={feedback.FB_ID}">{L_298}</a> | <a href="deleteuserfeed.php?id={feedback.FB_ID}&user={ID}">{L_008}</a>
                    </td>
                </tr>
<!-- END feedback -->
                </table>
<!-- IF B_MULPAG -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center">
                            {L_5117} {PAGE} {L_5118} {PAGES}
                            <br>
    <!-- IF B_NOTLAST -->
                            <a href="userfeedback.php?PAGE={PREV}&id={ID}&offset={OFFSET}"><u>{L_5119}</u></a>&nbsp;&nbsp;
    <!-- ENDIF -->
                            {PAGENA}
                            &nbsp;&nbsp;
    <!-- IF B_NOTLAST -->
                            <a href="userfeedback.php?PAGE={NEXT}&id={ID}&offset={OFFSET}"><u>{L_5120}</u></a>
    <!-- ENDIF -->
                        </td>
                    </tr>
                </table>
<!-- ENDIF -->
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->