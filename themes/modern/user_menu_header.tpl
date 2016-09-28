<div class="row">
	<div class="col-md-3">
		<div class="btn-group btn-group-justified visible-xs visible-sm" role="group" aria-label="...">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					{L_25_0081}
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{SITEURL}user_menu.php?cptab=summary">{L_25_0080}</a></li>
					<li><a href="yourfeedback.php">{L_208}</a></li>
					<li><a href="leave_feedback.php">{L_207}</a></li>
					<li><a href="mail.php">{L_623}</a></li>
					<li><a href="outstanding.php">{L_422}</a></li>
					<li><a href="invoices.php">{L_1057}</a></li>
					<li><a href="selleremails.php">{L_25_0188}</a></li>
					<li><a href="edit_data.php">{L_621}</a></li>
				</ul>
			</div>
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					{L_25_0082}
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
<!-- IF B_CAN_SELL -->
					<li><a href="{SITEURL}select_category.php?">{L_028}</a></li>
					<li><a href="yourauctions_p.php">{L_25_0115}</a></li>
					<li><a href="yourauctions.php">{L_203}</a></li>
					<li><a href="yourauctions_c.php">{L_204}</a></li>
					<li><a href="yourauctions_s.php">{L_2__0056}</a></li>
					<li><a href="yourauctions_sold.php">{L_25_0119}</a></li>
					<li><a href="selling.php">{L_453}</a></li>
<!-- ENDIF -->
				</ul>
			</div>
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					{L_25_0083}
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right" role="menu">
					<li><a href="auction_watch.php">{L_471}</a></li>
					<li><a href="item_watch.php">{L_472}</a></li>
					<li><a href="yourbids.php">{L_620}</a></li>
					<li><a href="buying.php">{L_454}</a></li>
				</ul>
			</div>
		</div>
		<div class="panel panel-default hidden-xs hidden-sm">
			<div class="list-group">
				<a class="list-group-item" href="{SITEURL}user_menu.php?cptab=summary">{L_25_0080}</a>
				<a class="list-group-item disabled" href="{SITEURL}user_menu.php?cptab=account">{L_25_0081}</a>
				<a class="list-group-item" href="yourfeedback.php">{L_208}</a>
				<a class="list-group-item" href="leave_feedback.php">{L_207}</a>
				<a class="list-group-item" href="mail.php">{L_623}</a>
				<a class="list-group-item" href="outstanding.php">{L_422}</a>
				<a class="list-group-item" href="invoices.php">{L_1057}</a>
				<a class="list-group-item disabled" href="#">{L_244}</a>
				<a class="list-group-item" href="selleremails.php">{L_25_0188}</a>
				<a class="list-group-item" href="edit_data.php">{L_621}</a>
<!-- IF B_CAN_SELL -->
				<a class="list-group-item disabled" href="{SITEURL}user_menu.php?cptab=selling">{L_25_0082}</a>
				<a class="list-group-item" href="{SITEURL}select_category.php?">{L_028}</a>
				<a class="list-group-item" href="yourauctions_p.php">{L_25_0115}</a>
				<a class="list-group-item" href="yourauctions.php">{L_203}</a>
				<a class="list-group-item" href="yourauctions_c.php">{L_204}</a>
				<a class="list-group-item" href="yourauctions_s.php">{L_2__0056}</a>
				<a class="list-group-item" href="yourauctions_sold.php">{L_25_0119}</a>
				<a class="list-group-item" href="selling.php">{L_453}</a>
<!-- ENDIF -->
				<a class="list-group-item disabled" href="{SITEURL}user_menu.php?cptab=buying">{L_25_0083}</a>
				<a class="list-group-item" href="auction_watch.php">{L_471}</a>
				<a class="list-group-item" href="item_watch.php">{L_472}</a>
				<a class="list-group-item" href="yourbids.php">{L_620}</a>
				<a class="list-group-item" href="buying.php">{L_454}</a>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<ul class="nav nav-tabs hidden">
			<li role="presentation"><a href="{SITEURL}user_menu.php?cptab=summary">{L_25_0080}</a></li>
			<li role="presentation"><a href="{SITEURL}user_menu.php?cptab=account">{L_25_0081}</a></li>
<!-- IF B_CAN_SELL -->
			<li role="presentation"><a href="{SITEURL}user_menu.php?cptab=selling">{L_25_0082}</a></li>
<!-- ENDIF -->
			<li role="presentation"><a href="{SITEURL}user_menu.php?cptab=buying">{L_25_0083}</a></li>
		</ul>
		<div class="panel panel-primary">
			<div class="panel-heading">
				{L_205}
			</div>
		</div>
<!-- IF B_MENUTITLE -->
		<legend>
			{UCP_TITLE}
		</legend>
<!-- ENDIF -->
<!-- IF B_ISERROR -->
		<div class="alert alert-danger" role="alert">
			{UCP_ERROR}
		</div>
<!-- ENDIF -->