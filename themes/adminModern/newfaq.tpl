		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5236}&nbsp;&gt;&gt;&nbsp;{L_5231}</h4>
				<form name="newfaq" action="" method="post">
					<table width="98%" cellpadding="2" class="blank">
						<tr valign="top">
							<td align="right">{L_5231}:</td>
							<td>&nbsp;</td>
							<td>
								<select name="category">
<!-- BEGIN cats -->
									<option value="{cats.ID}">{cats.CATEGORY}</option>
<!-- END cats -->
								</select>
							</td>
						</tr>
<!-- BEGIN lang -->
						<tr valign="top">
	<!-- IF lang.S_ROW_COUNT eq 0 -->
							<td align="right">{L_5239}:</td>
	<!-- ELSE -->
							<td>&nbsp;</td>
	<!-- ENDIF -->
							<td width="35" align="right"><img src="../images/flags/{lang.LANG}.gif"></td>
							<td><input type="text" name="question[{lang.LANG}]" size="40" maxlength="255" value="{lang.TITLE}"></td>
						</tr>
<!-- END lang -->
<!-- BEGIN lang -->
						<tr>
	<!-- IF lang.S_ROW_COUNT eq 0 -->
							<td valign="top" align="right">{L_5240}:</td>
	<!-- ELSE -->
							<td>&nbsp;</td>
	<!-- ENDIF -->
							<td align="right" valign="top"><img src="../images/flags/{lang.LANG}.gif"></td>
							<td><textarea name="answer[{lang.LANG}]" cols="45" rows="20">{lang.CONTENT}</textarea></td>
						</tr>
<!-- END lang -->
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>