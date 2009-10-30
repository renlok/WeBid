<html>
<head>
    <link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
    <script type="text/javascript">
    function selectAll(formObj, isInverse)
    {
        for (var i=0;i < formObj.length;i++)
        {
            fldObj = formObj.elements[i];
            if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6) == 'delete')
            { 
                if (isInverse)
                    fldObj.checked = (fldObj.checked) ? false : true;
                else fldObj.checked = true; 
            }
        }
    }
    </script>
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
    <td background="{SITEURL}admin/images/bac_barint.gif">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr> 
                <td width="30"><img src="{SITEURL}admin/images/i_set.gif" width="21" height="19"></td>
                <td class="white">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_069}</td>
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
            <td align="center" class="title">{L_069}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
            	<form name="addnew" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="4" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
                    <tr>
                        <td width="50">&nbsp;</td>
                        <td colspan="3">{L_122}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td bgcolor="#EEEEEE"><b>{L_097}</b></td>
                        <td bgcolor="#EEEEEE"><b>{L_087}</b></td>
                        <td bgcolor="#EEEEEE"><b>{L_008}</b></td>
                    </tr>
<!-- BEGIN dur -->
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="text" name="new_days[{dur.ID}]" value="{dur.DAYS}" size="5"></td>
                        <td><input type="text" name="new_durations[{dur.ID}]" value="{dur.DESC}" size="25"></td>
                        <td align="center"><input type="checkbox" name="delete[{dur.ID}]" value="{dur.DAYS}"></td>
                    </tr>
<!-- END dur -->
                    <tr>
                        <td>{L_394}</td>
                        <td>{L_097} <input type="text" name="new_days[]" size="5" maxlength="5"></td>
                        <td><input type="text" name="new_durations[]" size="25"></td>
                        <td align="center"><a href="javascript: void(0)" onclick="selectAll(document.forms[0],1)">{L_30_0102}</a></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="hidden" name="action" value="update">
                            <input type="submit" name="act" value="{L_089}">
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