		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_081}</h4>
				<form name="payments" action="" method="post">
					<div class="plain-box">
						<p>{L_094}</p>
						<p><img src="../images/nodelete.gif" width="20" height="21" style="vertical-align:middle;"> {L_2__0030}</p>
					</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th>&nbsp;</th>
							<th><b>{L_087}</b></th>
							<th><b>{L_008}</b></th>
						</tr>
<!-- BEGIN countries -->
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="text" name="new_countries[]" size="45" value="{countries.COUNTRY}">
								<input type="hidden" name="old_countries[]" value="{countries.COUNTRY}">
							</td>
							<td align="center">
	<!-- IF countries.B_CAN_DELETE -->
								<input type="checkbox" name="delete[]" value="{countries.COUNTRY}">
	<!-- ELSE -->
								<img src="../images/nodelete.gif" alt="{L_cannot_delete}">
	<!-- ENDIF -->
							</td>
						</tr>
<!-- END countries -->
						<tr>
							<td colspan="2" align="right">{L_30_0102}</td>
							<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_394}</td>
							<td>
								<input type="text" name="new_countries[]" size="45">
							</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>
