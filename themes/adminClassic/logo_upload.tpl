<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0009}&nbsp;&gt;&gt;&nbsp;{L_30_0215}</h4>
				<form name="logo" action="" method="post" enctype="multipart/form-data">
					<div align="center">
						<table border="0" width="98%" cellpadding="0" cellspacing="5" class="blank">
							<tr>
								<td width="6%" align="left" valign="top">{L_531}</td>
								<td align="left" width="94%"><img src="{IMAGEURL}"></td>
							</tr>
							<tr>
								<td width="119" align="left" valign="top" colspan="2">{L_602}<br><input type="file" name="logo" size="40"></td>
							</tr>
							<tr>
								<td width="12%" align="left" colspan="2">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<input type="submit" name="act" class="centre" value="{L_30_0215}">
								</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
</div>