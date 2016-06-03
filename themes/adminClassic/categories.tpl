		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_276}&nbsp;&gt;&gt;&nbsp;{L_078}</h4>
				<form name="newcat" action="" method="post">
					<div class="plain-box">{L_845}</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<td width="10" height="21">&nbsp;</td>
							<td colspan="4" height="21">{CRUMBS}</td>
						</tr>
						<tr>
							<th width="10">&nbsp;</th>
							<th width="40%"><b>{L_087}</b></th>
							<th width="20%"><b>{L_328}</b></th>
							<th width="20%"><b>{L_329}</b></th>
							<th><b>{L_008}</b></th>
						</tr>
<!-- BEGIN cats -->
						<tr>
							<td width="10" align="right" valign="middle">
								<a href="categories.php?parent={cats.CAT_ID}"><img src="{SITEURL}images/plus.gif" border="0" alt="Browse Subcategories"></a>
							</td>
							<td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.CAT_NAME}" size="50"></td>
							<td><input type="text" name="colour[{cats.CAT_ID}]" value="{cats.CAT_COLOUR}" size="25"></td>
							<td><input type="text" name="image[{cats.CAT_ID}]" value="{cats.CAT_IMAGE}" size="25"></td>
							<td valign="middle">
								<input type="checkbox" name="delete[]" value="{cats.CAT_ID}">
	<!-- IF cats.B_SUBCATS -->
								<img src="{SITEURL}themes/{THEME}/images/bullet_blue.png">
	<!-- ENDIF -->
	<!-- IF cats.B_AUCTIONS -->
								<img src="{SITEURL}themes/{THEME}/images/bullet_red.png">
	<!-- ENDIF -->
							</td>
						</tr>
<!-- END cats -->
						<tr>
							<td colspan="4" align="right">{L_30_0102}</td>
							<td><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_394}</td>
							<td><input type="text" name="new_category" size="25"></td>
							<td><input type="text" name="cat_colour" size="25"></td>
							<td><input type="text" name="cat_image" size="25"></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="5" height="22">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>{L_368}</td>
							<td colspan="3">
								<textarea name="mass_add" cols="35" rows="6"></textarea>
							</td>
						</tr>
					</table>
					<input type="hidden" name="parent" value="{PARENT}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button type="submit" name="action" class="centre" value="Process">{L_089}</button>
				</form>
			</div>
		</div>