		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h2>{L_5142}&nbsp;&gt;&gt;&nbsp;{L_276}&nbsp;&gt;&gt;&nbsp;{L_078}</h2>
				<form name="newcat" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_845}</div>
							</div>
							<div class="row">
								<div class="col-md-12">{CRUMBS}</div>
							</div>
							<div class="row">
								<div class="col-md-1"><strong>&nbsp;</strong></div>
								<div class="col-md-4"><strong>{L_087}</strong></div>
								<div class="col-md-3"><strong>{L_328}</strong></div>
								<div class="col-md-3"><strong>{L_329}</strong></div>
								<div class="col-md-1"><strong>{L_008}</strong></div>
							</div>
<!-- BEGIN cats -->
							<div class="row">
								<div class="col-md-1 text-right">
									<a href="categories.php?parent={cats.CAT_ID}"><img src="{SITEURL}images/plus.gif" border="0" alt="Browse Subcategories"></a>
								</div>
								<div class="col-md-4"><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.CAT_NAME}" size="50"></div>
								<div class="col-md-3"><input type="text" name="colour[{cats.CAT_ID}]" value="{cats.CAT_COLOUR}" size="25"></div>
								<div class="col-md-3"><input type="text" name="image[{cats.CAT_ID}]" value="{cats.CAT_IMAGE}" size="25"></div>
								<div class="col-md-1">
									<input type="checkbox" name="delete[]" value="{cats.CAT_ID}">
	<!-- IF cats.B_SUBCATS -->
									<img src="{SITEURL}themes/{THEME}/images/bullet_blue.png">
	<!-- ENDIF -->
	<!-- IF cats.B_AUCTIONS -->
									<img src="{SITEURL}themes/{THEME}/images/bullet_red.png">
	<!-- ENDIF -->
								</div>
							</div>
<!-- END cats -->
							<div class="row">
								<div class="col-md-11 text-right">{L_30_0102}</div>
								<div class="col-md-1"><input type="checkbox" class="selectall" value="delete"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-1">&nbsp;</div>
								<div class="col-md-4">{L_394}: <input type="text" name="new_category" size="25"></div>
								<div class="col-md-3"><input type="text" name="cat_colour" size="25"></div>
								<div class="col-md-3"><input type="text" name="cat_image" size="25"></div>
								<div class="col-md-1">&nbsp;</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-5">{L_368}</div>
								<div class="col-md-6"><textarea name="mass_add" cols="35" rows="6"></textarea></div>
							</div>
						</div>
					</div>
					<input type="hidden" name="parent" value="{PARENT}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="action" value="Process">{L_089}</button>
				</form>
			</div>
		</div>