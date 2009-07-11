<!-- INCLUDE user_menu_header.html -->

<form name="auctions" method="post" action="" id="fees">

<table style="width: 100%;border: 0; text-align:center;" cellspacing="1" cellpadding="4">
<tr style="background-color:{TBLHEADERCOLOUR}">
<td class="titTable1" style="width: 34%; text-align: center;">
<a href="#">Item Description</a>
</td>
<td class="titTable1" style="width: 17%; text-align: center;">
<a href="#">Fees</a>
</td>
<td class="titTable1" style="width: 16%; text-align: center;">
<a href="#">Paid</a>
</td>
<td class="titTable1" style="width: 17%; text-align: center;">
<a href="#">Outstanding</a>
</td>
<td class="titTable1" style="width: 16%; text-align: center;">
<a href="#">Pay Now</a>
</td>
</tr>

<tr bgcolor="#EEEEEE">
<td style="width: 34%; text-align: center;">
<a href="#">Nokia N95 Mobile Phone</a>
</td>
<td style="width: 17%; text-align: center;">
&euro;1.75
</td>
<td style="width: 16%; text-align: center;">
&euro;0
</td>
<td style="width: 17%; text-align: center;">
&euro;1.75
</td>
<td style="width: 16%; text-align: center; background-color: #FFFFaa;">
<select>
<option value="PayPal">PayPal</option>
<option value="Google">Google</option>
<option value="WorldPay" selected>WorldPay</option>
<option value="ClicknBuy">Click'n'Buy</option>
</select><br />
<input type="button" name="Pay" value="Pay Now" class="pay" />
</td>
</tr>
<tr bgcolor="#EEEEEE">
<td style="width: 34%; text-align: center;">
<a href="#">Tiffany Lamp</a>
</td>
<td style="width: 17%; text-align: center;">
&euro;1.50
</td>
<td style="width: 16%; text-align: center;">
&euro;0
</td>
<td style="width: 17%; text-align: center;">
&euro;1.50
</td>
<td style="width: 16%; text-align: center; background-color: #FFFFaa;">
<select>
<option value="PayPal">PayPal</option>
<option value="Google">Google</option>
<option value="WorldPay">WorldPay</option>
<option value="ClicknBuy">Click'n'Buy</option>
</select><br />
<input type="button" name="Pay" value="Pay Now" class="pay" />
</td>
</tr>

<tr bgcolor="{BGCOLOUR}">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr bgcolor="{BGCOLOUR}">
<td>&nbsp;</td>
<td colspan="2" style="text-align:right; font-weight: 600;">Total Outstanding:</td>
<td style="font-weight: 600; text-align:center;">&euro;3.25</td>
<td style="text-align:center;">
<select>
<option value="PayPal">PayPal</option>
<option value="Google">Google</option>
<option value="WorldPay">WorldPay</option>
<option value="ClicknBuy">Click'n'Buy</option>
</select><br />
<input type="button" name="Pay" value="Pay All" class="pay" />
</td>
</tr>
</table>
</form>
<br /><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td align="center">
{L_5117}&nbsp;&nbsp;{PAGE}
{L_5118}&nbsp;&nbsp;{PAGES}
<br />
{PREV}
<!-- BEGIN pages -->
{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
{NEXT}
</td>
</tr>
</table>

<!-- INCLUDE user_menu_footer.html -->