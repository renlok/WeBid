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
                <td width="30"><img src="images/i_use.gif"></td>
                <td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_2_0017}</td>
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
            <td align="center" class="title">{L_2_0020}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <form name="banform" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
                    <tr>
                        <td bgcolor="#FFFF66" colspan="5">
                            {L_2_0021}
                            <input type="text" name="ip">
                            <input type="submit" name="Submit2" value="&gt;&gt;">
                            {L_2_0024}
                        </td>
					</tr>
                    <tr bgcolor="#FFCC00">
                        <td width="29%"><b>{L_087}</b></td>
                        <td width="25%"><b>{L_2_0009}</b></td>
                        <td width="19%"><b>{L_560}</b></td>
                        <td width="18%"><b>{L_5028}</b></td>
                        <td width="9%"><b>{L_008}</b></td>
                    </tr>
<!-- BEGIN ips -->
                    <tr>
                        <td width="29%">{L_2_0025}</td>
                        <td width="25%" align="center">{ips.IP}</td>
                        <td width="19%" align="center"> 
    <!-- IF ips.ACTION eq 'accept' -->
                            {L_2_0012}
    <!-- ELSE -->
                            {L_2_0013}
    <!-- ENDIF -->
                        </td>
                        <td width="18%"> 
    <!-- IF ips.ACTION eq 'accept' -->
                            <input type="checkbox" name="deny[]" value="{ips.ID}">
                            &nbsp;{L_2_0006}
    <!-- ELSE -->
                            <input type="checkbox" name="accept[]" value="{ips.ID}">
                            &nbsp;{L_2_0007}
    <!-- ENDIF -->
                        </td>
                        <td width="9%" align="center"><input type="checkbox" name="delete[]" value="{ips.ID}"></td>
<!-- END ips -->
                    </tr>
                </table>
                <p>&nbsp;</p>
                <div align="center">
                    <input type="submit" name="Submit" value="{L_2_0015}">
                    <input type="hidden" name="action" value="update">
                </div>
            </td>
        </tr>
        </table>
        </form>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->