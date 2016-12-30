		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="container">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_607}</h4>
				<form name="conf" action="" method="post">
<!-- IF B_PREVIEW -->
					<div class="main-box jumbo-box">
						<h1>{SUBJECT}</h1>
						{PREVIEW}
					</div>
<!-- ENDIF -->
					<table class="table table-striped table-bordered">
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
								{EDITOR}
							</td>
						</tr>
					</table>
<!-- IF B_PREVIEW -->
					<span class="smallspan">{L_606}</span>
					<input type="hidden" name="action" value="submit">
					<input type="submit" name="act" class="centre" value="{L_398}">
<!-- ELSE -->
					<input type="hidden" name="action" value="preview">
					<input type="submit" name="act" class="centre" value="{L_25_0224}">
<!-- ENDIF -->
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				</form>
			</div>
		</div>
