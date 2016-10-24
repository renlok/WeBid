		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_clear_image_cache}</h4>
				<form name="errorlog" action="" method="post">
					{L_clear_image_cache_explain}
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_clear_image_cache}">
				</form>
			</div>
		</div>