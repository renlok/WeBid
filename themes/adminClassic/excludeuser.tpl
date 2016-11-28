		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}&nbsp;&gt;&gt;&nbsp;{ACTION}</h4>
				<table width="98%" celpadding="0" cellspacing="0" class="blank">
					<tr>
						<td width="204">{L_302}</td>
						<td>{REALNAME}</td>
					</tr>
					<tr>
						<td>{L_username}</td>
						<td>{USERNAME}</td>
					</tr>
					<tr>
						<td>{L_303}</td>
						<td>{EMAIL}</td>
					</tr>
					<tr>
						<td>{L_252}</td>
						<td>{DOB}</td>
					</tr>
					<tr>
						<td>{L_009}</td>
						<td>{ADDRESS}</td>
					</tr>
					<tr>
						<td>{L_011}</td>
						<td>{PROV}</td>
					</tr>
					<tr>
						<td>{L_012}</td>
						<td>{ZIP}</td>
					</tr>
					<tr>
						<td>{L_014}</td>
						<td>{COUNTRY}</td>
					</tr>
					<tr>
						<td>{L_013}</td>
						<td>{PHONE}</td>
					</tr>
					<tr>
						<td>{L_222}</td>
						<td>
							<p><a href="userfeedback.php?id={ID}">{L_208}</a></p>
						</td>
					</tr>
					<tr>
						<td width="204">&nbsp;</td>
						<td>{QUESTION}</td>
					</tr>
					<tr>
						<td width="204">&nbsp;</td>
						<td>
							<form name="details" action="" method="post">
								<input type="hidden" name="id" value="{ID}">
								<input type="hidden" name="mode" value="{MODE}">
								<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
								<button type="submit" name="action" value="Yes">{L_yes}</button>
								<button type="submit" name="action" value="No">{L_no}</button>
							</form>
						</td>
					</tr>
				</table>
			</div>
		</div>
