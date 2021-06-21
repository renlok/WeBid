<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumb"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true" style="margin-right:10px;"></span><a href="browse.php?id=0">{L_287}</a> : {CAT_STRING}</ul>
<!-- IF TOP_HTML ne '' -->
		<div class="row">
			<div class="col-md-12">
				<div class="well hidden-xs">
					<table width="98%" border="0" cellspacing="0" cellpadding="4">
						{TOP_HTML}
					</table>
				</div>
				<div class="btn-group visible-xs">
					<button type="button" class="btn btn-default btn-sm btn-block dropdown-toggle" data-toggle="dropdown" data-target="#sub-cats" aria-expanded="false">
						<span class="glyphicon glyphicon-list" aria-hidden="true"></span> {L_276} <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu" style="margin-top:22px; padding: 3px;">
						<table>
							{TOP_HTML}
						</table>
					</ul>
				</div>
			</div>
		</div>
<!-- ENDIF -->
		<br>
<!-- IF NUM_AUCTIONS gt 0 -->
	<!-- IF ID gt 0 -->
		<div class="well well-sm">
			<form name="catsearch" action="?id={ID}" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="row">
					<div class="col-md-7 col-sm-7">
						<input type="text" name="catkeyword" class="form-control" placeholder="{L_30_0070}">
					</div>
					<div class="col-md-5 col-sm-5">
						<input type="submit" name="" value="{L_103}" class="btn btn-default">&nbsp;&nbsp;<a href="{SITEURL}adsearch.php">{L_464}</a>
					</div>
				</div>
			</form>
		</div>
	<!-- ENDIF -->
	<!-- INCLUDE browse.tpl -->
<!-- ELSE -->
		<div class="alert alert-danger" role="alert">
			{L_198}
		</div>
<!-- ENDIF -->
	</div>
</div>