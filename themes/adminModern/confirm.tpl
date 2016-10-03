<!DOCTYPE html>
<html lang="en">
<head>
	<title>WeBid Administration back-end</title>
	<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="generator" content="WeBid">

	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/style.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/jquery.lightbox.css" media="screen">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>

	<script src="{SITEURL}js/jquery.js"></script>
</head>
<body id="{CURRENT_PAGE}">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-4">&nbsp;</div>
			<div class="col-md-4 well">
<!-- IF ERROR ne '' -->
				<div class="alert alert-danger" role="alert"><b>{ERROR}</b></div>
<!-- ENDIF -->
				<form action="" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<div class="row">
						<div class="col-md-12">{MESSAGE}</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12 text-center">
<!-- IF TYPE eq 1 -->
							<input type="hidden" name="id" value="{ID}">
							<button class="btn btn-primary" type="submit" name="action" value="Yes">{L_yes}</button>
							<button class="btn btn-primary" type="submit" name="action" value="No">{L_no}</button>
<!-- ELSEIF TYPE eq 2 -->
							<input type="hidden" name="id" value="{ID}">
							<input type="hidden" name="user" value="{USERID}">
							<button class="btn btn-primary" type="submit" name="action" value="Yes">{L_yes}</button>
							<button class="btn btn-primary" type="submit" name="action" value="No">{L_no}</button>
<!-- ENDIF -->
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-4">&nbsp;</div>
		</div>