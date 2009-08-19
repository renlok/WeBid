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
                <td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="center" valign="middle">&nbsp;</td>
</tr>
<tr> 
    <td align="center" valign="middle">
        <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title"><b>{ACTION}</b></td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <table width="100%" celpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF">
                <tr>
                    <td width="204">{L_302}</td>
                    <td>{REALNAME}</td>
                </tr>
                <tr>
                    <td>{L_003}</td>
                    <td>{USERNAME}</td>
                </tr>
                <tr>
                    <td>{L_303}</td>
                    <td>{EMAIL}</td>
                </tr>
                <tr>
                    <td>{L_252}</td>
                    <td>{DOB}</td>
                </tr>
                <tr>
                    <td>{L_009}</td>
                    <td>{ADDRESS}</td>
                </tr>
                <tr>
                    <td>{L_011}</td>
                    <td>{PROV}</td>
                </tr>
                <tr>
                    <td>{L_012}</td>
                    <td>{ZIP}</td>
                </tr>
                <tr>
                    <td>{L_014}</td>
                    <td>{COUNTRY}</td>
                </tr>
                <tr>
                    <td>{L_013}</td>
                    <td>{PHONE}</td>
                </tr>
                <tr>
                    <td>{L_222}</td>
                    <td>
                        <img src="../images/estrella_{RATE}.gif">
                        <p><a href="userfeedback.php?id={ID}">{L_208}</a></p>
                    </td>
                </tr>
                <tr>
                    <td width="204">&nbsp;</td>
                    <td>{QUESTION}</td>
                </tr>
                <tr>
                    <td width="204">&nbsp;</td>
                    <td>
                        <form name="details" action="" method="post">
                            <input type="hidden" name="id" value="{ID}">
                            <input type="hidden" name="offset" value="{OFFSET}">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="idhidden" value="{ID}">
                            <input type="hidden" name="mode" value="{MODE}">
                            <input type="submit" name="act" value="{L_030}">
                        </form>
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