<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
<tr>
    <td align="center" class="title">{L_5068}</td>
</tr>
<tr>
    <td>
        <form name="conf" action="" method="post">
        <table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
        <tr valign="top">
            <td>
                {MESSAGE}
            </td>
        </tr>
        <tr valign="top">
            <td height="22">&nbsp;</td>
        </tr>      
        <tr>
            <td>
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="ignore" value="true">
                <input type="hidden" name="id" value="{ID}">
                <input type="hidden" name="offset" value="{OFFSET}">
                <input type="submit" name="act" value="{STRING}">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        </table>
        </form>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->