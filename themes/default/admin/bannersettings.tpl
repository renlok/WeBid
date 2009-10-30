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
                <td width="30"><img src="{SITEURL}admin/images/i_ban.gif" ></td>
                <td class="white">{L_25_0011}&nbsp;&gt;&gt;&nbsp;{L__0013}</td>
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
            <td align="center" class="title">{L__0013}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <form name="conf" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="2" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
                    <tr valign="top">
                        <td colspan="2">{L__0014}</td>
                    </tr>
                    <tr valign="top" bgcolor="#dddddd">
                        <td width="73" height="22">
                            <input type="radio" name="sizetype" value="any"{BANNER_SIZE_ANY}>
                        </td>
                        <td height="22">{L__0015}</td>
                    </tr>
                    <tr valign="top" bgcolor="#eeeeee">
                        <td width="73" height="22">
                            <input type="radio" name="sizetype" value="fix"{BANNER_SIZE_FIX}>
                        </td>
                        <td height="22">{L__0016}</td>
                    </tr>
                    <tr valign="top" bgcolor="#eeeeee">
                        <td width="73" height="22">{L__0017}</td>
                        <td height="22">
                            <input type="text" name="width" value="{BANNER_WIDTH}"> {L_5224}
                        </td>
                    </tr>
                    <tr valign="top" bgcolor="#eeeeee">
                        <td width="73" height="22">{L__0018}</td>
                        <td height="22">
                            <input type="text" name="height" value="{BANNER_HEIGHT}"> {L_5224}
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="hidden" name="action" value="update">
                            <input type="submit" name="act" value="{L_530}">
                        </td>
                    </tr>
                </table>
                </form>
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->