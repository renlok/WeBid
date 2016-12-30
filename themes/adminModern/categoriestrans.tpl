		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_5142}&nbsp;&gt;&gt;&nbsp;{L_276}&nbsp;&gt;&gt;&nbsp;{L_132}</h4>
				<form name="errorlog" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_161}</div>
							</div>
							<div class="row">
								<div class="col-md-12">
<!-- BEGIN langs -->
									<a href="categoriestrans.php?lang={langs.LANG}"><img align="middle" src="{SITEURL}images/flags/{langs.LANG}.gif" border="0"></a>
<!-- END langs -->
								</div>
							</div>
							<div class="row">
								<div class="col-md-6"><strong>{L_771}</strong></div>
								<div class="col-md-6"><strong>{L_772}</strong></div>
							</div>
<!-- BEGIN cats -->
							<div class="row<!-- IF cats.S_ROW_COUNT % 2 == 1 --> bg<!-- ENDIF -->">
								<div class="col-md-6"><input type="text" name="categories_o[]" value="{cats.CAT_NAME}" size="45" disabled></div>
								<div class="col-md-6"><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.TRAN_CAT}" size="45"></div>
							</div>
<!-- END cats -->
						</div>
					</div>
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_089}</button>
				</form>
			</div>
		</div>
