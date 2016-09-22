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
	<script type="text/javascript" src="{SITEURL}ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('a.new-window').click(function(){
				window.open(this.href, this.alt, "toolbar=0,location=0,directories=0,scrollbars=1,screenX=100,screenY=100,status=0,menubar=0,resizable=0,width=550,height=550");
				return false;
			});
			$(".selectall").click(function() {
				var checked_status = this.checked;
				var checkbox_name = this.value;
				$("input[name=\"" + checkbox_name + "[]\"]").each(function() {
					this.checked = checked_status;
				});
			});
		});
	</script>
	<script type="text/javascript">
		function window_open(url,title,width,height,x,y)
		{
			var window_= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+width+',height='+height;
			open(url,title,window_);
		}
	</script>
</head>
<body id="{CURRENT_PAGE}">
	<div class="container">
		<div class="row">
			<div class="col-md-4">&nbsp;</div>
			<div class="col-md-4 well">
<!-- IF PAGE eq 1 -->
				<div class="alert alert-info" role="alert"><b>{L_441}</b></div>
<!-- ELSE -->
				<div class="alert alert-success" role="alert"><b>{L_442}</b></div>
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
				<div class="alert alert-danger" role="alert"><b>{ERROR}</b></div>
<!-- ENDIF -->
				<form action="login.php" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<div class="form-group">
						<label for="username">{L_username}</label>
						<input type="text" name="username" size="20" class="form-control" autofocus>
					</div>
					<div class="form-group">
						<label for="password">{L_password}</label>
						<input type="password" name="password" class="form-control" size="20">
					</div>
<!-- IF PAGE eq 1 -->
					<div class="form-group">
						<label for="repeat_password">{L_005}</label>
						<input type="password" name="repeat_password" class="form-control" size="20">
					</div>
					<div class="text-center">
						<input type="hidden" name="action" value="insert">
						<button class="btn btn-primary" type="submit" name="submit">{L_5204}</button>
					</div>
<!-- ELSE -->
					<div class="text-center">
						<input type="hidden" name="action" value="login">
						<button class="btn btn-primary" type="submit" name="submit">{L_052}</button>
					</div>
<!-- ENDIF -->
				</form>
			</div>
			<div class="col-md-4">&nbsp;</div>
		</div>
