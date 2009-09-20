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
                <td width="30"><img src="{SITEURL}admin/images/i_auc.gif" ></td>
                <td class="white">{L_239}&nbsp;&gt;&gt;&nbsp;{L_325}</td>
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
            <td align="center" class="title">{L_325}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <table width="100%" cellpadding="2" border="0">
                <tr>
                    <td width="20%">{L_312}</td>
                    <td>{TITLE}</td>
                </tr>
                <tr>
                    <td>{L_313}</td>
                    <td>{NICK}</td>
                </tr>
                <tr>
                    <td>{L_314}</td>
                    <td>{STARTS}</td>
                </tr>
                <tr>
                    <td>{L_315}</td>
                    <td>{DURATION}</td>
                </tr>
                <tr>
                    <td>{L_316}</td>
                    <td>{CATEGORY}</td>
                </tr>
                <tr>
                    <td>{L_317}</td>
                    <td>{DESCRIPTION}</td>
                </tr>
                <tr>
                    <td>{L_318}</td>
                    <td>{CURRENT_BID}</td>
                </tr>
                <tr>
                    <td>{L_319}</td>
                    <td>{QTY}</td>
                </tr>
                <tr>
                    <td>{L_320}</td>
                    <td>{RESERVE_PRICE}</td>
                </tr>
                <tr>
                    <td>{L_300}</td>
                    <td>
<!-- IF SUSPENDED eq 0 -->
                        {L_029}
<!-- ELSE -->
                        {L_030}
<!-- ENDIF -->
                    </td>
                </tr>
                <tr>
                    <td colspan="2">{L_326}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form name="details" action="" method="post">
                            <input type="hidden" name="id" value="{ID}">
                            <input type="hidden" name="offset" value="{OFFSET}">
                            <input type="hidden" name="action" value="update">
                            <input type="submit" name="act" value="{L_008}">
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