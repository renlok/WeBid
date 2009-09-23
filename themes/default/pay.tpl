<p align="center">{TOP_MESSAGE}</p>

<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable">
<!-- IF B_ENPAYPAL -->
<tr>
    <td width="160" class="paytable1"><img src="images/paypal.gif"></td>
    <td class="paytable2">{L_767}</td>
    <td class="paytable3">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="form_paypal">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="{PP_PAYTOEMAIL}">
        <input type="hidden" name="receiver_email" value="{PP_PAYTOEMAIL}">
        <input type="hidden" name="amount" value="{PAY_VAL}">
        <input type="hidden" name="currency_code" value="{CURRENCY}">
        <input type="hidden" name="return" value="{SITEURL}validate.php?completed">
        <input type="hidden" name="cancel_return" value="{SITEURL}validate.php?fail">
        <input type="hidden" name="item_name" value="{TITLE}">
        <input type="hidden" name="undefined_quantity" value="0">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="custom" value="{CUSTOM_CODE}">
        <input type="hidden" name="notify_url" value="{SITEURL}validate.php?paypal">
        <input name="submit" type="submit" value="Pay" border="0">
    </form>
    </td>
</tr>
<!-- ENDIF -->
<!-- IF B_ENAUTHNET -->
<tr>
    <td width="160" class="paytable1"><img src="images/authnet.gif"></td>
    <td class="paytable2">Authorize.Net</td>
    <td class="paytable3">
    <form action="https://secure.authorize.net/gateway/transact.dll" method="post" id="form_authnet">
        <input type="hidden" name="x_description" value="{TITLE}">
        <input type="hidden" name="x_login" value="{AN_PAYTOID}">
        <input type="hidden" name="x_amount" value="{PAY_VAL}">
        <input type="hidden" name="x_show_form" value="PAYMENT_FORM">
        <input type="hidden" name="x_relay_response" value="TRUE">
        <input type="hidden" name="x_relay_url" value="{SITEURL}validate.php?authnet">
        <input type="hidden" name="x_fp_sequence" value="{AN_SEQUENCE}">
        <input type="hidden" name="x_fp_timestamp" value="{TIMESTAMP}">
        <input type="hidden" name="x_fp_hash" value="{AN_KEY}">
        <input type="hidden" name="custom" value="{CUSTOM_CODE}">
        <input name="submit" type="submit" value="Pay" border="0">
    </form>
    </td>
</tr>
<!-- ENDIF -->
</table>