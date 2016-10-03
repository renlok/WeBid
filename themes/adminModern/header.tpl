<!DOCTYPE html>
<html lang="en">
<head>
	<title>WeBid Administration back-end</title>
	<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="generator" content="WeBid">

	<link rel="stylesheet" media="screen,projection" type="text/css" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}includes/calendar.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/style.css">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="{SITEURL}js/jquery.js"></script>
	<script src="{SITEURL}js/jquery-ui.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>

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
		<div class="row header">
			<div class="col-md-6">{LOGO}</div>
			<div class="col-md-6 hidden-xs text-right">&nbsp;</div>
		</div>
		<div class="row">
			<div class="col-md-6"><small>{L_559}: {LAST_LOGIN}</small></div>
			<div class="col-md-6 text-muted text-right">
<!-- BEGIN langs -->
	<!-- IF ! langs.B_DEFAULT -->
				<a href="index.php?lan={langs.LANG}"><img src="{SITEURL}images/flags/{langs.LANG}.gif"></a>
	<!-- ENDIF -->
<!-- END langs -->
				<small>{L_592} {ADMIN_USER} | <a href="editadminuser.php?id={ADMIN_ID}">{L_5142}</a> | <a href="{SITEURL}" target="_blank">{L_5001}</a> | <a href="logout.php">{L_245}</a><br /></small>
			</div>
		</div>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="headingnavbar">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="headingnavbar">
					<ul class="nav navbar-nav">
						<li><a href="index.php" alt="{L_166}">{L_166}</a></li>
						<li><a href="settings.php" alt="{L_5142}">{L_5142}</a></li>
						<li><a href="fees.php" alt="{L_25_0012}">{L_25_0012}</a></li>
						<li><a href="theme.php" alt="{L_25_0009}">{L_25_0009}</a></li>
						<li><a href="managebanners.php" alt="{L_25_0011}">{L_25_0011}</a></li>
						<li><a href="listusers.php" alt="{L_25_0010}">{L_25_0010}</a></li>
						<li><a href="listauctions.php" alt="{L_239}">{L_239}</a></li>
						<li><a href="news.php" alt="{L_25_0018}">{L_25_0018}</a></li>
						<li><a href="viewaccessstats.php" alt="{L_25_0023}">{L_25_0023}</a></li>
						<li><a href="errorlog.php" alt="{L_5436}">{L_5436}</a></li>
						<li><a href="help.php" alt="{L_148}">{L_148}</a></li>
					</ul>
				</div>
			</div>
		</nav>
<!-- BEGIN alerts -->
		<div id="alerts">
			<div class="alert alert-{alerts.TYPE}">{alerts.MESSAGE}</div>
		</div>
	<!-- END alerts -->