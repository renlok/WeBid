		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_2_0017}&nbsp;&gt;&gt;&nbsp;{L_2_0020}</h4>
				<form name="errorlog" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<td bgcolor="#FFFF66" colspan="5">
								{L_2_0021}
								<input type="text" name="ip">
								<input type="submit" name="Submit2" value="&gt;&gt;">
								{L_2_0024}
							</td>
						</tr>
						<tr>
							<th width="29%"><b>{L_087}</b></td>
							<th width="25%"><b>{L_2_0009}</b></td>
							<th width="19%"><b>{L_560}</b></td>
							<th width="18%"><b>{L_5028}</b></td>
							<th width="9%"><b>{L_008}</b></td>
						</tr>
<!-- BEGIN ips -->
						<tr {ips.BG}>
							<td>{L_2_0025}</td>
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
							<td align="center"><input type="checkbox" name="delete[]" value="{ips.ID}"></td>
<!-- BEGINELSE -->
							<td colspan="5">{L_831}</td>
<!-- END ips -->
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_2_0015}">
				</form>
			</div>
		</div>