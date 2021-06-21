		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_25_0169}</h4>
				<form name="memberlevels" action="" method="post">
					<div class="plain-box">{L_25_0170}</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th>&nbsp;</th>
							<th><b>{L_25_0171}</b></th>
							<th><b>{L_25_0167}</b></th>
							<th>&nbsp;</th>
							<th width="5%"><b>{L_008}</b></th>
						</tr>
<!-- BEGIN mtype -->
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="hidden" name="old_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}">
								<input type="text" name="new_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}" size="5">
							</td>
							<td>
								<input type="hidden" name="old_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}">
								<input type="text" name="new_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}" size="25">
							</td>
							<td><img src="../images/icons/{mtype.ICON}" align="middle"></td>
							<td align="center"><input type="checkbox" name="delete[]" value="{mtype.ID}"></td>
						</tr>
<!-- END mtype -->
						<tr>
							<td colspan="4" align="right">{L_30_0102}</td>
							<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_518}</td>
							<td><input type="text" name="new_membertype[feedbacks]" size="5"></td>
							<td><input type="text" name="new_membertype[icon]" size="30"></td>
							<td colspan="2">&nbsp;</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>