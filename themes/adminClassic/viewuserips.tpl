		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}&nbsp;&gt;&gt;&nbsp;{L_2_0004}</h4>
				<form name="banips" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<td colspan="3">{L_667} <b>{NICK}</b></td>
							<td align="right">{L_559}: {LASTLOGIN}</td>
						</tr>
						<tr>
							<th width="35%"><b>{L_087}</b></th>
							<th width="27%"><b>{L_2_0009}</b></th>
							<th width="21%"><b>{L_560}</b></th>
							<th width="17%"><b>{L_5028}</b></th>
						</tr>
<!-- BEGIN ips -->
						<tr {ips.BG}>
							<td>
	<!-- IF ips.TYPE eq 'first' -->
								{L_2_0005}
	<!-- ELSE -->
								{L_221}
	<!-- ENDIF -->
							</td>
							<td align="center">{ips.IP}</td>
							<td align="center">
	<!-- IF ips.ACTION eq 'accept' -->
								{L_2_0012}
	<!-- ELSE -->
								{L_2_0013}
	<!-- ENDIF -->
							</td>
							<td>
	<!-- IF ips.ACTION eq 'accept' -->
								<input type="checkbox" name="deny[]" value="{ips.ID}">
								&nbsp;{L_2_0006}
	<!-- ELSE -->
								<input type="checkbox" name="accept[]" value="{ips.ID}">
								&nbsp;{L_2_0007}
	<!-- ENDIF -->
							</td>
						</tr>
<!-- END ips -->
					</table>
					<input type="hidden" name="offset" value="{OFFSET}">
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_2_0015}">
				</form>
				<table width="98%" cellpadding="0" cellspacing="0" class="blank">
					<tr>
						<td align="center">
							{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
							<br>
							{PREV}
<!-- BEGIN pages -->
							{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
							{NEXT}
						</td>
					</tr>
				</table>
				<div class="plain-box"><a href="listusers.php?offset={OFFSET}" class="small">{L_5279}</a></div>
			</div>
		</div>