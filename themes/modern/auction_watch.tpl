<!-- INCLUDE user_menu_header.tpl -->
<div class="row">
	<form action="auction_watch.php?insert=true" method="post">
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<div class="col-lg-6">
			<div class="input-group">
				<input type="text" class="form-control" name="add" placeholder="{L_25_0084}">
				<span class="input-group-btn"><input type="submit" value="{L_5204}" class="btn btn-default"></span>
			</div>
		</div>
	</form>
</div>
<div class="grid-margin-top-lg grid-margin-btm-lg">
<!-- BEGIN items -->
	<a class="btn btn-primary btn-xs" href="{SITEURL}auction_watch.php?delete={items.ITEMENCODE}">
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		{items.ITEM}
	</a>
<!-- END items -->
</div>
<div class="alert alert-warning" role="alert">{L_30_0210}</div>

<!-- INCLUDE user_menu_footer.tpl -->