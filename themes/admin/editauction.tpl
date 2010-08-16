<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr> 
				<td width="30"><img src="images/i_auc.gif" ></td>
				<td class="white">{L_239}&nbsp;&gt;&gt;&nbsp;{L_512}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
			<td align="center" class="title">{L_512}</td>
		</tr>
		<tr>
			<td>
				<form name="details" action="" method="post">
				<table width="100%" border="0" cellpadding="5" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td class="error" colspan="2">{ERROR}</td>
				</tr>
<!-- ENDIF -->
				<tr>
					<td width="170" align="right">{L_313}</td>
					<td>{USER}</td>
				</tr>
				<tr>
					<td align="right">{L_017}</td>
					<td><input type="text" name="title" size="40" maxlength="255" value="{TITLE}"></td>
				</tr>
				<tr>
					<td align="right">{L_806}</td>
					<td><input type="text" name="subtitle" size="40" maxlength="255" value="{SUBTITLE}"></td>
				</tr>
				<tr>
					<td align="right">{L_316}</td>
					<td>{CATLIST1}</td>
				</tr>
				<tr>
					<td align="right">{L_814}</td>
					<td>{CATLIST2}</td>
				</tr>
				<tr>
					<td align="right">{L_018}</td>
					<td><textarea name="description" cols="40" rows="8">{DESC}</textarea></td>
				</tr>
				<tr>
					<td align="right">{L_258}</td>
					<td><input type="text" name="quantity" size="40" maxlength="40" value="{QTY}"></td>
				</tr>
				<tr>
					<td align="right">{L_315}</td>
					<td>
						<select name="duration">
							<option value=""> </option>
							{DURLIST}
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
						<b>{L_816}</b>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
<!-- BEGIN gallery -->
						<a href="{SITEURL}{UPLOADEDPATH}{ID}/{gallery.V}" title="{gallery.V}" class="padding">
							<img src="{SITEURL}getthumb.php?w={THUMBWIDTH}&fromfile={UPLOADEDPATH}{ID}/{gallery.V}" border="0" width="{THUMBWIDTH}" hspace="10">
						</a>
<!-- END gallery -->
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
						<b>{L_817}</b>
					</td>
				</tr>
				<tr>
					<td align="right">{L_257}</td>
					<td>{ATYPE}</td>
				</tr>
				<tr>
					<td align="right">{L_116}</td>
					<td>{CURRENT_BID}</td>
				</tr>
				<tr>
					<td align="right">{L_327}</td>
					<td><input type="text" name="min_bid" size="40" maxlength="40" value="{MIN_BID}"></td>
				</tr>
				<tr>
					<td align="right">{L_023}</td>
					<td><input type="text" name="shipping_cost" size="40" maxlength="40" value="{SHIPPING_COST}"></td>
				</tr>
				<tr>
					<td align="right">{L_320}</td>
					<td><input type="text" name="reserve_price" size="40" maxlength="40" value="{RESERVE}"></td>
				</tr>
				<tr>
					<td align="right">{L_30_0063}</td>
					<td>
						<input type="radio" name="buy_now_only" value="n" {BN_ONLY_N}> {L_029}
						<input type="radio" name="buy_now_only" value="y" {BN_ONLY_Y}> {L_030}
					</td>
				</tr>
				<tr>
					<td align="right">{L_497}</td>
					<td><input type="text" name="buy_now" size="40" maxlength="40" value="{BN_PRICE}"></td>
				</tr>
				<tr>
					<td align="right">{L_120}</td>
					<td>
						<input type="text" name="customincrement" size="10" value="{CUSTOM_INC}">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
						<b>{L_319}</b>
					</td>
				</tr>
				<tr>
					<td align="right">{L_025}</td>
					<td>
						<input type="radio" name="shipping" value="1" {SHIPPING1}>	{L_031}<br>
						<input type="radio" name="shipping" value="2" {SHIPPING2}>	{L_032}<br>
						<input type="checkbox" name="international" value="1" {INTERNATIONAL}> {L_033}
					</td>
				</tr>
				<tr>
					<td align="right">{L_25_0215}</td>
					<td><textarea name="shipping_terms" rows="3" cols="34">{SHIPPING_TERMS}</textarea></td>
				</tr>
				<tr>
					<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
						<b>{L_5233}</b>
					</td>
				</tr>
				<tr>
					<td align="right"><b>{L_026}</b></td>
					<td>{PAYMENTS}</td>
				</tr>
	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->
				<tr>
					<td align="right">
						<b>{L_268}</b>
					</td>
					<td>
        <!-- IF B_MKFEATURED -->
						<p><input type="checkbox" name="is_featured" {IS_FEATURED}> {L_273}</p>
        <!-- ENDIF -->
        <!-- IF B_MKBOLD -->
        				<p><input type="checkbox" name="is_bold" {IS_BOLD}> {L_274}</p>
        <!-- ENDIF -->
        <!-- IF B_MKHIGHLIGHT -->
        				<p><input type="checkbox" name="is_highlighted" {IS_HIGHLIGHTED}> {L_292}</p>
        <!-- ENDIF -->
					</td>
				</tr>
	<!-- ENDIF -->
				<tr>
					<td align="right">{L_300}</td>
					<td>{SUSPENDED}</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="{ID}">
						<input type="hidden" name="action" value="update">
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="act" value="{L_089}"></td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->