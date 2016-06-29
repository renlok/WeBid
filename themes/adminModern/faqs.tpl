		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5232}</h4>
				<form name="deletefaqs" action="" method="post">
					<table width="98%" cellspacing="0">
					<tr>
						<td colspan="3"><a href="newfaq.php">{L_5231}</a></td>
					</tr>
<!-- BEGIN cats -->
					<tr>
						<th width="86%">{cats.CAT}</th>
						<th>&nbsp;</th>
					</tr>
	<!-- BEGIN faqs -->
					<tr>
						<td><a href="editfaq.php?id={faqs.ID}">{faqs.FAQ}</a></td>
						<td align="center">
							<input type="checkbox" name="delete[]" value="{faqs.ID}">
						</td>
					</tr>
	<!-- END faqs -->
<!-- END cats -->
					<tr>
						<td align="right">{L_30_0102}</td>
						<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
					</tr>
					</table>
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_008}">
				</form>
			</div>
		</div>