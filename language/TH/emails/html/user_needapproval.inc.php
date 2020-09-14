<table border="0" width="100%">
	<tr>
		<td colspan="2" height="35"><div style="font-size: 14px; font-weight: bold;">Thank you for registering at {SITENAME}!</div></td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 12px;">Hello <b>{C_NAME}</b>,</td>
	</tr>
	<tr>
		<td colspan="2" height="50" style="font-size: 12px; padding-right: 6px;">
		In order to begin selling and/or buying at {SITENAME}, your account must be
		accepted by our site's administrator which is currently under review. <br /><br />
		You will receive an e-mail shortly when your account is active.<br>
		</td>
	</tr>
	<tr>
		<td width="55%" rowspan="2">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" style="font-size: 12px; padding-bottom: 7px; padding-top: 5px;"><b>Your information is below:</b></td>

			</tr>
			<tr>
				<td width="17%" style="font-size: 12px;">Full name:</td>
				<td align="left" style="font-size: 12px;">{C_NAME}</td>
			</tr>
			<tr>
				<td width="17%" style="font-size: 12px;">Username:</td>
				<td align="left" style="font-size: 12px;">{C_NICK}</td>
			</tr>
<!-- IF C_ADDRESS ne '' -->
			<tr>
				<td width="17%" style="font-size: 12px;">Address:</td>
				<td align="left" style="font-size: 12px;">{C_ADDRESS}</td>
			</tr>
<!-- ENDIF -->
<!-- IF C_CITY ne '' -->
			<tr>
				<td width="17%" style="font-size: 12px;">City:</td>
				<td align="left" style="font-size: 12px;">{C_CITY}</td>
			</tr>
<!-- ENDIF -->
<!-- IF C_PROV ne '' -->
			<tr>
				<td width="17%" style="font-size: 12px;">State:</td>
				<td align="left" style="font-size: 12px;">{C_PROV}</td>
			</tr>
<!-- ENDIF -->
<!-- IF C_COUNTRY ne '' -->
			<tr>
				<td width="17%" style="font-size: 12px;">Country:</td>
				<td align="left" style="font-size: 12px;">{C_COUNTRY}</td>
			</tr>
<!-- ENDIF -->
<!-- IF C_ZIP ne '' -->
			<tr>
				<td width="17%" style="font-size: 12px;">Zip:</td>
				<td align="left" style="font-size: 12px;">{C_ZIP}</td>
			</tr>
<!-- ENDIF -->
			<tr>
				<td width="17%" style="font-size: 12px;">Email:</td>
				<td align="left" style="font-size: 12px;">{C_EMAIL}</td>
			</tr>
			<tr>
				<td width="17%" style="font-size: 12px;"></td>
				<td align="left" style="font-size: 12px;">&nbsp;</td>
			</tr>
		</table>
		</td>
		<td width="34%" style="font-size: 12px;">&nbsp;</td>
	</tr>
	<tr>
		<td width="34%" height="176" valign="top">&nbsp;
		</td>
	</tr>
</table>