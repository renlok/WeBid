<!-- INCLUDE user_menu_header.tpl -->

<form name="details" action="" method="post">
<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
<table width="100%" border="0" cellpadding="4" align="center">
	<tr>
		<td align="right" width="30%">{L_002}</td>
		<td><i>{NAME}</i></td>
	</tr>
	<tr>
		<td align="right" valign="top">{L_003}</td>
		<td valign="top"><i>{NICK}</i></td>
	</tr>
	<tr>
		<th colspan="2" valign="top" align="center">{L_617}</th>
	</tr>
	<tr>
		<td valign="top" class="errfont" style="text-align:right !important;">{L_004}</td>
		<td align="left"><input type="password" name="TPL_password" size="20"> {L_050}</td>
	</tr>
	<tr>
		<td valign="top" class="errfont" style="text-align:right !important;">{L_005}</td>
		<td align="left">
			<input type="password" name="TPL_repeat_password" size="20">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_006}</td>
		<td>
			<input type="email" name="TPL_email" size="20" maxlength="50" value="{EMAIL}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_252}</td>
		<td>
			{DATEFORMAT} <input type="text" name="TPL_year" size="4" maxlength="4" value="{YEAR}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_009}</td>
		<td>
			<input type="text" name="TPL_address" size="40" maxlength="255" value="{ADDRESS}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_010}</td>
		<td>
			<input type="text" name="TPL_city" size="25" maxlength="25" value="{CITY}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_011}</td>
		<td>
			<input type="text" name="TPL_prov" size="20" maxlength="20" value="{PROV}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_014}</td>
		<td>
			<select name="TPL_country">
				{COUNTRYLIST}
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_012}</td>
		<td>
			<input type="text" name="TPL_zip" size="8" value="{ZIP}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_013}</td>
		<td>
			<input type="text" name="TPL_phone" size=40 maxlength=40 value="{PHONE}">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_346}</td>
		<td>
			{TIMEZONE}
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">{L_352}</td>
		<td>
			<input type="radio" name="TPL_emailtype" value="html" {EMAILTYPE1} />
			{L_902}
			<input type="radio" name="TPL_emailtype" value="text" {EMAILTYPE2} />
			{L_915}
		</td>
	</tr>
	<tr>
<!-- IF B_NEWLETTER -->
		<td align="right" height="2">{L_603}<td>
			<input type="radio" name="TPL_nletter" value="1" {NLETTER1} />
			{L_030}
			<input type="radio" name="TPL_nletter" value="2" {NLETTER2} />
			{L_029}<br><span class="smallspan"><i>{L_609}</i></span>
		</td>
	</tr>
<!-- ENDIF -->
</table>

<div class="padding">
	<h2>{L_719}</h2>
</div>

<table width="100%" border="0" cellpadding="4" align="center">
<!-- BEGIN gateways -->
	<tr>
		<td align="right" width="30%">{gateways.ADDRESS_NAME}{gateways.REQUIRED}</td>
		<td>
			<input type="hidden" name="{gateways.PLAIN_NAME}[id]" value="{gateways.GATEWAY_ID}">
			<input type="text" name="{gateways.PLAIN_NAME}[address]" size=40 value="{gateways.ADDRESS}">
		</td>
	</tr>
	<!-- IF gateways.B_PASSWORD -->
		<tr>
			<td align="right" width="30%">{gateways.PASSWORD_NAME}{gateways.REQUIRED}</td>
			<td>
				<input type="text" name="{gateways.PLAIN_NAME}[password]" size=40 value="{gateways.PASSWORD}">
			</td>
		</tr>
	<!-- ELSE -->
		<input type="hidden" name="{gateways.PLAIN_NAME}[password]" value="">
	<!-- ENDIF -->
<!-- END gateways -->
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2 align="center">
			<input type="submit" name="Input" value="{L_530}" class="button">
			<input type="reset" name="Input" class="button">
		</td>
	</tr>
</table>
<input type="hidden" name="action" value="update">
</form>
<!-- INCLUDE user_menu_footer.tpl -->
