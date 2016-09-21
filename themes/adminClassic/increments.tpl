		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_128}</h4>
				<form name="increments" action="" method="post">
					<div class="plain-box">
						{L_135}
					</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th>&nbsp;</th>
							<th><b>{L_240}</b></th>
							<th><b>{L_241}</b></th>
							<th><b>{L_137}</b></th>
							<th width="10%"><b>{L_008}</b></th>
						</tr>
<!-- BEGIN increments -->
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="hidden" name="id[]" value="{increments.ID}">
								<input type="text" name="lows[]" value="{increments.LOW}" size="10">
							</td>
							<td><input type="text" name="highs[]" value="{increments.HIGH}" size="10"></td>
							<td><input type="text" name="increments[]" value="{increments.INCREMENT}" size="10"></td>
							<td align="center"><input type="checkbox" name="delete[]" value="{increments.ID}"></td>
						</tr>
<!-- END increments -->
						<tr>
							<td colspan="4" align="right">{L_30_0102}</td>
							<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_518}</td>
							<td>
								<input type="hidden" name="id[]" value="">
								<input type="text" name="lows[]" size="10">
							</td>
							<td><input type="text" name="highs[]" size="10"></td>
							<td><input type="text" name="increments[]" size="10"></td>
							<td align="center">&nbsp;</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>