<!DOCTYPE html>
<html dir="{DOCDIR}" lang="{LANGUAGE}">
<head>
<title>{PAGE_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
<meta name="description" content="{DESCRIPTION}">
<meta name="keywords" content="{KEYWORDS}">
<meta name="generator" content="WeBid">

<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/style.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/jquery.lightbox.css" media="screen">
<link rel="stylesheet" type="text/css" href="{INCURL}includes/calendar.css">

<link rel="alternate" type="application/rss+xml" title="{L_924}" href="{SITEURL}rss.php?feed=1">
<link rel="alternate" type="application/rss+xml" title="{L_925}" href="{SITEURL}rss.php?feed=2">
<link rel="alternate" type="application/rss+xml" title="{L_926}" href="{SITEURL}rss.php?feed=3">
<link rel="alternate" type="application/rss+xml" title="{L_927}" href="{SITEURL}rss.php?feed=4">
<link rel="alternate" type="application/rss+xml" title="{L_928}" href="{SITEURL}rss.php?feed=5">
<link rel="alternate" type="application/rss+xml" title="{L_929}" href="{SITEURL}rss.php?feed=6">
<link rel="alternate" type="application/rss+xml" title="{L_930}" href="{SITEURL}rss.php?feed=7">
<link rel="alternate" type="application/rss+xml" title="{L_931}" href="{SITEURL}rss.php?feed=8">

<script type="text/javascript" src="{INCURL}loader.php?js={JSFILES}"></script>
<!-- IF LOADCKEDITOR -->
	<script type="text/javascript" src="{INCURL}ckeditor/ckeditor.js"></script>
<!-- ENDIF -->

<!-- IF GOOGLEANALYTICS ne '' -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', '{GOOGLEANALYTICS}', 'auto');
	ga('send', 'pageview');
</script>
<!-- ENDIF -->

<script type="text/javascript">
	$(document).ready(function() {
		$('a.new-window').click(function(){
			var posY = ($(window).height()-550)/2;
			var posX = ($(window).width())/2;
			window.open(this.href, this.alt, "toolbar=0,location=0,directories=0,scrollbars=1,screenX="+posX+",screenY="+posY+",status=0,menubar=0,width=550,height=550");
			return false;
		});
		var currenttime = '{ACTUALDATE}';
		var serverdate = new Date(currenttime);
		function padlength(what){
			var output=(what.toString().length==1)? "0"+what : what;
			return output;
		}
		function displaytime(){
			serverdate.setSeconds(serverdate.getSeconds()+1)
			var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds());
			$("#servertime").html(timestring);
		}
		setInterval(displaytime, 1000);
	});
</script>
</head>
<body>
<div class="wrapper rounded-top rounded-bottom">
	<div class="splitbox">
		<div class="leftside">
			<a class="" href="{SITEURL}index.php">{LOGO}</a>
		</div>
		<div class="rightside">
			{BANNER}
		</div>
	</div>
	<div class="counters">
		<span class="leftside"><!-- IF B_LOGGED_IN -->{L_200} {YOURUSERNAME}. <a href="{SSLURL}logout.php?">{L_245}</a><!-- ENDIF --></span>
		<span class="rightside">{HEADERCOUNTER}</span>
	</div>
	<div class="navbar">
		<ul>
			<li><a href="{SITEURL}index.php?">{L_166}</a></li>
<!-- IF B_CAN_SELL -->
			<li><a href="{SITEURL}select_category.php?">{L_028}</a></li>
<!-- ENDIF -->
<!-- IF B_LOGGED_IN -->
			<li><a href="{SITEURL}user_menu.php?">{L_622}</a></li>
			<li><a href="{SSLURL}logout.php?">{L_245}</a></li>
<!-- ELSE -->
			<li><a href="{SSLURL}register.php?">{L_235}</a></li>
			<li><a href="{SSLURL}user_login.php?">{L_052}</a></li>
<!-- ENDIF -->
<!-- IF B_BOARDS -->
			<li><a href="{SITEURL}boards.php">{L_5030}</a></li>
<!-- ENDIF -->
			<li><a href="{SITEURL}help.php" alt="faqs" class="new-window">{L_148}</a></li>
		</ul>
	</div>
	<div class="navbar">
		<div>
			<form name="search" action="{SITEURL}search.php" method="get">
				<select class="" name="id">
					{SELECTION_BOX}
				</select>
				<input type="search" name="q" size="50" value="{Q}" placeholder="{L_861}">
				<input type="submit" name="sub" value="{L_399}" class="button">
				<a href="{SITEURL}adsearch.php">{L_464}</a>
			</form>
		</div>
	</div>