<!DOCTYPE html>
<html dir="{DOCDIR}" lang="{LANGUAGE}">
<head>
<title>{PAGE_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
<meta name="description" content="{DESCRIPTION}">
<meta name="keywords" content="{KEYWORDS}">
<meta name="generator" content="WeBid">

<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/style.css">
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/jquery.lightbox.css" media="screen">
<link rel="stylesheet" type="text/css" href="{SITEURL}includes/calendar.css">

<link rel="alternate" type="application/rss+xml" title="{L_924}" href="{SITEURL}rss.php?feed=1">
<link rel="alternate" type="application/rss+xml" title="{L_925}" href="{SITEURL}rss.php?feed=2">
<link rel="alternate" type="application/rss+xml" title="{L_926}" href="{SITEURL}rss.php?feed=3">
<link rel="alternate" type="application/rss+xml" title="{L_927}" href="{SITEURL}rss.php?feed=4">
<link rel="alternate" type="application/rss+xml" title="{L_928}" href="{SITEURL}rss.php?feed=5">
<link rel="alternate" type="application/rss+xml" title="{L_929}" href="{SITEURL}rss.php?feed=6">
<link rel="alternate" type="application/rss+xml" title="{L_930}" href="{SITEURL}rss.php?feed=7">
<link rel="alternate" type="application/rss+xml" title="{L_931}" href="{SITEURL}rss.php?feed=8">

<script src="{SITEURL}js/jquery.js"></script>
<script>{CAL_CONF}</script>
<script src="{SITEURL}js/calendar.js"></script>

<!-- IF GOOGLEANALYTICS ne '' -->
{GOOGLEANALYTICS}
<!-- ENDIF -->
</head>
<body>
<div class="wrapper rounded-top rounded-bottom">
	<div class="splitbox">
		<div class="leftside">
			<a class="" href="{SITEURL}index.php">
				<img src="{SITEURL}uploaded/logo/{LOGO}" border="0" alt="{SITENAME}">
			</a>
		</div>
		<div class="rightside">
			{BANNER}
		</div>
	</div>
	<div class="counters">
		<span class="leftside"><!-- IF B_LOGGED_IN -->{L_200} {YOURUSERNAME}. <a href="{SITEURL}logout.php?">{L_245}</a><!-- ENDIF --></span>
		<span class="rightside">{HEADERCOUNTER}</span>
	</div>
	<div class="navbar">
		<ul>
			<li><a href="{SITEURL}index.php">{L_166}</a></li>
<!-- IF B_CAN_SELL -->
			<li><a href="{SITEURL}select_category.php">{L_028}</a></li>
<!-- ENDIF -->
<!-- IF B_LOGGED_IN -->
			<li><a href="{SITEURL}user_menu.php">{L_622}</a></li>
			<li><a href="{SITEURL}logout.php">{L_245}</a></li>
<!-- ELSE -->
			<li><a href="{SITEURL}register.php">{L_235}</a></li>
			<li><a href="{SITEURL}user_login.php">{L_052}</a></li>
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
	<div class="container">
