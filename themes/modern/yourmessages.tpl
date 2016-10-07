<!-- INCLUDE user_menu_header.tpl -->

<div class="col-md-10 col-md-offset-1">
	<div class="well well-sm">
		<small>{L_332}:</small> <strong>{SUBJECT}</strong><br>
		<small>{L_340}:</small> <strong>{SENDERNAME}</strong> - <small>{SENT}</small><br>
		<br>
		<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {MESSAGE}<br>
	</div>
	<div class="text-center">
		<a class="btn btn-primary" href="{SITEURL}mail.php?reply=1&amp;message={HASH}">{L_349}</a>
		<a class="btn btn-danger" href="{SITEURL}mail.php?deleteid[]={ID}" onClick="if ( !confirm('{L_delete_message_confirm}') ) { return false; }">{L_008}</a>
		<br>
		<br>
		<a class="btn btn-default btn-sm" href="{SITEURL}mail.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> {L_351}</a>
	</div>
</div>

<!-- INCLUDE user_menu_footer.tpl -->
