<table border="0" width="100%">
	<tr>
		<td colspan="3" height="35"><div style="font-size: 14px; font-weight: bold;">Congratulations, some items have been sold!</div></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 12px;">Hello <b>{S_NAME}</b>,</td>
	</tr>
	<tr>
		<td colspan="3" height="50" style="font-size: 12px; padding-right: 6px;"><i>Congratulations</i> some items have been sold
		Below are the details.</td>
	</tr>
	<tr>
		<td width="9%" rowspan="2"><img border="0" src="{SITE_URL}{A_PICURL}"></td>
		<td width="55%" rowspan="2">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" style="font-size: 12px;"><a href="{A_URL}">{A_TITLE}</a></td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Sale price:</td>
				<td align="left" style="font-size: 12px;">{A_CURRENTBID}</td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Quantity:</td>
				<td align="left" style="font-size: 12px;">{A_QTY_THIS_SALE}</td>
			</tr>
			<tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Quantity left for sale:</td>
				<td align="left" style="font-size: 12px;">{A_QTY_LEFT}</td>
			</tr>
			<tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Total quantity sold so far:</td>
				<td align="left" style="font-size: 12px;">{A_QTY_SOLD}</td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">End date:</td>
				<td align="left" style="font-size: 12px;">{A_ENDS}</td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Auction URL:</td>
				<td align="left" style="font-size: 12px;"><a href="{A_URL}">{A_URL}</a></td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;"></td>
				<td align="left" style="font-size: 12px;"><a href="{SITE_URL}user_menu.php?">Goto My {SITENAME}</a></td>
			</tr>
		</table>
		</td>
		<td width="34%" style="font-size: 12px;">Check Payment Details</td>
	</tr>
	<tr>
		<td width="34%" height="90" valign="top">
		<a href="{SITE_URL}buying.php">
		<img border="0" src="{SITE_URL}images/email_alerts/Total_Due_Btn.jpg" width="120" height="32"></a></td>
	</tr>
</table>
<br />
<table border="0" width="100%">
	<tr>
		<td style="font-size: 12px;"><b>Buyer's Information</b></td>
	</tr>
	<tr>
		<td style="font-size: 12px;">{B_REPORT}</td>
	</tr>
</table>
<br />
<div style="font-size: 12px;"><i>An email has been sent to the winner(s) with your email address.</i></div>