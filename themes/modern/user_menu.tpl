<!-- INCLUDE user_menu_header.tpl -->
<div class="list-group">
<!-- IF THISPAGE eq 'account' -->
	<a class="list-group-item" href="yourfeedback.php">{L_208}</a>
	<a class="list-group-item" href="leave_feedback.php">{L_207}{FBTOLEAVE}</a>
	<a class="list-group-item" href="mail.php">{L_623}{NEWMESSAGES}</a>
	<a class="list-group-item" href="outstanding.php">{L_422}</a>
	<a class="list-group-item" href="invoices.php">{L_1057}</a>
	<a href="#" class="list-group-item disabled">{L_244}</a>
	<a class="list-group-item" href="selleremails.php">{L_25_0188}</a>
	<a class="list-group-item" href="edit_data.php">{L_621}</a>
<!-- ELSEIF THISPAGE eq 'selling' -->
	<!-- IF B_CANSELL -->
	<a class="list-group-item" href="yourauctions_p.php">{L_25_0115}</a>
	<a class="list-group-item" href="yourauctions.php">{L_203}</a>
	<a class="list-group-item" href="yourauctions_c.php">{L_204}</a>
	<a class="list-group-item" href="yourauctions_s.php">{L_2__0056}</a>
	<a class="list-group-item" href="yourauctions_sold.php">{L_25_0119}</a>
	<a class="list-group-item" href="selling.php">{L_453}</a>
	<!-- ENDIF -->
<!-- ELSEIF THISPAGE eq 'summary' -->
	<div class="panel panel-success">
		<div class="panel-heading">{L_593}</div>
		<div class="panel-body">
			{FBTOLEAVE}
			{NEWMESSAGES}
			{NO_REMINDERS}
			{TO_PAY}
			{BENDING_SOON}
			{BOUTBID}
			{SOLD_ITEMS}
		</div>
	</div>
	<!-- IF TMPMSG ne '' -->
	<div class="alert alert-danger" role="alert">
		{TMPMSG}
	</div>
	<!-- ENDIF -->
	<!-- IF B_CANSELL -->
	<div class="jumbotron text-center">
		<span style="font-size:5.0em;" class="glyphicon glyphicon-tag grid-margin-btm-lg" aria-hidden="true"></span>
		<a class="btn btn-primary btn-lg btn-block" href="{SITEURL}select_category.php?">{L_028}</a>
	</div>
	<!-- ELSEIF B_CANREQUESTSELL -->
	<form name="request" action="" method="post">
		<div class="alert alert-info" role="alert">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<p>{L_25_0140}</p>
			<p><input type="submit" name="requesttoadmin" value="{L_25_0141}"  class="btn btn-primary"></p>
		</div>
	</form>
	<!-- ENDIF -->
<!-- ELSE -->
	<a class="list-group-item" href="auction_watch.php">{L_471}</a>
	<a class="list-group-item" href="item_watch.php">{L_472}</a>
	<a class="list-group-item" href="yourbids.php">{L_620}</a>
	<a class="list-group-item" href="buying.php">{L_454}</a>
<!-- ENDIF -->
</div>

<!-- INCLUDE user_menu_footer.tpl -->
