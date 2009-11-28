<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en" dir="{DOCDIR}">
<head>
<title>{PAGE_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
<meta name="description" content="{DESCRIPTION}">
<meta name="keywords" content="{KEYWORDS}">
<meta name="generator" content="WeBid">
{STYLES}
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/style.css">
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/jquery.lightbox.css" media="screen">

<link rel="alternate" type="application/rss+xml" title="{L_924}" href="{SITEURL}rss.php?feed=1">
<link rel="alternate" type="application/rss+xml" title="{L_925}" href="{SITEURL}rss.php?feed=2">
<link rel="alternate" type="application/rss+xml" title="{L_926}" href="{SITEURL}rss.php?feed=3">
<link rel="alternate" type="application/rss+xml" title="{L_927}" href="{SITEURL}rss.php?feed=4">
<link rel="alternate" type="application/rss+xml" title="{L_928}" href="{SITEURL}rss.php?feed=5">
<link rel="alternate" type="application/rss+xml" title="{L_929}" href="{SITEURL}rss.php?feed=6">
<link rel="alternate" type="application/rss+xml" title="{L_930}" href="{SITEURL}rss.php?feed=7">
<link rel="alternate" type="application/rss+xml" title="{L_931}" href="{SITEURL}rss.php?feed=8">

<script type="text/javascript" src="{SITEURL}js/jquery.js"></script>
<script type="text/javascript" src="{SITEURL}js/jquery.dimensions.js"></script>
<script type="text/javascript" src="{SITEURL}js/jquery.lightbox.js"></script>

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
{EXTRAINC}
</head>
<body>
<div align="{PAGEALIGN}">
<table width="{PAGEWIDTH}" cellpadding="0" cellspacing="0" border="0" class="container" style="text-align:left;"> 
  <tr> 
  <td>
	<table width="100%" border="0" cellpadding="5" cellspacing="5" class="logo">
	<tbody>
	  <tr>
		<td width="50%">
		  {LOGO}
		</td><td width="50%">
		  {BANNER}
		</td>
	  </tr>
	</tbody>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="5" class="counters">
	  <tr>
		<td>
		  <span class="leftside"><!-- IF B_LOGGED_IN -->{L_200} {YOURUSERNAME}. <a href="{SSLURL}logout.php?">{L_245}</a><!-- ENDIF --></span>
		  <span class="rightside">{HEADERCOUNTER}</span>
		</td>
	  </tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="3" class="navbar">
	  <tr>
		<td>
		  <table cellspacing="0" class="table-bar">
		  <tbody>
			<tr>
			  <td><a href="{SITEURL}index.php?">{L_166}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
				<!-- IF B_CAN_SELL -->
			  <td><a href="{SITEURL}select_category.php?">{L_028}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
				<!-- ENDIF -->
				<!-- IF B_LOGGED_IN -->
			  <td><a href="{SITEURL}user_menu.php?">{L_622}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
			  <td><a href="{SSLURL}logout.php?">{L_245}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
				<!-- ELSE -->
			  <td><a href="{SSLURL}register.php?">{L_235}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
			  <td><a href="{SSLURL}user_login.php?">{L_052}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
				<!-- ENDIF -->
				<!-- IF B_BOARDS -->
			  <td><a href="{SITEURL}boards.php">{L_5030}</a><div class="imgSep"><img src="{SITEURL}images/transparent.gif" width="8" height="8" alt="spacer"></div></td>
				<!-- ENDIF -->
			  <td><a href="{SITEURL}faqs.php" alt="faqs" class="new-window">{L_148}</a></td>
			</tr>
		  </tbody>
		  </table>
		</td>
	  </tr>
	</table>
	<table border="0" class="barSec" style="height:37; width:100%;">
	  <tr>
		<td width="50%">
		  <form name="search" action="{SITEURL}search.php" method="GET">
		  <div class="barSearch">
		  <input type="hidden" name="">
		  {L_103}
		  <input type="text" name="q" size=15 value="{Q}">
		  <input type="submit" name="" value="{L_275}" class="button">
		  &nbsp;&nbsp;<a href="{SITEURL}adsearch.php">{L_464}</a> 
		  </div>
		  </form>
		</td>
		<td width="50%" align="right">
		  <form name="gobrowse" action="{SITEURL}browse.php" method="GET">
		  <div class="barBrowse">
		  {L_104}
		  {SELECTION_BOX}
		  <input type="submit" name="sub" value="{L_275}" class="button">
		  </div>
		  </form>
		</td>
	  </tr>
	</table>