<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en" dir="{DOCDIR}">
<head>
<title>{PAGE_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
<meta name="description" content="{DESCRIPTION}">
<meta name="keywords" content="{KEYWORDS}">
<meta name="generator" content="WeBid">

<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/style.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/jquery.lightbox.css" media="screen">

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
<div class="wrapper rounded-top rounded-bottom">
	<div class="splitbox">
    	<div class="leftside">
        	{LOGO}
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
        <table cellspacing="0">
            <tbody>
            <tr>
                <td><a href="{SITEURL}index.php?">{L_166}</a></td>
<!-- IF B_CAN_SELL -->
				<td><a href="{SITEURL}select_category.php?">{L_028}</a></td>
<!-- ENDIF -->
<!-- IF B_LOGGED_IN -->
                <td><a href="{SITEURL}user_menu.php?">{L_622}</a></td>
                <td><a href="{SSLURL}logout.php?">{L_245}</a></td>
<!-- ELSE -->
                <td><a href="{SSLURL}register.php?">{L_235}</a></td>
                <td><a href="{SSLURL}user_login.php?">{L_052}</a></td>
<!-- ENDIF -->
<!-- IF B_BOARDS -->
				<td><a href="{SITEURL}boards.php">{L_5030}</a></td>
<!-- ENDIF -->
                <td id="last"><a href="{SITEURL}faqs.php" alt="faqs" class="new-window">{L_148}</a></td>
            </tr>
            </tbody>
        </table>
    </div>
	<div class="splitbox barSec">
    	<div class="leftside">
            <form name="search" action="{SITEURL}search.php" method="get">
            <div class="barSearch">
                <input type="hidden" name="">
                {L_103}
                <input type="text" name="q" size=15 value="{Q}">
                <input type="submit" name="" value="{L_275}" class="button">
                &nbsp;&nbsp;<a href="{SITEURL}adsearch.php">{L_464}</a> 
            </div>
            </form>
		</div>
    	<div class="rightside">
            <form name="gobrowse" action="{SITEURL}browse.php" method="get">
            <div class="barBrowse">
                {L_104}
                {SELECTION_BOX}
                <input type="submit" name="sub" value="{L_275}" class="button">
            </div>
            </form>
		</div>
    </div>