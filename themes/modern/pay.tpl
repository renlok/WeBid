<div class="alert alert-info" role="alert">{TOP_MESSAGE}</div>
<div class="well">
	<div class="row">
<!-- BEGIN gateways -->
<!-- IF gateways.NAME eq 'paypal' and gateways.B_ACTIVE -->
		<div class="col-md-3">
			<img src="images/paypal.gif">
		</div>
		<div class="col-md-7">
			{L_767}
		</div>
		<div class="col-md-2 text-right">
			<form action="<!-- IF SANDBOX -->https://www.sandbox.paypal.com/cgi-bin/webscr<!-- ELSE -->https://www.paypal.com/cgi-bin/webscr<!-- ENDIF -->" method="post" id="form_paypal">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="{gateways.PAY_ADDRESS}">
				<input type="hidden" name="receiver_email" value="{gateways.PAY_ADDRESS}">
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
				<input class="btn btn-primary" name="submit" type="submit" value="{L_756}" border="0">
			</form>
		</div>
<!-- ENDIF -->
<!-- IF gateways.NAME eq 'authnet' and gateways.B_ACTIVE -->
		<div class="col-md-3">
			<img src="images/authnet.gif">
		</div>
		<div class="col-md-7">
			Authorize.Net
		</div>
		<div class="col-md-2 text-right">
			<form action="<!-- IF SANDBOX -->https://test.authorize.net/gateway/transact.dll<!-- ELSE -->https://secure.authorize.net/gateway/transact.dll<!-- ENDIF -->" method="post" id="form_authnet">
				<input type="hidden" name="x_description" value="{TITLE}">
				<input type="hidden" name="x_login" value="{gateways.PAY_ADDRESS}">
				<input type="hidden" name="x_amount" value="{PAY_VAL}">
				<input type="hidden" name="x_show_form" value="PAYMENT_FORM">
				<input type="hidden" name="x_relay_response" value="TRUE">
				<input type="hidden" name="x_relay_url" value="{SITEURL}validate.php?authnet">
				<input type="hidden" name="x_fp_sequence" value="{gateways.AN_SEQUENCE}">
				<input type="hidden" name="x_fp_timestamp" value="{TIMESTAMP}">
				<input type="hidden" name="x_fp_hash" value="{gateways.AN_KEY}">
				<input type="hidden" name="custom" value="{CUSTOM_CODE}">
				<input class="btn btn-primary" name="submit" type="submit" value="{L_756}" border="0">
			</form>
		</div>
<!-- ENDIF -->
<!-- IF gateways.NAME eq 'worldpay' and gateways.B_ACTIVE -->
		<div class="col-md-3">
			<img src="images/worldpay.gif">
		</div>
		<div class="col-md-7">
			WorldPay
		</div>
		<div class="col-md-2 text-right">
			<form action="<!-- IF SANDBOX -->https://secure-test.worldpay.com/wcc/purchase<!-- ELSE -->https://select.worldpay.com/wcc/purchase<!-- ENDIF -->" method="post" id="form_worldpay">
				<input type="hidden" name="instId" value="{gateways.PAY_ADDRESS}">
				<input type="hidden" name="amount" value="{PAY_VAL}">
				<input type="hidden" name="currency" value="{CURRENCY}">
				<input type="hidden" name="desc" value="{TITLE}">
				<input type="hidden" name="MC_callback" value="{SITEURL}validate.php?worldpay">
				<input type="hidden" name="cartId" value="{CUSTOM_CODE}">
				<input class="btn btn-primary" name="submit" type="submit" value="{L_756}" border="0">
			</form>
		</div>
<!-- ENDIF -->
<!-- IF gateways.NAME eq 'moneybookers' and gateways.B_ACTIVE -->
		<div class="col-md-3">
			<img src="images/moneybookers.gif">
		</div>
		<div class="col-md-7">
			Moneybookers
		</div>
		<div class="col-md-2 text-right">
			<form action="<!-- IF SANDBOX -->http://www.moneybookers.com/app/test_payment.pl<!-- ELSE -->https://www.moneybookers.com/app/payment.pl<!-- ENDIF -->" method="post" id="form_moneybookers">
				<input type="hidden" name="pay_to_email" value="{gateways.PAY_ADDRESS}">
				<input type="hidden" name="amount" value="{PAY_VAL}">
				<input type="hidden" name="language" value="EN">
				<input type="hidden" name="merchant_fields" value="trans_id">
				<input type="hidden" name="currency" value="{CURRENCY}">
				<input type="hidden" name="return_url" value="{SITEURL}validate.php?completed">
				<input type="hidden" name="cancel_url" value="{SITEURL}validate.php?fail">
				<input type="hidden" name="status_url" value="{SITEURL}validate.php?moneybookers">
				<input type="hidden" name="trans_id" value="{CUSTOM_CODE}">
				<input class="btn btn-primary" name="submit" type="submit" value="{L_756}" border="0">
			</form>
		</div>
<!-- ENDIF -->
<!-- IF gateways.NAME eq 'toocheckout' and gateways.B_ACTIVE -->
		<div class="col-md-3">
			<img src="images/toocheckout.gif">
		</div>
		<div class="col-md-7">
			2Checkout
		</div>
		<div class="col-md-2 text-right">
			<form action="<!-- IF SANDBOX -->https://sandbox.2checkout.com/checkout/purchase<!-- ELSE -->https://www2.2checkout.com/2co/buyer/purchase<!-- ENDIF -->" method="post" id="form_toocheckout">
				<input type="hidden" name="sid" value="{gateways.PAY_ADDRESS}">
				<input type="hidden" name="total" value="{PAY_VAL}">
				<input type="hidden" name="cart_order_id" value="{CUSTOM_CODE}">
				<input class="btn btn-primary" name="submit" type="submit" value="{L_756}" border="0">
			</form>
		</div>
<!-- ENDIF -->
<!-- END gateways -->
	</div>
</div>
<!-- IF NO_ONLINE_GATEWAYS -->
<div class="alert alert-danger text-center" role="alert">
		{L_778a}
</div>
<!-- ENDIF -->

<!-- IF B_TOUSER -->
<div class="alert alert-danger text-center" role="alert">
	{TOUSER_STRING}
</div>
<!-- ENDIF -->
