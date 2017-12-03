		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="container">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_board_management}&nbsp;&gt;&gt;&nbsp;{BOARD_NAME}&nbsp;&gt;&gt;&nbsp;{L_5276}</h4>
				<form name="editmessage" action="" method="post">
					<table class="table table-striped table-bordered">
						<tr>
							<td width="24%" valign="top">{L_5059}</td>
							<td>
								<textarea rows="8" cols="40" name="message">{MESSAGE}</textarea>
							</td>
						</tr>
						<tr>
							<td>{L_5060}</td>
							<td>{USER} - {POSTED}</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="id" value="{BOARD_ID}">
					<input type="hidden" name="msg" value="{MSG_ID}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
