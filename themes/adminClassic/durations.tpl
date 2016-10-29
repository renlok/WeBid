		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_069}</h4>
				<form name="durations" action="" method="post">
					{L_122}
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th>&nbsp;</th>
							<th><b>{L_097}</b></th>
							<th><b>{L_087}</b></th>
							<th width="5%"><b>{L_008}</b></th>
						</tr>
<!-- BEGIN dur -->
						<tr>
							<td>&nbsp;</td>
							<td><input type="text" name="new_days[{dur.S_ROW_COUNT}]" value="{dur.DAYS}" size="5"></td>
							<td><input type="text" name="new_durations[{dur.S_ROW_COUNT}]" value="{dur.DESC}" size="25"></td>
							<td align="center"><input type="checkbox" name="delete[]" value="{dur.S_ROW_COUNT}"></td>
						</tr>
<!-- END dur -->
						<tr>
							<td colspan="3" align="right">{L_30_0102}</td>
							<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_518}</td>
							<td><input type="text" name="new_days[]" size="5" maxlength="5"></td>
							<td><input type="text" name="new_durations[]" size="25"></td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>
