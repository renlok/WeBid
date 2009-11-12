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
                <td width="30"><img src="{SITEURL}admin/images/i_con.gif"></td>
                <td class="white">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5230}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr> 
    <td align="center" valign="middle">
        <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title">{L_5283}</td>
        </tr>
		<tr>
			<td>
				<form name="conf" action="" method="post">
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td class="error" colspan="2" align="center">{ERROR}</td>
				</tr>
<!-- ENDIF -->
                <tr>
                    <td width="24%">{L_5284}</td>
                    <td width="76%" valign="top">
    <!-- BEGIN langs -->
                        <p>
                            <img src="{SITEURL}includes/flags/{langs.LANGUAGE}.gif">&nbsp;<input type="text" name="category[{langs.LANGUAGE}]" size="50" maxlength="150" value="{langs.TRANSLATION}">
                        </p>
    <!-- END langs -->
                    </td>
                </tr>
                <tr>
                    <td width="24%">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="{ID}">
                    </td>
                    <td width="76%">
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
</table>

<!-- INCLUDE footer.tpl -->