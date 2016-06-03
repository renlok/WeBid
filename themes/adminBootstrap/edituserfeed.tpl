		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}&nbsp;&gt;&gt;&nbsp;{RATED_USER}&nbsp;&gt;&gt;&nbsp;{L_222}</h4>
				<form name="editfeedback" action="" method="post">
					<div class="plain-box">
						{RATER_USER} {L_506}{RATED_USER}
					</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
					<tr>
						<td>{L_503}</td>
						<td>
							<input type="radio" name="aTPL_rate" value="1" <!-- IF SEL1 -->checked="checked"<!-- ENDIF -->>
							<img src="{SITEURL}images/positive.png" border="0">
							<input type="radio" name="aTPL_rate" value="0" <!-- IF SEL2 -->checked="checked"<!-- ENDIF -->>
							<img src="{SITEURL}images/neutral.png" border="0">
							<input type="radio" name="aTPL_rate" value="-1" <!-- IF SEL3 -->checked="checked"<!-- ENDIF -->>
							<img src="{SITEURL}images/negative.png" border="0">
						</td>
					</tr>
					<tr>
						<td>{L_504}</td>
						<td>
							<textarea name="TPL_feedback" rows="10" cols="50">{FEEDBACK}</textarea>
						</td>
					</tr>
					</table>
					<input type="hidden" name="user" value="{RATED_USER_ID}">
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
				<div class="plain-box">
					<p><a href="{SITEURL}admin/userfeedback.php?id={RATED_USER_ID}">{L_234}</a></p>
				</div>
			</div>
		</div>