		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_239}&nbsp;&gt;&gt;&nbsp;{L_512}</h4>
				<form name="editauction" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
					<tr>
						<td width="25%" align="right">{L_313}</td>
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
						<td align="right">{L_287}</td>
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
						<td align="right">{L_022}</td>
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
							<div>{L_1105}</div>
<!-- BEGIN gallery -->
							<div style="width:50px; float: left;">
								<a href="{SITEURL}/{gallery.V}" title="{gallery.V}" target="_blank">
									<img src="{SITEURL}getthumb.php?fromfile={gallery.V}" border="0" hspace="10">
								</a>
								<input type="checkbox" name="gallery[]" value="{gallery.V}">
							</div>
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
						<td align="right">{L_124}</td>
						<td><input type="text" name="min_bid" size="40" maxlength="40" value="{MIN_BID}"></td>
					</tr>
					<tr>
						<td align="right">{L_023}</td>
						<td><input type="text" name="shipping_cost" size="40" maxlength="40" value="{SHIPPING_COST}"></td>
					</tr>
					<tr>
						<td align="right">{L_021}</td>
						<td><input type="text" name="reserve_price" size="40" maxlength="40" value="{RESERVE}"></td>
					</tr>
					<tr>
						<td align="right">{L_30_0063}</td>
						<td>
							<input type="radio" name="buy_now_only" value="0" {BN_ONLY_N}> {L_029}
							<input type="radio" name="buy_now_only" value="1" {BN_ONLY_Y}> {L_030}
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
						<td align="right" valign="top">{L_025}</td>
						<td>
							<input type="radio" name="shipping" value="1" {SHIPPING1}>	{L_031}<br>
							<input type="radio" name="shipping" value="2" {SHIPPING2}>	{L_032}<br>
							<input type="checkbox" name="international" value="1" {INTERNATIONAL}> {L_033}
						</td>
					</tr>
					<tr>
						<td align="right" valign="top">{L_25_0215}</td>
						<td><textarea name="shipping_terms" rows="3" cols="34">{SHIPPING_TERMS}</textarea></td>
					</tr>
					<tr>
						<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
							<b>{L_5233}</b>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top">{L_026}</td>
						<td>{PAYMENTS}</td>
					</tr>
	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->
					<tr>
						<td align="right" valign="top">{L_268}</td>
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
					</table>
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>
