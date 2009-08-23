<script type="text/javascript">
$(document).ready(function(){
	//sell javascript
	$("#bn_only_no").click(function(){
		$("#min_bid").removeAttr("disabled");
		$("#reserve_price").removeAttr("disabled");
		$("#iqty").attr("disabled","disabled");
		$("#iqty").val("1");
	});
	$("#bn_only_yes").click(function(){
		$("#min_bid").attr("disabled","disabled");
		$("#reserve_price").attr("disabled","disabled");
		$("#iqty").removeAttr("disabled");
		$("#bn_yes").attr("checked", "checked");
		$("#bn").removeAttr("disabled");
	});
	$("#reserve_price").focus(function(){
		$("#with_reserve_yes").attr("checked", "checked");
	});
	$("#bn").focus(function(){
		$("#bn_yes").attr("checked", "checked");
	});
	$("#bn_no").click(function(){
		$("#bn").attr("disabled","disabled");
		$("#bn_only_no").attr("checked", "checked");
		$("#min_bid").removeAttr("disabled");
		$("#reserve_price").removeAttr("disabled");
		$("#iqty").attr("disabled","disabled");
		$("#iqty").val("1");
	});
	$("#bn_yes").click(function(){
		$("#bn").removeAttr("disabled");
	});
	$("#custominc").focus(function(){
		$("#inc2").attr("checked", "checked");
	});
	$("#atype").change(function(){
		if ($(this).attr("selectedIndex") == 1) { //dutch auction
			$("#with_reserve_no").attr("checked", "checked");
			$("#bn_no").attr("checked", "checked");
			$("#inc1").attr("checked", "checked");
			$("#iqty").removeAttr("disabled");
			$("#min_bid").removeAttr("disabled");
			$(".dutchhide").hide();
			$("#minval_text").text("{L_038}");
		} else { //normal auction
			$(".dutchhide").show();
			$("#iqty").attr("disabled","disabled");
			$("#iqty").val("1");
			$("#minval_text").text("{L_020}");
		}
	});
	$("#bps").click(function(){
		$("#shipping_cost").removeAttr("disabled");
	});
	$("#sps").click(function(){
		$("#shipping_cost").attr("disabled","disabled");
	});
<!-- IF B_FEES -->
	{FEE_JS}
	// something
	var min_bid_fee = {FEE_MIN_BID};
	var bn = {FEE_BN};
	var rp = {FEE_RP};
	$("#min_bid").blur(function(){
		var min_bid = parseFloat($("#min_bid").val());
		updatefee(min_bid_fee * -1);
		if (min_bid == 0) {
			min_bid_fee = 0;
		} else {
			for (var i = 0; i < setup.length; i++) {
				if (setup[i][0] < min_bid && setup[i][1] > min_bid) {
					if (setup[i][3] == 'flat') {
						min_bid_fee = setup[i][2];
						updatefee(setup[i][2]);
					} else {
						min_bid_fee = (setup[i][2] / 100) * min_bid;
						updatefee(min_bid_fee);
					}
					break;
				}
			}
		}
	});
	$("#bn").blur(function(){
		if (bn == parseInt($("#bn").val())){
			if (parseInt($("#bn").val()) > 0)
				updatefee(buyout_fee);
			else
				updatefee(buyout_fee * -1);
			bn = parseInt($("#bn").val());
		}
	});
	$("#reserve_price").blur(function(){
		if (rp == parseInt($("#reserve_price").val())){
			if (parseInt($("#reserve_price").val()) > 0)
				updatefee(rp_fee);
			else
				updatefee(rp_fee * -1);
			rp = parseInt($("#reserve_price").val());
		}
	});
	$("#is_featured").click(function(){
		if ($('#is_featured').is(':checked'))
			updatefee(hpfeat_fee);
		else
			updatefee(hpfeat_fee * -1);
	});
	$("#is_bold").click(function(){
		if ($('#is_bold').is(':checked'))
			updatefee(bolditem_fee);
		else
			updatefee(bolditem_fee * -1);
	});
	$("#is_highlighted").click(function(){
		if ($('#is_highlighted').is(':checked'))
			updatefee(hlitem_fee);
		else
			updatefee(hlitem_fee * -1);
	});

	function updatefee(newfee){
		$("#to_pay").text(parseFloat($("#to_pay").text()) + newfee);
	}
<!-- ENDIF -->
});
</script>
<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{TITLE}
		</div>
		<div class="table2">
        	<a name="goto"></a>
<!-- IF PAGE eq 0 -->
			<form name="sell" action="{ASSLURL}sell.php" method="post" enctype="multipart/form-data">
				<table width="100%" border="0" cellpadding="4" cellspacing="0">
	<!-- IF ERROR ne '' -->
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">&nbsp;</td>
						<td class="errfont">{ERROR}</td>
					</tr>
	<!-- ENDIF -->
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_287}</b>
						</td>
						<td class="rightpan">
							{CAT_LIST}<br>
							[<a href="select_category.php?change=yes">{L_5113}</a>]
						</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_017}</b>
						</td>
						<td class="rightpan">
							<input type="text" name="title" size="40" maxlength="70" value="{AUC_TITLE}">
						</td>
					</tr>

					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_018}</b>
						</td>
						<td class="rightpan">
					   		{AUC_DESCRIPTION}
						</td>
					</tr>
					<input type="hidden" name="imgtype" value="1">
	<!-- IF B_GALLERY -->
					<tr>
						<td align="right" width="25%" valign="middle" class="leftpan">&nbsp;</td>
						<td valign="top" class="rightpan">
							<h3>{L_663}</h3>
							{L_673} {MAXPICS} {L_674}<br>
							[<a href="upldgallery.php" alt="gallery" class="new-window">{L_677}</a>]
                            <input type="hidden" name="numimages" value="{NUMIMAGES}" id="numimages" />
                        </td>
					</tr>
	<!-- ENDIF -->
					<tr>
						<th colspan="2" align="center" valign="middle" class="leftpan">
							{L_640}
						</th>
					</tr>
					<tr>
						<td align="right" width="25%" valign="middle" class="leftpan">
							<b>{L_257}</b>
						</td>
						<td class="rightpan">{ATYPE}</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="middle" class="leftpan">
							<b>{L_258}</b>
						</td>
						<td class="rightpan">
							<input type="text" name="iquantity" id="iqty" size="5" value="{ITEMQTY}" {ITEMQTYD}>
						</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b id="minval_text">{MINTEXT}</b>
						</td>
						<td class="rightpan">
							<input type="text" size="10" name="minimum_bid" id="min_bid" value="{MIN_BID}" {BN_ONLY}>
							{CURRENCY}&nbsp;&nbsp;(<a href="converter.php" alt="converter" class="new-window">{L_5010}</a>)
						</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_023}</b>
						</td>
						<td class="rightpan">
							<input type="text" size="10" name="shipping_cost" id="shipping_cost" value="{SHIPPING_COST}">
							{CURRENCY}&nbsp;&nbsp;(<a href="converter.php" alt="converter" class="new-window">{L_5010}</a>)
						</td>
					</tr>
					<tr class="dutchhide">
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_021}</b>
						</td>
						<td class="rightpan">
							<input type="radio" name="with_reserve" id="with_reserve_no" value="no" {RESERVE_N}>
							{L_029}
							<input type="radio" name="with_reserve" id="with_reserve_yes" value="yes" {RESERVE_Y}>
							{L_030}
							<input type="text" name="reserve_price" id="reserve_price" size="10" value="{RESERVE}" {BN_ONLY}>
							{CURRENCY}&nbsp;&nbsp;(<a href="converter.php" alt="converter" class="new-window">{L_5010}</a>) </td>
					</tr>
	<!-- IF B_BN_ONLY -->
					<tr class="dutchhide">
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_30_0063}</b>
						</td>
						<td class="rightpan">
							<input type="radio" name="buy_now_only" value="n" {BN_ONLY_N} id="bn_only_no">
							{L_029}
							<input type="radio" name="buy_now_only" value="y" {BN_ONLY_Y}  id="bn_only_yes">
							{L_030}
						</td>
					</tr>
	<!-- ENDIF -->
	<!-- IF B_BN -->
					<tr class="dutchhide">
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_496}</b>
						</td>
						<td class="rightpan">
							<input type="radio" name="buy_now" id="bn_no" value="no" {BN_N}>
							{L_029}
							<input type="radio" name="buy_now" id="bn_yes" value="yes" {BN_Y}>
							{L_030}
							<input type="text" name="buy_now_price" id="bn" size="10" value="{BN_PRICE}" {BN}>
							{CURRENCY}&nbsp;&nbsp;(<a href="converter.php" alt="converter" class="new-window">{L_5010}</a>) </td>
					</tr>
	<!-- ENDIF -->
	<!-- IF B_CUSINC -->
					<tr class="dutchhide">
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_120}</b>
						</td>
						<td class="rightpan">
							<input type="radio" name="increments" id="inc1" value="1" {INCREMENTS1}>
							{L_614}
							<br>
							<input type="radio" name="increments" id="inc2" value="2" {INCREMENTS2}>
							{L_615}
							<input type="text" name="customincrement" id="custominc" size="10" value="{CUSTOM_INC}">
							{CURRENCY}&nbsp;&nbsp;(<a href="converter.php" alt="converter" class="new-window">{L_5010}</a>) </td>
					</tr>
	<!-- ELSE -->
					<input type="hidden" name="increments" id="inc1" value="1">
	<!-- ENDIF -->
    <!-- IF B_EDIT_STARTTIME -->
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_2__0016}</b>
						</td>
						<td class="rightpan">
        <!-- IF B_EDITING -->
							{START_TIME}
							<input type="hidden" name="a_starts" value="{START_TIME}">
        <!-- ELSE -->
        					{L_211} <input type="checkbox" name="start_now" {START_NOW}><br>
							{L_260} <input type="text" name="a_starts" id="pubdate_input" value="{START_TIME}" size="20" maxlength="19">
							<a href="javascript:pubdate_cal.popup()"><img src="includes/img/calendar.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a>
							<script type="text/javascript">
							var pubdate_cal = new xar_base_calendar(document.getElementById("pubdate_input"), "."); pubdate_cal.year_scroll = true; pubdate_cal.time_comp = true;
							</script>
        <!-- ENDIF -->
						</td>
					</tr>
	<!-- ELSE -->
    				<input type="hidden" name="start_now" value="1" {START_NOW}>
    <!-- ENDIF -->
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_022}</b>
						</td>
						<td class="rightpan">
							{DURATIONS}
						</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_025}</b>
						</td>
						<td valign="top" class="rightpan">
							<input type="radio" name="shipping" id="bps" value="1" {SHIPPING1}>	
							{L_031}<br>
							<input type="radio" name="shipping" id="sps" value="2" {SHIPPING2}>
							{L_032}<br>
							<input type="checkbox" name="international" value="1" {INTERNATIONAL}>
							{L_033}
						</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_25_0215}</b>
						</td>
						<td>
							<textarea name="shipping_terms" rows="3" cols="34">{SHIPPING_TERMS}</textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_026}</b>
						</td>
						<td class="rightpan">
							{PAYMENTS}
						</td>
					</tr>
	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->
                    <tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_268}</b>
						</td>
						<td class="rightpan">
        <!-- IF B_MKFEATURED -->
        					<p><input type="checkbox" name="is_featured" id="is_featured" {IS_FEATURED}> {L_273}</p>
        <!-- ENDIF -->
        <!-- IF B_MKBOLD -->
        					<p><input type="checkbox" name="is_bold" id="is_bold" {IS_BOLD}> {L_274}</p>
        <!-- ENDIF -->
        <!-- IF B_MKHIGHLIGHT -->
        					<p><input type="checkbox" name="is_highlighted" id="is_highlighted" {IS_HIGHLIGHTED}> {L_292}</p>
        <!-- ENDIF -->
						</td>
					</tr>
	<!-- ENDIF -->
	<!-- IF B_FEES -->
                    <tr>
						<td align="right" width="25%" valign="top" class="leftpan">
							<b>{L_263}</b>
						</td>
						<td class="rightpan">
                        	<span id="to_pay">{FEE_VALUE}</span>
						</td>
					</tr>
	<!-- ENDIF -->
				</table>
				
				<div style="text-align:center">
					<input type="hidden" value="2" name="action">
					<input type="submit" name="" value="{L_5189}"  class="button">&nbsp;&nbsp;&nbsp;<input type="reset" name="" value="{L_5190}" class="button">
				</div>
			</form>
<!-- ELSEIF PAGE eq 1 -->
			<form name="preview" action="{ASSLURL}sell.php" method="post">
			<table width="100%" border="0" cellpadding="4" align="center" cellspacing=0>
	<!-- IF ERROR ne '' -->
			<tr>
				<td class="errfont" colspan="2" align="center">{ERROR}</td>
			</tr>
	<!-- ENDIF -->
			<tr>
				<td colspan="2" align="center">{L_046}</td>
			</tr>
			<tr>
				<td width="40%" align="right"  valign="top"><b>{L_017}</b></td>
				<td width="60%" >{TITLE}</td>
			</tr>
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
				<a href="{SITEURL}preview_gallery.php?img={gallery.K}" alt="preview" class="new-window"><img src="{gallery.IMAGE}" width=40 hspace=5 border=0></a>
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
			<tr>
				<td valign="top" align="right"><b>{L_023}</b></td>
				<td>{SHIPPING_COST}</td>
			</tr>
			<tr>
				<td valign="top" align="right"><b>{L_2__0016}</b></td>
				<td>{STARTDATE}</td>
			</tr>
			<tr>
				<td valign="top" align="right"><b>{L_022}</b></td>
				<td>{DURATION}</td>
			</tr>
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
			<tr>
				<td valign="top" align="right"><b>{L_025}</b></td>
				<td>{SHIPPING}<br>{INTERNATIONAL}</td>
			</tr>
			<tr>
				<td align="right" valign="top"><b>{L_25_0215}</b></td>
				<td>{SHIPPING_TERMS}</td>
			</tr>
			<tr>
				<td valign="top" align="right"><b>{L_026}</b> </td>
				<td>{PAYMENTS_METHODS}</td>
			</tr>
			<tr>
				<td  valign="top" align="right"><b>{L_027}</b></td>
				<td>{CAT_LIST}</td>
			</tr>
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
				<td><input type="password" name="password" size="20" maxlength="20" value=""></td>
			</tr>
	<!-- ENDIF -->
			</table>
			<div style="text-align:center; padding-top: 10px;">
				<input type="hidden" value="3" name="action">
				<input type="submit" name="" value="{L_2__0037}" class="button">
			</div>
			</form>
<!-- ELSE -->
			<div style="text-align:center">
				<p>{L_100}{L_101}<a href="{SITEURL}item.php?id={AUCTION_ID}&mode=1">{SITEURL}item.php?id={AUCTION_ID}</a><p>
			</div>
<!-- ENDIF -->
		</div>
	</div>
</div>