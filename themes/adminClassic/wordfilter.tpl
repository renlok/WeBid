		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_5068}</h4>
				<form name="wordlist" action="" method="post">
					<table width="98%" cellspacing="0" cellpadding="0" align="center" class="blank">
						<tr valign="top">
							<td width="109">&nbsp;</td>
							<td width="375">{L_5069}</td>
						</tr>
						<tr valign="top">
							<td>{L_5070}</td>
							<td>
								<input type="radio" name="wordsfilter" value="y"{WFYES}> {L_030}
								<input type="radio" name="wordsfilter" value="n"{WFNO}> {L_029}
							</td>
						</tr>
						<tr valign="top">
							<td>{L_5071}</td>
							<td>
								{L_5072}<br>
								<textarea name="filtervalues" cols="45" rows="15">{WORDLIST}</textarea>
							</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>