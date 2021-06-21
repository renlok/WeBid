<!-- INCLUDE user_menu_header.tpl -->

<form action="" method="post" name="thisform" id="thisform">
	<div class="well">
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<div class="alert alert-info" role="alert">{L_25_0195}</div>
		<p><input type="radio" name="startemailmod" value="yes"{B_AUCSETUPY}>{L_25_0196}</p>
		<p><input type="radio" name="startemailmod" value="no"{B_AUCSETUPN}>{L_25_0197}</p>
	</div>
	<div class="well">
		<div class="alert alert-info" role="alert">{L_25_0189}</div>
		<p><input type="radio" name="endemailmod" value="one"{B_CLOSEONE}>{L_25_0190}</p>
		<p><input type="radio" name="endemailmod" value="cum"{B_CLOSEBULK}>{L_25_0191}</p>
		<p><input type="radio" name="endemailmod" value="none"{B_CLOSENONE}>{L_25_0193}</p>
		<p>{L_903}</p>
		<p><input type="radio" name="emailtype" value="text"{B_EMAILTYPET}> {L_915} <input type="radio" name="emailtype" value="html"{B_EMAILTYPEH}> {L_902}</p>
	</div>
	<div class="text-center">
		<input type="hidden" name="action" value="update">
		<input type="submit" name="Submit" value="{L_530}" class="btn btn-primary">
		<br>
		<br>
	</div>
</form>

<!-- INCLUDE user_menu_footer.tpl -->