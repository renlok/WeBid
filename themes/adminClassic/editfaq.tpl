		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5232}&nbsp;&gt;&gt;&nbsp;{FAQ_NAME}</h4>
				<form name="editfaq" action="" method="post">
					<table width="98%" cellspacing="0" class="blank">
					<tr>
						<td>{L_5238}</td>
						<td>&nbsp;</td>
						<td>
							<select name="category">
<!-- BEGIN cats -->
								<option value="{cats.ID}"<!-- IF cats.ID eq FAQ_CAT -->selected="selected"<!-- ENDIF -->>{cats.CAT}</option>
<!-- END cats -->
							</select>
						</td>
					</tr>
<!-- BEGIN qs -->
					<tr>
	<!-- IF qs.S_ROW_COUNT eq 0 -->
						<td>{L_5239}:</td>
	<!-- ELSE -->
						<td>&nbsp;</td>
	<!-- ENDIF -->
						<td align="right"><img src="../images/flags/{qs.LANG}.gif"></td>
						<td><input type="text" name="question[{qs.LANG}]" maxlength="200" value="{qs.QUESTION}"></td>
					</tr>
<!-- END qs -->
<!-- BEGIN as -->
					<tr>
	<!-- IF as.S_ROW_COUNT eq 0 -->
						<td valign="top">{L_5240}:</td>
	<!-- ELSE -->
						<td>&nbsp;</td>
	<!-- ENDIF -->
						<td align="right" valign="top"><img src="../images/flags/{as.LANG}.gif"></td>
						<td>{as.ANSWER}</td>
					</tr>
<!-- END as -->
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
