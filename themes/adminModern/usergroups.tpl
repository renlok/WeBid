		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_448}</h4>
				<form name="errorlog" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th><b>{L_449}</b></th>
							<th><b>{L_450}</b></th>
							<th><b>{L_451}</b></th>
							<th><b>{L_578}</b></th>
							<th><b>{L_579}</b></th>
							<th><b>{L_580}</b></th>
							<th>&nbsp;</th>
						</tr>
<!-- IF B_EDIT -->
						<tr>
							<td colspan="7"><b>{L_452}</b></td>
						</tr>
						<tr>
							<td>{GROUP_ID}</td>
							<td><input type="text" name="group_name" value="{EDIT_NAME}"></td>
							<td><input type="text" name="user_count" value="{USER_COUNT}"></td>
							<td>
								<select name="can_sell">
									<option value="1" {CAN_SELL_Y}>{L_030}</option>
									<option value="0" {CAN_SELL_N}>{L_029}</option>
								</select>
							</td>
							<td>
								<select name="can_buy">
									<option value="1" {CAN_BUY_Y}>{L_030}</option>
									<option value="0" {CAN_BUY_N}>{L_029}</option>
								</select>
							</td>
							<td>
								<select name="auto_join">
									<option value="1" {AUTO_JOIN_Y}>{L_030}</option>
									<option value="0" {AUTO_JOIN_N}>{L_029}</option>
								</select>
							</td>
							<td>
								<input type="hidden" name="id" value="{GROUP_ID}">
	<!-- IF NOT_DEFAULT_GROUP -->
								<input type="checkbox" name="remove" value="1">{L_008}
	<!-- ENDIF -->
							</td>
						</tr>
						<tr>
							<th colspan="7">&nbsp;</th>
						</tr>
<!-- ENDIF -->
<!-- BEGIN groups -->
						<tr>
							<td>{groups.ID}</td>
							<td>{groups.NAME}</td>
							<td>{groups.USER_COUNT}</td>
							<td>{groups.CAN_SELL}</td>
							<td>{groups.CAN_BUY}</td>
							<td>{groups.AUTO_JOIN}</td>
							<td><a href="usergroups.php?id={groups.ID}&action=edit">{L_298}</a></td>
						</tr>
<!-- END groups -->
						<tr>
							<td colspan="7"><a href="usergroups.php?action=new">{L_518}</a></td>
						</tr>
					</table>

<!-- IF GROUPS_UNKNOWN -->
					<p class="error"><h4><b>{L_warning}</b></h4></p>
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th><b>{L_449}</b></th>
							<th><b>{L_450}</b></th>
							<th><b>{L_451}</b></th>
							<th><b>{L_045}</b> {L_text_update_users_group}</th>
						</tr>
<!-- BEGIN groups_unknown -->
						<tr>
							<td>{groups_unknown.ID}</td>
							<td>{groups_unknown.NAME}</td>
							<td>{groups_unknown.USER_COUNT}</td>
							<td>
							<!-- BEGIN list_users -->
							<!-- IF groups_unknown.list_users.TYPE eq 1 -->
							<p>{L_313} <a href="edituser.php?userid={groups_unknown.list_users.ID}&offset=1">{groups_unknown.list_users.NAME}</a> {L_error_no_user_group}
							</p>
							<!-- ENDIF -->
							<!-- IF groups_unknown.list_users.TYPE eq 2 -->
							<p>{L_313} <a href="edituser.php?userid={groups_unknown.list_users.ID}&offset=1">{groups_unknown.list_users.NAME}</a> {L_error_no_user_group_id}
							</p>
							<!-- ENDIF -->
							<!-- END list_users -->
							</td>
						</tr>
<!-- END groups_unknown -->
					</table>
<!-- ENDIF -->

					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
