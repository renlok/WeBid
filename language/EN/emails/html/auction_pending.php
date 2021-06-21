<table border="0" width="100%">
	<tr>
		<td colspan="3" height="35"><div style="font-size: 14px; font-weight: bold;">Your item has been listed on {SITENAME}!</div></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 12px;">Hello <b>{C_NAME}</b>,</td>
	</tr>
	<tr>
		<td colspan="3" height="50" style="font-size: 12px; padding-right: 6px;">Your item has been successfully listed on {SITENAME}. To complete the listing and have your item appear to other users please pay the <a href="{PAY_LINK}"><b>auction listing fee</b></a><br>{PAY_LINK}</td>
	</tr>
	<tr>
		<td colspan="3" height="50" style="font-size: 12px; padding-right: 6px;">Here are the listing details:</td>
	</tr>
	<tr>
		<td width="9%" rowspan="2"><img border="0" src="{SITE_URL}{A_PICURL}"></td>
		<td width="55%" rowspan="2">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" style="font-size: 12px;"><a href="{SITE_URL}item.php?id={A_ID}">{A_TITLE}</a></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Auction type:</td>
				<td align="left" style="font-size: 12px;">{A_TYPE}</td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Item #:</td>
				<td align="left" style="font-size: 12px;">{A_ID}</td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Starting bid:</td>
				<td align="left" style="font-size: 12px;">{A_MINBID}</td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Reserve price:</td>
				<td align="left" style="font-size: 12px;">{A_RESERVE}</td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Buy Now price:</td>
				<td align="left" style="font-size: 12px;">{A_BNPRICE}</td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">End time:</td>
				<td align="left" style="font-size: 12px;">{A_ENDS}</td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;"></td>
				<td align="left" style="font-size: 12px;"><a href="{SITE_URL}user_menu.php?">Goto My {SITENAME}</a></td>
			</tr>
		</table>
		</td>
		<td width="34%" style="font-size: 12px;">Have another item to list?</td>
	</tr>
	<tr>
		<td width="34%" height="176" valign="top">
			<a href="{SITE_URL}select_category.php">
				<img border="0" src="{SITE_URL}images/email_alerts/Sell_More_Btn.jpg" width="120" height="32">
			</a>
		</td>
	</tr>
</table>
