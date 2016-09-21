		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5236}&nbsp;&gt;&gt;&nbsp;{L_5230}</h4>
				<form name="newfaqcat" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
<!-- IF B_ADDCAT -->
						<tr bgcolor="#FFFF66">
							<td>{L_165}</td>
							<td colspan="2">
	<!-- BEGIN lang -->
								<p>{lang.LANG}:&nbsp;<input type="text" name="cat_name[{lang.LANG}]" size="25" maxlength="200"></p>
	<!-- END lang -->
								<button type="submit" name="action" value="Insert">{L_5204}</button>
							</td>
						</tr>
<!-- ELSE -->
						<tr>
							<td colspan="3"><a href="faqscategories.php?do=add">{L_5234}</a></td>
						</tr>
<!-- ENDIF -->
						<tr>
							<th width="14%"><b>{L_5237}</b></th>
							<th><b>{L_287}</b></th>
							<th width="14%"><b>{L_008}</b></th>
						</tr>
<!-- BEGIN cats -->
						<tr {cats.BG}>
							<td>{cats.ID}</td>
							<td><a href="editfaqscategory.php?id={cats.ID}">{cats.CATEGORY}</a> <!-- IF cats.FAQS gt 0 -->{cats.FAQSTXT}<!-- ENDIF --></td>
							<td align="center"><input type="checkbox" name="delete[]" value="{cats.ID}"></td>
						</tr>
<!-- END cats -->
					</table>
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button type="submit" name="action" value="Delete" class="button">{L_008}</button>
				</form>
			</div>
		</div>
