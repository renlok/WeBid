<!-- INCLUDE header.tpl -->
		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_607}</h4>
<!-- IF ERROR ne '' -->
				<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
				<form name="conf" action="" method="post">
<!-- IF B_PREVIEW -->
					<div class="main-box">{PREVIEW}</div>
<!-- ENDIF -->
					<table width="98%" cellpadding="2" align="center" class="blank">
						<tr valign="top">
							<td width="175">{L_5299}</td>
							<td style="padding:3px;">
								{SELECTBOX}
							</td>
						</tr>
						<tr valign="top">
							<td width="175">{L_332}</td>
							<td style="padding:3px;">
								<input type="text" name="subject" value="{SUBJECT}" size="50" maxlength="255">
							</td>
						</tr>
						<tr valign="top">
							<td width="175">{L_605}</td>
							<td style="padding:3px;">
								{L_30_0055}
								{EDITOR}
							</td>
						</tr>
					</table>
<!-- IF B_PREVIEW -->
					<span class="smallspan">{L_606}</span>
					<input type="hidden" name="action" value="submit">
					<input type="submit" name="act" class="centre" value="{L_007}">
<!-- ELSE -->
					<input type="hidden" name="action" value="preview">
					<input type="submit" name="act" class="centre" value="{L_25_0224}">
<!-- ENDIF -->
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				</form>
			</div>
		</div>
<!-- INCLUDE footer.tpl -->