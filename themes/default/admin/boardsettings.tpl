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
                <td width="30"><img src="{SITEURL}admin/images/i_con.gif" ></td>
                <td class="white">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5047}</td>
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
            <td align="center" class="title">{L_5047}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <form name="conf" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="3" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
                    <tr>
                        <td width="195">{L_5048}</td>
                        <td width="437">
                            <input type="radio" name="boards" value="y"{BOARDS_YES}> {L_030}
                            <input type="radio" name="boards" value="n"{BOARDS_NO}> {L_029}
                        </td>
                    </tr>
                    <tr>
                        <td>{L_5049}</td>
                        <td>
                            <input type="radio" name="boardslink" value="y"{BOARDS_LINK_YES}> {L_030}
                            <input type="radio" name="boardslink" value="n"{BOARDS_LINK_NO}> {L_029}
                            <p>{L_5050}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><input type="hidden" name="action" value="update"></td>
                        <td><input type="submit" name="act" value="{L_530}"></td>
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