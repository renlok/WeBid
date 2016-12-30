		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="container">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5236}&nbsp;&gt;&gt;&nbsp;{L_5230}&nbsp;&gt;&gt;&nbsp;{FAQ_NAME}</h4>
				<form name="errorlog" action="" method="post">
					<table class="table table-striped table-bordered">
<!-- BEGIN flangs -->
					<tr>
	<!-- IF flangs.S_ROW_COUNT eq 0 -->
						<td width="20%">{L_5284}</td>
	<!-- ELSE -->
						<td>&nbsp;</td>
	<!-- ENDIF -->
						<td width="5%"><img src="{SITEURL}images/flags/{flangs.LANGUAGE}.gif"></td>
						<td width="75%" valign="top">
							<input type="text" name="category[{flangs.LANGUAGE}]" size="50" maxlength="150" value="{flangs.TRANSLATION}">
						</td>
					</tr>
<!-- END langs -->
					</table>
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
