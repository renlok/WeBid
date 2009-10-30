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
            <td align="center" class="title">{L_2_0004}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <form name="banform" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
                <tr>
                    <td colspan="3">{L_667} <b>{NICK}</b></td>
                    <td align="right">{L_559}: {LASTLOGIN}</td>
                </tr>
                <tr bgcolor="#FFCC00">
                    <td width="35%"><b>{L_087}</b></td>
                    <td width="27%"><b>{L_2_0009}</b></td>
                    <td width="21%"><b>{L_560}</b></td>
                    <td width="17%"><b>{L_5028}</b></td>
                </tr>
<!-- BEGIN ips -->
                <tr bgcolor="{users.BGCOLOUR}">
                    <td>
	<!-- IF ips.TYPE eq 'first' -->
    					{L_2_0005}
    <!-- ELSE -->
    					{L_221}
    <!-- ENDIF -->
                    </td>
                    <td align="center">{ips.IP}</td>
                    <td align="center">
	<!-- IF ips.ACTION eq 'accept' -->
    					{L_2_0012}
    <!-- ELSE -->
    					{L_2_0013}
    <!-- ENDIF -->
                    </td>
                    <td>
	<!-- IF ips.ACTION eq 'accept' -->
    					<input type="checkbox" name="deny[]" value="{ips.ID}">
						&nbsp;{L_2_0006}
    <!-- ELSE -->
    					<input type="checkbox" name="accept[]" value="{ips.ID}">
						&nbsp;{L_2_0007}
    <!-- ENDIF -->
                    </td>
                </tr>
<!-- END ips -->
				<tr>
                	<td colspan="4">
                        <p>
                            <input type="submit" name="Submit" value="{L_2_0015}">
                            <input type="hidden" NAME="action" VALUE="update">
                            <input type="hidden" NAME="id" VALUE="{ID}">
                        </p>
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