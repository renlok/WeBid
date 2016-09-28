<!-- INCLUDE user_menu_header.tpl -->

<!-- IF USER_MESSAGE ne '' -->
<div class="success-box">{USER_MESSAGE}</div>
<!-- ENDIF -->
<!-- BEGIN items -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" <!-- IF items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
				<a href="{SITEURL}item.php?id={items.ID}">{items.TITLE}</a>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-4">
						<a href="{SITEURL}item.php?id={items.ID}"><img class="img-rounded img-responsive" style="width: 100%;" src="{items.IMAGE}" border="0"></a>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-8">
	<!-- IF B_SUBTITLE && items.SUBTITLE ne '' -->
						<span class="text-muted">{items.SUBTITLE}</span><br>
	<!-- ENDIF -->
						<small><span class="text-muted">{L_949} {items.CLOSES}</span></small>
						<div class="text-right">
	<!-- IF items.BUY_NOW neq '' -->
							<span class="buy-now-feat">{items.BUY_NOW}</span><br>
	<!-- ENDIF -->
							<span class="bigfont">{items.BIDFORM}</span><br>
							<span class="label label-success">{items.NUMBIDS}</span>
						</div>
						<div class="text-right grid-margin-top-sm">
							<a class="btn btn-danger btn-xs" href="item_watch.php?delete={items.ID}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {L_008}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- BEGINELSE -->
{L_853}
<!-- END items -->

<!-- INCLUDE user_menu_footer.tpl -->
