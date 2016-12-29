		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="container">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5236}&nbsp;&gt;&gt;&nbsp;{L_5231}</h4>
				<form name="newfaq" action="" method="post">
					<table class="table table-striped table-bordered">
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
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
