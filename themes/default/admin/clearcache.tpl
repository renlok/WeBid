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
                <td width="30"><img src="{SITEURL}admin/images/i_gra.gif"></td>
                <td class="white">{L_25_0009}&nbsp;&gt;&gt;&nbsp;{L_30_0031}</td>
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
            <td align="center" class="title">{L_30_0031}</td>
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
                    <tr>
                        <td align="center">{L_30_0032}</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="hidden" name="action" value="update">
                            <input type="submit" name="submit" value="{L_30_0031}">
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