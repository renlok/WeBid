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
<link rel="stylesheet" type="text/css" href="{INCURL}inc/calendar.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/css/metro.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/css/metro-icons.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/css/metro-responsive.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/css/metro-schemes.css">


<link rel="alternate" type="application/rss+xml" title="{L_924}" href="{SITEURL}rss.php?feed=1">
<link rel="alternate" type="application/rss+xml" title="{L_925}" href="{SITEURL}rss.php?feed=2">
<link rel="alternate" type="application/rss+xml" title="{L_926}" href="{SITEURL}rss.php?feed=3">
<link rel="alternate" type="application/rss+xml" title="{L_927}" href="{SITEURL}rss.php?feed=4">
<link rel="alternate" type="application/rss+xml" title="{L_928}" href="{SITEURL}rss.php?feed=5">
<link rel="alternate" type="application/rss+xml" title="{L_929}" href="{SITEURL}rss.php?feed=6">
<link rel="alternate" type="application/rss+xml" title="{L_930}" href="{SITEURL}rss.php?feed=7">
<link rel="alternate" type="application/rss+xml" title="{L_931}" href="{SITEURL}rss.php?feed=8">

<script type="text/javascript" src="{INCURL}loader.php?js={JSFILES}"></script>
<script type="text/javascript" src="{INCURL}/js/jquery.js"></script>
<script type="text/javascript" src="{INCURL}themes/{THEME}/js/metro.js"></script>


<!-- IF LOADCKEDITOR -->
	<script type="text/javascript" src="{INCURL}ckeditor/ckeditor.js"></script>
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
	$(function() {
		$('#gallery a').lightBox();
	});
});
</script>
</head>
<body>
<div class="wrapper">
	<div class=" bg-blue" style="padding-left: 10px; margin-bottom: 10px;">
        	{LOGO}
    </div>
    <div class="app-bar bg-grayDarker" style="margin-bottom:10px;">
            <a href="{SITEURL}index.php?"  class="app-bar-element">{L_166}</a>
<!-- IF B_CAN_SELL -->
		<a href="{SITEURL}select_category.php?"  class="app-bar-element">{L_028}</a>
<!-- ENDIF -->
<!-- IF B_LOGGED_IN -->
            <a href="{SITEURL}user_menu.php?" class="app-bar-element">{L_622}</a>
            <a href="{SSLURL}logout.php?" class="app-bar-element">{L_245}</a>
<!-- ELSE -->
            <a href="{SSLURL}register.php?" class="app-bar-element">{L_235}</a>
            <a href="{SSLURL}user_login.php?" class="app-bar-element">{L_052}</a>
<!-- ENDIF -->
<!-- IF B_BOARDS -->
	    <a href="{SITEURL}boards.php" class="app-bar-element">{L_5030}</a>
<!-- ENDIF -->
            <a href="{SITEURL}help.php" alt="faqs" class="app-bar-element">{L_148}</a>
    </div>


	<div class="app-bar bg-grayDarker" style="margin-bottom: 10px;" >
		<form name="search" action="{SITEURL}search.php" method="get" style="padding-left: 20px;">
			<select class="input-control"> {SELECTION_BOX} </select>
				<div class="input-control text" data-role="input">
					<input type="text" name="q" size="100">
					<button class="button"><span class="mif-search" type="submit"></span></button>
				</div>&nbsp;&nbsp;<a href="{SITEURL}adsearch.php" style="color:#ffffff;">{L_464}</a>



        </form>
	</div>
