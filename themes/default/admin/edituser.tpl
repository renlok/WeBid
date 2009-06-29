<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
            <td align="center" class="title"><b>{L_511}</b></td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
            	<form name="details" action="" method="post">
                <table width="100%" celpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="3" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
                <tr>
                    <td width="204">{L_302} *</td>
                    <td><input type="text" name="name" size="40" maxlength="255" value="{REALNAME}"></td>
                    <td><b>{L_448}</b></td>
                </tr>
                <tr>
                    <td>{L_003}</td>
                    <td>{USERNAME}</td>
                    <td rowspan="15" width="33%" valign="top">
                    	{USERGROUPS}
                    </td>
                </tr>
                <tr bgcolor="#EEEEEE">
                    <td>&nbsp;</td>
                    <td>{L_243}</td>
                </tr>
                <tr bgcolor="#EEEEEE">
                    <td>{L_004} *</td>
                    <td><input type="text" name="password" size="20" maxlength="20"></td>
                </tr>
                <tr bgcolor="#EEEEEE">
                    <td>{L_004} *</td>
                    <td><input type="text" name="password" size="20" maxlength="20"></td>
                </tr>
                <tr>
                    <td>{L_303} *</td>
                    <td><input type="text" name="email" size="50" maxlength="50" value="{EMAIL}"></td>
                </tr>
                <tr>
                    <td>{L_252}{REQUIRED(0)}</td>
                    <td><input type="text" name="birthdate" size="10" maxlength="10" value="{DOB}"></td>
                </tr>
                <tr>
                    <td>{L_009}{REQUIRED(1)}</td>
                    <td><input type="text" name="address" size="40" maxlength="255" value="{ADDRESS}"></td>
                </tr>
                <tr>
                    <td>{L_010}{REQUIRED(2)}</td>
                    <td><input type="text" name="city" size="40" maxlength="255" value="{CITY}"></td>
                </tr>
                <tr>
                    <td>{L_011}{REQUIRED(3)}</td>
                    <td><input type="text" name="prov" size="40" maxlength="255" value="{PROV}"></td>
                </tr>
                <tr>
                    <td>{L_012}{REQUIRED(5)}</td>
                    <td><input type="text" name="zip" size="15" maxlength="15" value="{ZIP}"></td>
                </tr>
                <tr>
                    <td>{L_014}{REQUIRED(4)}</td>
                    <td>
                    	<select name="country">
                            <option value=""></option>
                            {COUNTRY_LIST}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>{L_013}{REQUIRED(6)}</td>
                    <td><input type="text" name="phone" size="40" maxlength="40" value="{PHONE}"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><a href="userfeedback.php?id={ID}">{L_208}</a></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="hidden" name="id" value="{ID}">
                        <input type="hidden" name="offset" value="{OFFSET}">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="idhidden" value="{ID}">
                        <input type="hidden" name="mode" value="{MODE}">
                        <input type="submit" name="act" value="{L_071}">
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