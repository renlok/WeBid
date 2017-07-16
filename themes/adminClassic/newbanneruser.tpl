		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0011}&nbsp;&gt;&gt;&nbsp;{L_banner_admin}&nbsp;&gt;&gt;&nbsp;{L__0026}</h4>
				<form name="newuser" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
					<tr>
						<td>{L_302}</td>
						<td><input type="text" name="name" value="{NAME}"></td>
					</tr>
					<tr>
						<td>{L__0022}</td>
						<td><input type="text" name="company" value="{COMPANY}"></td>
					</tr>
					<tr>
						<td>{L_107}</td>
						<td><input type="text" name="email" value="{EMAIL}"></td>
					</tr>
					</table>
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="hidden" name="action" value="insert">
					<input type="submit" name="act" class="centre" value="{L_569}">
				</form>
			</div>
		</div>