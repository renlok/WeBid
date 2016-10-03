		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_525}&nbsp;&gt;&gt;&nbsp;{L_562}</h4>
				<form name="editadmin" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<td>{L_username}</td>
							<td>{USERNAME}</td>
						</tr>
						<tr>
							<td>{L_558}</td>
							<td>{CREATED}</td>
						</tr>
						<tr>
							<td>{L_559}</td>
							<td>{LASTLOGIN}</td>
						</tr>
						<tr>
							<td colspan="2">{L_563}</td>
						</tr>
						<tr>
							<td>{L_password}</td>
							<td><input type="password" name="password" size="25"></td>
						</tr>
						<tr>
							<td>{L_564}</td>
							<td><input type="password" name="repeatpassword" size="25"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="radio" name="status" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_566}<br>
								<input type="radio" name="status" value="0"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_567}
							</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
