<!-- INCLUDE user_menu_header.tpl -->

<table>
<tr>
    <td width="150px"><b>{L_846}:</b></td>
    <td style="text-align:center; width: 200px;">{USER_BALANCE}</td>
    <td style="text-align:center; width: 200px;">
    	<form name="" method="post" action="pay.php" id="fees">
<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
        {CURRENCY} <input type="text" name="pfval" value="{PAY_BALANCE}" size="7">&nbsp;<input type="submit" name="Pay" value="Pay" class="pay">
        </form>
    </td>
    <td><a href="{SITEURL}invpdf.php">SHOW ME INVOICE</a></td>
</tr>
</table>
<table width="100%" cellspacing="3" cellpadding="4" class="no-arrow" RULES=ROWS FRAME=HSIDES>
<tr style="background-color:{TBLHEADERCOLOUR}">
	<th style="text-align: center;" class="titTable7 shadow rounded-left">Invoice</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow rounded-left">Setup</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow rounded-left">Featured</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow rounded-left">BoldItem</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Highlighted</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Subtitle</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Relist</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">RP</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Buy Now</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Pictures</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Extra Category</th>
	<th style="width: 8%; text-align: center;" class="titTable7 shadow">Total</th>
	<th style="text-align: center;" class="titTable7 shadow">Status</th>
</tr>
<!-- BEGIN topay -->
<tr>
	<td style="text-align: center;"><span class="titleText125">Invoice: {topay.INVOICE}</span><div class="label blue">Auction ID: {topay.ID}</span>
	<br>(Created: {topay.DATE})</div></td>
	<td style="text-align: center;">{topay.FEE_SETUP}</td>
	<td style="text-align: center;">{topay.FEE_FEATURED}</td>
	<td style="text-align: center;">{topay.FEE_BOLD_ITEM}</td>
	<td style="text-align: center;">{topay.FEE_HIGHLITED}</td>
	<td style="text-align: center;">{topay.FEE_SUBTITLE}</td>
	<td style="text-align: center;">{topay.RELIST_TOTAL}</td>
	<td style="text-align: center;">{topay.FEE_RP}</td>
	<td style="text-align: center;">{topay.FEE_BN}</td>
	<td style="text-align: center;">{topay.PIC_TOTAL}</td>
	<td style="text-align: center;">{topay.EXTRA_CAT_FEE}</td>
	<td style="text-align: center;">{topay.FEE_VALUE_F}</td>
	<td style="text-align: center;" >{topay.PAID}{topay.TICK}<a href="{topay.PDF}">PDF</a></td>
</tr>
<!-- END topay -->
</table> 


<table style="width: 100%; border: 0; text-align:center;" cellspacing="1" cellpadding="4">
<tr style="background-color:{TBLHEADERCOLOUR}">
    <td style="width: 45%; text-align: center;">{L_018}</td>
    <td style="width: 10%; text-align: center;">{L_847}</td>
    <td style="width: 10%; text-align: center;">{L_319}</td>
    <td style="width: 10%; text-align: center;">{L_189}</td>
    <td style="text-align: center;">&nbsp;</td>
</tr>
<!-- BEGIN to_pay -->
<tr>
    <td style="text-align: center;">
    <!-- IF to_pay.B_NOTITLE -->
    	{L_113} {to_pay.ID}
    <!-- ELSE -->
    	<a href="{to_pay.URL}" target="_blank">{to_pay.TITLE}</a>
    <!-- ENDIF -->
    </td>
    <td style="text-align: center;">{to_pay.BID}</td>
    <td style="text-align: center;">{to_pay.SHIPPING}</td>
    <td style="text-align: center;">{to_pay.TOTAL}</td>
    <td style="text-align: center; background-color: #FFFFaa;">
    	<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
        <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
    	<input type="hidden" name="pfval" value="{to_pay.ID}">
        <input type="submit" name="Pay" value="{L_756}" class="pay">
        </form>
    </td>
    <td style="text-align: center; background-color: #FFFFaa;">
    <form name="" method="post" action="{SITEURL}order_print.php" id="fees" title="Print Invoice" target="_blank">
        <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
    	<input type="hidden" name="pfval" value="{to_pay.ID}">
		<input type="hidden" name="pfwon" value="{to_pay.WINID}">
		<input type="hidden" name="user_id" value="{ID}">
        <input type="submit" type="button" value="Print Invoive">
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