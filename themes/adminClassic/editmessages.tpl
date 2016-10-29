		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_board_management}&nbsp;&gt;&gt;&nbsp;{BOARD_NAME}&nbsp;&gt;&gt;&nbsp;{L_5063}</h4>
				<table width="98%" cellpadding="0" cellspacing="0">
					<tr>
						<td bgcolor="#FFFF66" colspan="4">
							<form name="clearmessages" action="" method="post">
							{L_5065}
							<input type="text" name="days">
							{L_5115}
							<input type="hidden" name="action" value="purge">
							<input type="hidden" name="id" value="{ID}">
							<input type="submit" name="submit" value="{L_5029}">
							</form>
						</td>
					</tr>
					<tr>
						<th width="55%">{L_5059}</th>
						<th width="15%">{L_5060}</th>
						<th width="15%">{L_314}</th>
						<th width="15%">&nbsp;</th>
					</tr>
<!-- BEGIN msgs -->
					<tr<!-- IF msgs.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
						<td>{msgs.MESSAGE}</td>
						<td>{msgs.POSTED_BY}</td>
						<td>{msgs.POSTED_AT}</td>
						<td><a href="editmessage.php?id={ID}&msg={msgs.ID}">{L_298}</a>&nbsp;|&nbsp;<a href="deletemessage.php?board_id={ID}&id={msgs.ID}">{L_008}</a></td>
					</tr>
<!-- END msgs -->
				</table>
			</div>
		</div>