<!-- INCLUDE user_menu_header.tpl -->

<table>
	<tr>
		<td width="150px"><b>{L_846}:</b></td>
		<td style="text-align:center; width: 200px;">{USER_BALANCE}</td>
		<td style="text-align:center; width: 200px;">
			<form name="" method="post" action="pay.php?a=1" id="fees">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				{CURRENCY}
				<input type="text" name="pfval" value="{PAY_BALANCE}" size="7">
				&nbsp;
				<input type="submit" name="{L_1104}" value="{L_1104}" class="pay">
			</form>
		</td>
		<td><a href="{SITEURL}invoices.php">{L_1057}</a></td>
	</tr>
</table>

<table style="width: 100%; border: 0; text-align:center;" cellspacing="1" cellpadding="4">
	<tr>
		<td style="width: 45%; text-align: center;">{L_018}</td>
		<td style="width: 10%; text-align: center;">{L_847}</td>
		<td style="width: 10%; text-align: center;">{L_284}</td>
		<td style="width: 10%; text-align: center;">{L_319}</td>
		<td style="width: 10%; text-align: center;">{L_189}</td>
		<td style="text-align: center;" colspan="2">&nbsp;</td>
	</tr>
<!-- BEGIN to_pay -->
	<tr>
		<td style="text-align: center;">
	<!-- IF to_pay.B_NOTITLE -->
			{L_113} {to_pay.AUC_ID}
	<!-- ELSE -->
			<a href="{to_pay.URL}" target="_blank">{to_pay.TITLE}</a>
	<!-- ENDIF -->
		</td>
		<td style="text-align: center;">{to_pay.BID}</td>
		<td style="text-align: center;">{to_pay.QUANTITY}</td>
		<td style="text-align: center;">
			{to_pay.TOTAL_SHIPPING_COST}
	<!-- IF to_pay.PAY_SHIPPING and to_pay.ADDITIONAL_SHIPPING_QUANTITYS ne 0 and to_pay.ADDITIONAL_SHIPPING_PLAIN ne 0 -->
			<span class="smallspan">({to_pay.SHIPPING} X 1) + ({to_pay.ADDITIONAL_SHIPPING} X {to_pay.ADDITIONAL_SHIPPING_QUANTITYS})</span>
	<!-- ENDIF -->
		</td>
		<td style="text-align: center;">{to_pay.TOTAL}</td>
		<td style="text-align: center; background-color: #FFFFaa;">
			<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="pfval" value="{to_pay.ID}">
				<input type="submit" name="Pay" value="{L_756}" class="pay">
			</form>
		</td>
		<td style="text-align: center; background-color: #FFFFaa;">
			<form name="" method="post" action="{SITEURL}order_print.php" id="fees" title="{L_1153}" target="_blank">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="pfval" value="{to_pay.AUC_ID}">
				<input type="hidden" name="pfwon" value="{to_pay.WINID}">
				<input type="submit" type="button" value="{L_1058}">
			</form>
		</td>
	</tr>
<!-- END to_pay -->
</table>

<br /><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
			<br />
			{PREV}
<!-- BEGIN pages -->
			{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
			{NEXT}
		</td>
	</tr>
</table>

<!-- INCLUDE user_menu_footer.tpl -->
