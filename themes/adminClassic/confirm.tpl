<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}/themes/{THEME}/style.css" />
</head>
<body style="margin:0;">
<div style="width:400px; padding:40px;" class="centre">
	<div class="plain-box" style="text-align:center; padding: 10px; font-size: 1.4em;">
	<form action="" method="post">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<p>{MESSAGE}</p>
		<div class="break">&nbsp;</div>
<!-- IF TYPE eq 1 -->
		<input type="hidden" name="id" value="{ID}">
		<button type="submit" name="action" value="Yes">{L_030}</button>
		<button type="submit" name="action" value="No">{L_029}</button>
<!-- ELSEIF TYPE eq 2 -->
		<input type="hidden" name="id" value="{ID}">
		<input type="hidden" name="user" value="{USERID}">
		<button type="submit" name="action" value="Yes">{L_030}</button>
		<button type="submit" name="action" value="No">{L_029}</button>
<!-- ENDIF -->
	</form>
	</div>
</div>
<div>