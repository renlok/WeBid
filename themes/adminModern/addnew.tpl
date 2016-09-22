		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_516}&nbsp;&gt;&gt;&nbsp;{TITLE}</h4>
				<form name="addnew" action="" method="post">
					<table width="98%" cellpadding="2" class="blank">
<!-- BEGIN lang -->
						<tr valign="top">
	<!-- IF lang.S_ROW_COUNT eq 0 -->
							<td align="right">{L_519}:</td>
	<!-- ELSE -->
							<td>&nbsp;</td>
	<!-- ENDIF -->
							<td width="35" align="right"><img src="../images/flags/{lang.LANG}.gif"></td>
							<td><input type="text" name="title[{lang.LANG}]" size="40" maxlength="255" value="{lang.TITLE}"></td>
						</tr>
<!-- END lang -->
<!-- BEGIN lang -->
						<tr>
	<!-- IF lang.S_ROW_COUNT eq 0 -->
							<td valign="top" align="right">{L_520}:</td>
	<!-- ELSE -->
							<td>&nbsp;</td>
	<!-- ENDIF -->
							<td align="right" valign="top"><img src="../images/flags/{lang.LANG}.gif"></td>
							<td>{lang.CONTENT}</td>
						</tr>
<!-- END lang -->
						</tr>
						<tr>
							<td align="right">{L_521}</td>
							<td>&nbsp;</td>
							<td>
								<input type="radio" name="suspended" value="0"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_yes}
								<input type="radio" name="suspended" value="1"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_no}
							</td>
						</tr>
					</table>
<!-- IF ID ne '' -->
					<input type="hidden" name="id" value="{ID}">
<!-- ENDIF -->
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" class="centre" value="{BUTTON}">
				</form>
			</div>
		</div>
