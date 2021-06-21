		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5032}&nbsp;&gt;&gt;&nbsp;{L_5052}</h4>
				<form name="errorlog" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
					<tr>
						<td width="24%">{L_5034}</td>
						<td width="76%">
							<input type="text" name="name" size="25" maxlength="255" value="{NAME}">
						</td>
					</tr>
					<tr>
						<td>{L_5043}</td>
						<td>{MESSAGES} (<a href="editmessages.php?id={ID}">{L_5063}</a>)</td>
					</tr>
					<tr>
						<td>{L_5053}</td>
						<td>{LAST_POST}</td>
					</tr>
					<tr>
						<td>{L_5035}</td>
						<td>
							<p>{L_5036}</p>
							<input type="text" name="msgstoshow" size="4" maxlength="4" value="{MSGTOSHOW}">
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="radio" name="active" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_5038}<br>
							<input type="radio" name="active" value="0"<!-- IF B_DEACTIVE --> checked="checked"<!-- ENDIF -->> {L_5039}
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
