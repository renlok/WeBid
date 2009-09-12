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
                <td width="30"><img src="{SITEURL}admin/images/i_set.gif" width="21" height="19"></td>
                <td class="white">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_132}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr> 
    <td align="center" valign="middle">
        <form name="conf" action="" method="post">
        <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title">{L_078}</td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellpadding="2" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
                <tr bgcolor="yellow">
                    <td class="error" colspan="2" align="center">{ERROR}</td>
                </tr>
<!-- ENDIF -->
                <tr>
                    <td colspan="2">
                        <p>{L_161}</p>
<!-- BEGIN langs -->
                        <a href="categoriestrans.php?lang={langs.LANG}"><img align="middle" src="{SITEURL}includes/flags/{langs.LANG}.gif" border="0"></a>
<!-- END langs -->
                    </td>
                </tr>
                <tr bgcolor="#EEEEEE">
                    <td><b>Default Name</b></td>
                    <td><b>Translation</b></td>
                </tr>
<!-- BEGIN cats -->
                <tr valign="top" style="background-color: {cats.ROW_COLOUR};">
                    <td><input type="text" name="categories_o[]" value="{cats.CAT_NAME}" size="45" disabled></td>
                    <td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.TRAN_CAT}" size="45"></td>
                </tr>
<!-- END cats -->
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><input type="submit" name="act" value="{L_089}"></td>
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