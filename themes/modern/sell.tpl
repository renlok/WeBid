<!-- IF PAGE eq 0 -->
<script type="text/javascript">
$(document).ready(function(){
	// set up the page
	// do something
	//sell javascript
	$("#bn_only_no").click(function() {
		$(".additional_shipping_costhide").hide();
		$("#additional_shipping_cost").attr("disabled","disabled");
			$("#min_bid").removeAttr("disabled");
			$("#reserve_price").removeAttr("disabled");
			$("#iqty").attr("disabled","disabled");
			$("#iqty").val("1");
	});
	$("#bn_only_yes").click(function() {
		$(".additional_shipping_costhide").show();
		$("#additional_shipping_cost").removeAttr("disabled","disabled");
			$("#min_bid").attr("disabled","disabled");
			$("#reserve_price").attr("disabled","disabled");
			$("#with_reserve_no").attr("checked", "checked");
			$("#iqty").removeAttr("disabled");
			$("#bn_yes").attr("checked", "checked");
			$("#bn").removeAttr("disabled");
	});
	$("#reserve_price").focus(function() {
		$("#with_reserve_yes").attr("checked", "checked");
	});
	$("#bn").focus(function() {
		$("#bn_yes").attr("checked", "checked");
	});
	$("#bn_no").click(function() {
		$("#bn_only_no").attr("checked", "checked");
		$("#min_bid").removeAttr("disabled");
		$("#reserve_price").removeAttr("disabled");
		$("#iqty").attr("disabled","disabled");
		$("#iqty").val("1");
	});
	$("#custominc").focus(function() {
		$("#inc2").attr("checked", "checked");
	});
	$("#atype").change(function() {
		if ($(this).find(':selected').val() == 2)
		{
			//dutch auction
			$("#additional_shipping_cost").attr("disabled","disabled");
			$("#additional_shipping_cost").removeAttr("disabled","disabled");
			$("#with_reserve_no").attr("checked", "checked");
			$("#bn_only_no").attr("checked", "checked");
			$("#bn_no").attr("checked", "checked");
			$("#inc1").attr("checked", "checked");
			$("#iqty").removeAttr("disabled");
			$("#min_bid").removeAttr("disabled");
			$(".dutchhide").hide();
			$("#minval_text").text("{L_038}");
		}
		else
		{
			//normal auction
			$("#additional_shipping_cost").removeAttr("disabled","disabled");
			$(".additional_shipping_costhide").hide();
			$(".dutchhide").show();
			$("#iqty").attr("disabled","disabled");
			$("#iqty").val("1");
			$("#minval_text").text("{L_020}");
		}
	});
	$("#bps").click(function() {
		$("#shipping_cost").removeAttr("disabled");
	});
	$(".sps").click(function() {
		$("#additional_shipping_cost").removeAttr("disabled","disabled");
		$(".additional_shipping_costhide").hide();
		$("#shipping_cost").attr("disabled","disabled");
		$("#shipping_cost").val("0.00");
	});
	<!-- IF B_FEES -->
	{FEE_JS}
	// something
	var min_bid_fee = {FEE_MIN_BID};
	var bn = {FEE_BN};
	var rp = {FEE_RP};
	var st = {FEE_SUBTITLE};
	st = st * 1;
	var rl = {FEE_RELIST};
	$("#min_bid").blur(function() {
		var min_bid = parseFloat($("#min_bid").val());
		updatefee(min_bid_fee * -1);
		min_bid_fee = 0; // just incase theres nothing
		if (min_bid == 0)
		{
			min_bid_fee = 0;
		}
		else
		{
			for (var i = 0; i < setup.length; i++)
			{
				if (setup[i][0] <= min_bid && setup[i][1] >= min_bid)
				{
					if (setup[i][3] == 'flat')
					{
						min_bid_fee = setup[i][2];
						updatefee(setup[i][2]);
					}
					else
					{
						min_bid_fee = (setup[i][2] / 100) * min_bid;
						updatefee(min_bid_fee);
					}
					break;
				}
			}
		}
	});
	$("#resetbt").click(function() {
		current_fee = current_fee.toFixed({FEE_DECIMALS});
		$("#fee_exact").val(current_fee);
		$("#to_pay").text(current_fee);
	});
	$("#bn").blur(function() {
		bin();
	});
	$("#bn_yes").click(function() {
		bin();
	});
	$("#bn_no").click(function() {
		$("#bn").val(0);
		bin();
	});
	function bin() {
		if (bn != parseInt($("#bn").val()))
		{
			if (parseInt($("#bn").val()) > 0)
				updatefee(buynow_fee);
			else
				updatefee(buynow_fee * -1);
			bn = parseInt($("#bn").val());
		}
	}
	$("#reserve_price").blur(function() {
		reserve();
	});
	$("#with_reserve_yes").click(function() {
		reserve();
	});
	$("#with_reserve_no").click(function() {
		$("#reserve_price").val(0);
		reserve();
	});
	function reserve() {
		if (rp != parseInt($("#reserve_price").val()))
		{
			if (parseInt($("#reserve_price").val()) > 0)
				updatefee(reserve_fee);
			else
				updatefee(reserve_fee * -1);
			rp = parseInt($("#reserve_price").val());
		}
	}
	$("#is_featured").click(function() {
		if ($('#is_featured').is(':checked'))
			updatefee(featured_fee);
		else
			updatefee(featured_fee * -1);
	});
	$("#is_bold").click(function() {
		if ($('#is_bold').is(':checked'))
			updatefee(bold_fee);
		else
			updatefee(bold_fee * -1);
	});
	$("#is_highlighted").click(function() {
		if ($('#is_highlighted').is(':checked'))
			updatefee(highlighted_fee);
		else
			updatefee(highlighted_fee * -1);
	});
		<!-- IF B_SUBTITLE -->
	$("#subtitle").blur(function() {
		if (st > 0 && $("#subtitle").val().length == 0)
		{
			updatefee(subtitle_fee * -1);
			st = 0;
		}
		if (st == 0 && $("#subtitle").val().length > 0)
		{
			updatefee(subtitle_fee);
			st = subtitle_fee;
		}
	});
		<!-- ENDIF -->
		<!-- IF B_AUTORELIST -->
	$("#autorelist").blur(function() {
		var rl_times = $("#autorelist").val();
		updatefee(relist_fee * rl * -1);
		updatefee(relist_fee * rl_times);
		rl = rl_times;
	});
		<!-- ENDIF -->
	function updatefee(newfee) {
		var nowfee = parseFloat($("#fee_exact").val()) + newfee - current_fee;
		$("#fee_exact").val(nowfee);
		if (nowfee < 0)
		{
			nowfee = 0;
		}
		nowfee = nowfee.toFixed({FEE_DECIMALS});
		$("#to_pay").text(nowfee);
	}
	<!-- ENDIF -->
});
</script>
<!-- ENDIF -->
<!-- IF ATYPE_PLAIN eq 2 -->
<style type="text/css">
.dutchhide {
	display: none;
}
</style>
<!-- ENDIF -->
<div class="row">
	<div class="col-md-12">
		<div class="col-md-8 col-md-offset-2 well">
			<legend>{TITLE}</legend>
			<div class="table2">
				<a name="goto"></a>
<!-- IF ERROR ne '' -->
				<div class="alert alert-danger" role="alert">
					{ERROR}
				</div>
<!-- ENDIF -->
<!-- IF PAGE eq 0 -->
				<form name="sell" action="{SITEURL}sell.php" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<div class="form-group col-md-12">
						<label>{L_287}</label>
						{CAT_LIST1}
	<!-- IF CAT_LIST2 ne '' -->
						{CAT_LIST2}
	<!-- ENDIF -->
						<a class="btn btn-primary btn-xs" href="select_category.php?change=yes">{L_5113}</a>
					</div>
					<div class="form-group col-md-12">
						<label for="title">{L_017}</label>
						<div class="row">
							<div class="col-md-6">
								<input type="text" name="title" class="form-control" value="{AUC_TITLE}">
							</div>
						</div>
					</div>
	<!-- IF B_SUBTITLE -->
					<div class="form-group col-md-12">
						<label for="subtitle">{L_806}</label>
						<div class="row">
							<div class="col-md-6">
								<input type="text" name="subtitle" id="subtitle" class="form-control" value="{AUC_SUBTITLE}">
							</div>
						</div>
					</div>
	<!-- ENDIF -->
					<div class="form-group col-md-12">
						<label for="subtitle">{L_018}</label>
						{AUC_DESCRIPTION}
					</div>
	<!-- IF B_GALLERY -->
					<legend>{L_663}</legend>
					<div class="form-group col-md-12">
						<div class="alert alert-info" role="alert">{MAXPICS}</div>
						<a href="upldgallery.php" alt="gallery" class="btn btn-primary new-window">{L_677}</a>
						<input type="hidden" name="numimages" value="{NUMIMAGES}" id="numimages">
						<hr />
					</div>
	<!-- ENDIF -->
					<div class="form-group col-md-12">
						<div class="alert alert-warning" role="alert">{L_640}</div>
					</div>
					<div class="form-group col-md-12">
						<label for="atype">{L_257}</label>
						<div class="row">
							<div class="auctiontype col-md-4">{ATYPE}</div>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label for="iquantity">{L_258}</label>
						<div class="row">
							<div class="col-md-4">
								<input type="text" name="iquantity" id="iqty" class="form-control" value="{ITEMQTY}" {ITEMQTYD}>
							</div>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label for="minimum_bid" id="minval_text">{MINTEXT}</label>
						<div class="row">
							<div class="col-md-4">
								<input type="text" class="form-control" name="minimum_bid" id="min_bid" value="{MIN_BID}" {BN_ONLY}>
							</div>
							{CURRENCY}
						</div>
					</div>
	<!-- IF B_CUSINC -->
					<div class="form-group col-md-12 dutchhide">
						<label>{L_120}</label>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="increments" id="inc1" value="1" {INCREMENTS1}>
								{L_614}
							</label>
							<label class="radio-inline">
								<input type="radio" name="increments" id="inc2" value="2" {INCREMENTS2}>
								{L_615}
							</label>
						</div>
						<input type="text" name="customincrement" id="custominc" class="form-control" value="{CUSTOM_INC}">
						{CURRENCY}
					</div>
	<!-- ELSE -->
					<input type="hidden" name="increments" id="inc1" value="1">
	<!-- ENDIF -->
					<div class="form-group col-md-12 dutchhide">
						<label>{L_021}</label>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="with_reserve" id="with_reserve_no" value="no" {RESERVE_N}>
								{L_029}
							</label>
							<label class="radio-inline">
								<input type="radio" name="with_reserve" id="with_reserve_yes" value="yes" {RESERVE_Y}>
								{L_030}
							</label>
						</div>
						<input type="text" name="reserve_price" id="reserve_price" class="form-control" value="{RESERVE}" {BN_ONLY}>
						{CURRENCY}
					</div>
	<!-- IF B_BN_ONLY -->
					<div class="form-group col-md-12 dutchhide">
						<label>{L_30_0063}</label>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="buy_now_only" value="0" {BN_ONLY_N} id="bn_only_no">
								{L_029}
							</label>
							<label class="radio-inline">
								<input type="radio" name="buy_now_only" value="1" {BN_ONLY_Y} id="bn_only_yes">
								{L_030}
							</label>
						</div>
					</div>
	<!-- ENDIF -->
	<!-- IF B_BN -->
					<div class="form-group col-md-12 dutchhide">
						<label>{L_496}</label>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="buy_now" id="bn_no" value="no" {BN_N}>
								{L_029}
							</label>
							<label class="radio-inline">
								<input type="radio" name="buy_now" id="bn_yes" value="yes" {BN_Y}>
								{L_030}
							</label>
						</div>
						<input type="text" name="buy_now_price" id="bn" class="form-control" value="{BN_PRICE}">
						{CURRENCY}
					</div>
	<!-- ENDIF -->
	<!-- IF B_EDIT_STARTTIME -->
					<div class="form-group col-md-12">
						<label for="a_starts">{L_2__0016}</label>
		<!-- IF B_EDITING && !B_CANEDITSTARTDATE -->
						{START_TIME}
						<input type="hidden" name="a_starts" value="{START_TIME}">
		<!-- ELSE -->
						<div class="checkbox">
							<label>
								<input type="checkbox" name="start_now" id="start_now" {START_NOW}> {L_211}
							</label>
						</div>
						<label>{L_260}</label>
						<input type="text" name="a_starts" id="pubdate_input" value="{START_TIME}" class="form-control">
						<script type="text/javascript">
							new tcal ({'id': 'pubdate_input', 'controlname': 'a_starts', 'formname': 'sell', 'now': 'start_now'});
							$('#pubdate_input').change(function () {
								$('#start_now').attr('checked', false);
							});
						</script>
		<!-- ENDIF -->
					</div>
	<!-- ELSE -->
					<input type="hidden" name="start_now" value="1">
	<!-- ENDIF -->
	<!-- IF B_EDIT_ENDTIME -->
					<div class="form-group col-md-12">
						<label>{L_custom_end_time}</label>
						<div class="row">
							<div class="duration col-md-4"><input type="checkbox" name="custom_end" {CUSTOM_END}></div>
						</div>
					</div>
	<!-- ENDIF -->
					<div class="form-group col-md-12">
						<label>{L_ending_date}</label>
						<div class="row">
							<div class="duration col-md-4">
	        					{L_022}: {DURATIONS}<br>
				<!-- IF B_EDIT_ENDTIME -->
								{L_or_custom_end_time}: <input type="text" name="a_ends" id="a_ends" value="{END_TIME}" size="20" maxlength="19">
								<script type="text/javascript">
									new tcal ({'id': 'a_ends','controlname': 'a_ends', 'formname': 'sell'});
									$('#a_ends').change(function () {
										$('#custom_end').attr('checked', true);
									});
								</script>
				<!-- ENDIF -->
							</div>
						</div>
					</div>
	<!-- IF B_AUTORELIST -->
					<div class="form-group col-md-12">
						<label>{L__0161}</label>
						<p class="bg-info sm-padding">{L__0162}</p>
						<div class="row">
							<div class="relist col-md-4">{RELIST}</div>
						</div>
					</div>
	<!-- ENDIF -->
	<!-- IF B_SHIPPING -->
					<legend>{L_864}</legend>
					<div class="form-group col-md-12">
						<label for="shipping_cost">{L_023}</label>
						<div class="row">
							<div class="col-md-4">
								<input type="text" class="form-control" name="shipping_cost" id="shipping_cost" value="{SHIPPING_COST}" <!-- IF SHIPPING1 eq '' -->disabled="disabled"<!-- ENDIF -->>
								{CURRENCY}
							</div>
						</div>
					</div>
					<div class="form-group col-md-12 additional_shipping_costhide">
						<label for="additional_shipping_cost">{L_350_1008}</label>
						<div class="row">
							<div class="col-md-4">
								<input type="text" class="form-control" name="additional_shipping_cost" id="additional_shipping_cost" value="{ADDITIONAL_SHIPPING_COST}" <!-- IF SHIPPING1 eq '' -->disabled="disabled"<!-- ENDIF -->>
								{CURRENCY}
							</div>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>{L_025}</label>
						<div class="radio">
							<label>
								<input type="radio" name="shipping" id="bps" value="1" {SHIPPING1}>
								{L_031}
							</label>
							<br>
							<label>
								<input type="radio" name="shipping" id="sps" value="2" {SHIPPING2}>
								{L_032}
							</label>
							<br>
							<label>
								<input type="radio" name="shipping" id="sps" value="3" {SHIPPING3}>
								{L_867}
							</label>
							<br>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="international" value="1" {INTERNATIONAL}>
								{L_033}
							</label>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label for="shipping_terms">{L_25_0215}</label>
						<textarea name="shipping_terms" rows="3" class="form-control">{SHIPPING_TERMS}</textarea>
					</div>
	<!-- ENDIF -->
					<legend>{L_30_0080}</legend>
					<div class="form-group col-md-12">
						<label>{L_026}</label>
						<div class="checkbox">
							<label>{PAYMENTS}</label>
						</div>
					</div>
					<legend>{L_268}</legend>
	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->
					<div class="form-group col-md-12">
						<div class="checkbox">
		<!-- IF B_MKFEATURED -->
							<label><p><input type="checkbox" name="is_featured" id="is_featured" {IS_FEATURED}> {L_273}</p></label><br>
		<!-- ENDIF -->
		<!-- IF B_MKBOLD -->
							<label><p><input type="checkbox" name="is_bold" id="is_bold" {IS_BOLD}> {L_274}</p></label><br>
		<!-- ENDIF -->
		<!-- IF B_MKHIGHLIGHT -->
							<label><p><input type="checkbox" name="is_highlighted" id="is_highlighted" {IS_HIGHLIGHTED}> {L_292}</p></label>
		<!-- ENDIF -->
						</div>
					</div>
	<!-- ENDIF -->
	<!-- IF B_CAN_TAX -->
					<div class="form-group col-md-12">
						<label>{L_1102}</label>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="is_taxed" value="1" {TAX_Y}>	{L_030}
							</label>
							<label class="radio-inline">
								<input type="radio" name="is_taxed" value="0" {TAX_N}> {L_029}
							</label>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>{L_1103}</label>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="tax_included" value="1" {TAXINC_Y}>	{L_030}
							</label>
							<label class="radio-inline">
								<input type="radio" name="tax_included" value="0" {TAXINC_N}> {L_029}
							</label>
						</div>
					</div>
	<!-- ENDIF -->
	<!-- IF B_FEES -->
					<div class="form-group col-md-12">
						<input type="hidden" name="fee_exact" id="fee_exact" value="{FEE_VALUE}">
						<div class="alert alert-info" role="alert">
							<b>{L_1151}: </b><span class="text-danger" id="to_pay"> {FEE_VALUE_F} </span><small> {CURRENCY}</small>
						</div>
					</div>
	<!-- ENDIF -->
					<div style="text-align:center">
						<input type="hidden" value="3" name="action">
						<input type="submit" name="" value="{L_5189}" class="btn btn-primary">&nbsp;&nbsp;&nbsp;
						<input type="reset" id="resetbt" value="{L_5190}" class="btn btn-warning">
					</div>
				</form>
<!-- ELSEIF PAGE eq 2 -->
				<form name="preview" action="{SITEURL}sell.php" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<table class="table table-striped table-bordered">
						<tr>
							<td colspan="2" align="center">{L_046}</td>
						</tr>
						<tr>
							<td width="40%" align="right"  valign="top"><b>{L_017}</b></td>
							<td width="60%" >{TITLE}</td>
						</tr>
	<!-- IF B_SUBTITLE -->
						<tr>
							<td width="40%" align="right"  valign="top"><b>{L_806}</b></td>
							<td width="60%" >{SUBTITLE}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
							<td  valign="top" align="right"><b>{L_018}</b></td>
							<td>{AUC_DESCRIPTION}</td>
						</tr>
						<tr>
							<td  valign="top" align="right"><b>{L_019}</b></td>
							<td>{PIC_URL}</td>
						</tr>
	<!-- IF B_GALLERY -->
						<tr>
							<td width="260" valign="middle" align="right">&nbsp;</td>
							<td>
								{L_663}<br>
		<!-- BEGIN gallery -->
								<a href="{SITEURL}preview_gallery.php?img={gallery.K}" alt="preview" class="new-window"><img src="{gallery.IMAGE}" width=60 hspace=5 border=0></a>
		<!-- END gallery -->
							</td>
						</tr>
	<!-- ENDIF -->
	<!-- IF B_BN_ONLY -->
						<tr>
							<td valign="top" align="right"><b>{MINTEXT}</b></td>
							<td>{MIN_BID}</td>
						</tr>
	<!-- ENDIF -->
	<!-- IF ATYPE_PLAIN eq 1 -->
		<!-- IF B_BN_ONLY -->
						<tr>
							<td valign="top" align="right"><b>{L_021}</b></td>
							<td>{RESERVE}</td>
						</tr>
		<!-- ENDIF -->
		<!-- IF B_BN -->
						<tr>
							<td valign="top" align="right"><b>{L_496}</b></td>
							<td>{BN_PRICE}</td>
						</tr>
		<!-- ENDIF -->
	<!-- ENDIF -->
	<!-- IF B_SHIPPING -->
						<tr>
							<td valign="top" align="right"><b>{L_023}</b></td>
							<td>{SHIPPING_COST}</td>
						</tr>
						<tr>
							<td valign="top" align="right"><b>{L_350_1008}</b></td>
							<td>{ADDITIONAL_SHIPPING_COST}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
							<td valign="top" align="right"><b>{L_2__0016}</b></td>
							<td>{STARTDATE}</td>
						</tr>
		<!-- IF CUSTOM_END -->
						<tr>
							<td valign="top" align="right"><b>{L_end_date}</b></td>
							<td>{END_TIME}</td>
						</tr>
		<!-- ELSE -->
						<tr>
							<td valign="top" align="right"><b>{L_022}</b></td>
							<td>{DURATION}</td>
						</tr>
		<!-- ENDIF -->
	<!-- IF B_CUSINC -->
						<tr>
							<td valign="top" align="right"><b>{L_120}</b> </td>
							<td>{INCREMENTS}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
							<td valign="top" align="right"><b>{L_261}</b> </td>
							<td>{ATYPE}</td>
						</tr>
	<!-- IF B_SHIPPING -->
						<tr>
							<td valign="top" align="right"><b>{L_025}</b></td>
							<td>{SHIPPING}<br>{INTERNATIONAL}</td>
						</tr>
						<tr>
							<td align="right" valign="top"><b>{L_25_0215}</b></td>
							<td>{SHIPPING_TERMS}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
							<td valign="top" align="right"><b>{L_026}</b> </td>
							<td>{PAYMENTS_METHODS}</td>
						</tr>
						<tr>
							<td  valign="top" align="right"><b>{L_027}</b></td>
							<td>
								{CAT_LIST1}
	<!-- IF CAT_LIST2 ne '' -->
								<br>{CAT_LIST2}
	<!-- ENDIF -->
							</td>
						</tr>
	<!-- IF B_FEES -->
						<tr>
							<td valign="top" align="right"><b>{L_1151}</b> </td>
							<td>{FEE}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
							<td  valign="top" align="right"></td>
							<td>{L_264}<a href="{SITEURL}sell.php?mode=recall">{L_265}</a>{L_266}<br></td>
						</tr>
	<!-- IF B_USERAUTH -->
						<tr>
							<td align="right">{L_003}</td>
							<td><b>{YOURUSERNAME}</b><input type="hidden" name="nick" value="{YOURUSERNAME}">
						</tr>
						<tr>
							<td align="right">{L_004}</td>
							<td><input type="password" name="password" class="form-control" value=""></td>
						</tr>
	<!-- ENDIF -->
					</table>
					<div style="text-align:center; padding-top: 10px;">
						<input type="hidden" value="4" name="action">
						<input type="submit" name="" value="{L_2__0037}" class="btn btn-primary">
					</div>
				</form>
<!-- ELSE -->
				<div class="padding">
					{L_100}
					<p>{MESSAGE}</p>
					<ul>
						<li><a href="{SITEURL}item.php?id={AUCTION_ID}&mode=1">{L_101}</a></li>
						<li><a href="{SITEURL}edit_active_auction.php?id={AUCTION_ID}">{L_30_0069}</a></li>
						<li><a href="{SITEURL}sellsimilar.php?id={AUCTION_ID}">{L_2__0050}</a></li>
					</ul>
				</div>
<!-- ENDIF -->
			</div>
		</div>
	</div>
</div>
