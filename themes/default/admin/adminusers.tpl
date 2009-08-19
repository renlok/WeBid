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
                <td width="30"><img src="images/i_use.gif" ></td>
                <td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_525}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="center" valign="middle">&nbsp;</td>
</tr>
<tr> 
    <td align="center" valign="middle">
		<table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title">{L_525}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <form name="conf" action="" method="post">
                <table width="100%" cellpadding="2" align="center">
                    <tr bgcolor="#EEEEEE">
                        <td colspan="5" align="center"><a href="newadminuser.php">{L_367}</a></td>
                    </tr>
                    <tr>
                        <th width="30%">{L_003}</th>
                        <th width="16%">{L_558}</th>
                        <th width="19%">{L_559}</th>
                        <th width="12%">{L_560}</th>
                        <th width="23%"><input type="submit" name="Submit" value="{L_561}"></th>
                    </tr>
<!-- BEGIN users -->
                    <tr bgcolor="#EEEEEE">
                        <td width="30%"><a href="editadminuser.php?id={users.ID}">{users.USERNAME}</a></td>
                        <td width="16%" align="center">{users.CREATED}</td>
                        <td width="19%" align="center">{users.LASTLOGIN}</td>
                        <td width="12%" align="center">{users.STATUS}</td>
                        <td width="23%" align="center"><input type="checkbox" name="delete[]" value="{users.ID}"></td>
                    </tr>
<!-- END users -->
                    <tr>
                        <td colspan="5"><input type="hidden" name="action" value="update"></td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
        </form>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->