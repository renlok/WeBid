		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_525}</h4>
				<form name="errorlog" action="" method="post">
					<div class="plain-box"><a href="newadminuser.php">{L_367}</a></div>
					<table width="98%" cellpadding="0" cellspacing="0" align="center">
						<tr>
							<th width="30%">{L_003}</th>
							<th width="16%">{L_558}</th>
							<th width="19%">{L_559}</th>
							<th width="12%">{L_560}</th>
							<th width="23%">{L_561}</th>
						</tr>
<!-- BEGIN users -->
						<tr {users.BG}>
							<td><a href="editadminuser.php?id={users.ID}">{users.USERNAME}</a></td>
							<td align="center">{users.CREATED}</td>
							<td align="center">{users.LASTLOGIN}</td>
							<td align="center">{users.STATUS}</td>
							<td align="center"><input type="checkbox" name="delete[]" value="{users.ID}"></td>
						</tr>
<!-- END users -->
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="Submit" value="{L_561}">
				</form>
			</div>
		</div>