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
                <td width="30"><img src="{SITEURL}admin/images/i_use.gif"></td>
                <td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_25_0005}</td>
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
			<td align="center" class="title">{L_25_0005}</td>
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
                <tr valign="top">
                    <td width="25%">{L_781}</td>
                    <td width="75%">
                    	{L_030}<input type="radio" name="birthdate" value="y" <!-- IF REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="birthdate" value="n" <!-- IF ! REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="birthdate_regshow" value="y" <!-- IF DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="birthdate_regshow" value="n" <!-- IF ! DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td>{L_782}</td>
                    <td>
                    	{L_030}<input type="radio" name="address" value="y" <!-- IF REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="address" value="n" <!-- IF ! REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="address_regshow" value="y" <!-- IF DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="address_regshow" value="n" <!-- IF ! DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td>{L_783}</td>
                    <td>
                    	{L_030}<input type="radio" name="city" value="y" <!-- IF REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="city" value="n" <!-- IF ! REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="city_regshow" value="y" <!-- IF DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="city_regshow" value="n" <!-- IF ! DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td>{L_784}</td>
                    <td>
                    	{L_030}<input type="radio" name="prov" value="y" <!-- IF REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="prov" value="n" <!-- IF ! REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="prov_regshow" value="y" <!-- IF DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="prov_regshow" value="n" <!-- IF ! DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td>{L_785}</td>
                    <td>
                    	{L_030}<input type="radio" name="country" value="y" <!-- IF REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="country" value="n" <!-- IF ! REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="country_regshow" value="y" <!-- IF DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="country_regshow" value="n" <!-- IF ! DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td>{L_786}</td>
                    <td>
                    	{L_030}<input type="radio" name="zip" value="y" <!-- IF REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="zip" value="n" <!-- IF ! REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="zip_regshow" value="y" <!-- IF DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="zip_regshow" value="n" <!-- IF ! DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td>{L_787}</td>
                    <td>
                    	{L_030}<input type="radio" name="tel" value="y" <!-- IF REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="tel" value="n" <!-- IF ! REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
                <tr valign="top">
                    <td>{L_780}</td>
                    <td>
                    	{L_030}<input type="radio" name="tel_regshow" value="y" <!-- IF DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                        {L_029}<input type="radio" name="tel_regshow" value="n" <!-- IF ! DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                    </td>
                </tr>
				<tr valign="top">
					<td height="22">&nbsp;</td>
					<td height="22">&nbsp;</td>
				</tr>
                <tr>
                    <td><input type="hidden" name="action" value="update"></td>
                    <td><input type="submit" name="act" value="{L_530}"></td>
                </tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
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