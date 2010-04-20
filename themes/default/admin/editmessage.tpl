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
                <td class="white">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5276}</td>
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
            <td align="center" class="title">{L_5278}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
            	<form name="addnew" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="3" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
                    <tr>
                        <td colspan="2" align="center"><a href="editmessages.php?id={BOARD_ID}">{L_5279}</a></td>
                    </tr>
                    <tr>
                        <td width="24%" valign="top">{L_5059}</td>
                        <td>
                            <textarea rows="8" cols="40" name="message">{MESSAGE}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_5060}</td>
                        <td>{USER} - {POSTED}</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="{BOARD_ID}">
                            <input type="hidden" name="msg" value="{MSG_ID}">
                        </td>
                        <td>
                            <input type="submit" name="Submit" value="{L_530}">
                        </td>
                    </tr>
                </table>
                </form>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr align="center">
	<td bgcolor="#EEEEEE"><a href="boards.php">{L_5032}</a></td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->