		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_ip_addresses}&nbsp;&gt;&gt;&nbsp;{L_ip_ban_management}</h4>
				<form name="errorlog" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<td bgcolor="#FFFF66" colspan="5">
								{L_ban_this_ip}
								<input type="text" name="ip">
								<input type="submit" name="Submit2" value="&gt;&gt;">
								{L_ip_example}
							</td>
						</tr>
						<tr>
							<th width="29%"><b>{L_087}</b></td>
							<th width="25%"><b>{L_ip_address}</b></td>
							<th width="19%"><b>{L_560}</b></td>
							<th width="18%"><b>{L_297}</b></td>
							<th width="9%"><b>{L_008}</b></td>
						</tr>
<!-- BEGIN ips -->
						<tr<!-- IF ips.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
							<td>{L_manually_entered}</td>
							<td align="center">{ips.IP}</td>
							<td align="center">
	<!-- IF ips.ACTION eq 'accept' -->
								<span style="color:#A2CD5A;"><b>{L_accepted}</b></span>
	<!-- ELSE -->
								<span style="color:#CD0000;"><b>{L_banned}</b></span>
	<!-- ENDIF -->
							</td>
							<td>
	<!-- IF ips.ACTION eq 'accept' -->
								<input type="checkbox" name="deny[]" value="{ips.ID}">
								&nbsp;{L_ban}
	<!-- ELSE -->
								<input type="checkbox" name="accept[]" value="{ips.ID}">
								&nbsp;{L_accept}
	<!-- ENDIF -->
							</td>
							<td align="center"><input type="checkbox" name="delete[]" value="{ips.ID}"></td>
<!-- BEGINELSE -->
							<td colspan="5">{L_no_ips_banned}</td>
<!-- END ips -->
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_process_selection}">
				</form>
			</div>
		</div>
