		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_276}&nbsp;&gt;&gt;&nbsp;{L_132}</h4>
				<form name="errorlog" action="" method="post">
					<div class="plain-box">
						<p>{L_161}</p>
<!-- BEGIN langs -->
						<a href="categoriestrans.php?lang={langs.LANG}"><img align="middle" src="{SITEURL}images/flags/{langs.LANG}.gif" border="0"></a>
<!-- END langs -->
					</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
					<tr>
						<th><b>{L_771}</b></th>
						<th><b>{L_772}</b></th>
					</tr>
<!-- BEGIN cats -->
					<tr<!-- IF cats.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
						<td><input type="text" name="categories_o[]" value="{cats.CAT_NAME}" size="45" disabled></td>
						<td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.TRAN_CAT}" size="45"></td>
					</tr>
<!-- END cats -->
					</table>
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>
