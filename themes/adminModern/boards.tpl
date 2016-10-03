		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_board_management}</h4>
				<form name="deletelogs" action="" method="post">
					<div class="plain-box"><b>{L_delete_board_warning}</b></div>
					<table width="98%" cellspacing="0">
					<tr>
						<th width="6%">{L_129}</th>
						<th>{L_294}</th>
						<th width="10%" align="center">{L_show}</th>
						<th width="12%" align="center">{L_num_messages}</th>
						<th width="16%">&nbsp;</th>
					</tr>
<!-- BEGIN boards -->
					<tr>
						<td>{boards.ID}</td>
						<td>
							<a href="editboards.php?id={boards.ID}">{boards.NAME}</a>
	<!-- IF boards.ACTIVE eq 2 -->
							<b>[{L_5039}]</b>
	<!-- ENDIF -->
						</td>
						<td align="center">{boards.MSGTOSHOW}</td>
						<td align="center">{boards.MSGCOUNT}</td>
						<td align="center">
							<input type="checkbox" name="delete[]" value="{boards.ID}">
						</td>
					</tr>
<!-- END boards -->
					<tr>
						<td colspan="4" align="right">{L_30_0102}</td>
						<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
					</tr>
					</table>
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_008}">
				</form>
			</div>
		</div>
