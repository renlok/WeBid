<!DOCTYPE html>
<html dir="{DOCDIR}" lang="{LANGUAGE}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
	<meta name="description" content="{DESCRIPTION}">
	<meta name="keywords" content="{KEYWORDS}">
	<meta name="generator" content="WeBid">
	
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/style.css">
	
	
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
    
	<title>{PAGE_TITLE}</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Architects+Daughter">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
	<link rel="stylesheet" href="{SITEURL}themes/{THEME}/css/styles.min.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/jquery.lightbox.css" media="screen">
	<link rel="stylesheet" type="text/css" href="{SITEURL}includes/calendar.css">
</head>

<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
	<script src="{SITEURL}themes/{THEME}/js/script.min.js"></script>
	<!-- IF GOOGLETRANSLATE -->
		<div id="google_translate_element"></div>

		<script type="text/javascript">
			function googleTranslateElementInit() {
				new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
			}
		</script>

		<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<!-- ENDIF -->
    <div class="container" style="height:85px">
        <nav class="navbar navbar-light navbar-expand-md fixed-top" style="height:100px">
            <div class="container-fluid"><a class="navbar-brand" href="{SITEURL}index.php"><img src="{SITEURL}uploaded/logo/{LOGO}" alt="{SITENAME}"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav d-inline-flex ml-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="{SITEURL}index.php">{L_166}</a></li>
                        <!-- IF B_CAN_SELL -->
				<li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}select_category.php">{L_028}</a></li>
			<!-- ENDIF -->
			<!-- IF B_LOGGED_IN -->
				<li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}user_menu.php">{L_622}</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}logout.php">{L_245}</a></li>
			<!-- ELSE -->
				<li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}register.php">{L_235}</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}user_login.php">{L_052}</a></li>
			<!-- ENDIF -->
			<!-- IF B_BOARDS -->
				<li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}boards.php">{L_5030}</a></li>
			<!-- ENDIF -->
                        <li class="nav-item" role="presentation"><a class="nav-link" href="{SITEURL}help.php">{L_148}</a></li>
                    </ul>
                    <form class="form-inline" action="{SITEURL}search.php" method="get" name="search">
			<select class="form-control">
				{SELECTION_BOX}
			</select>
			<input class="form-control" type="search" name="q" value="{Q}" placeholder="{L_861}">
			<a class="btn btn-primary" role="button" href="{SITEURL}adsearch.php" name="sub" value="{L_399}">{L_464}</a>
		    </form>
            </div>
    </div>
    </nav>
    </div>
    <div class="container">
        <div class="carousel slide" data-ride="carousel" data-interval="10000" data-keyboard="false" id="carousel-1">
            <div class="carousel-inner" role="listbox" style="max-height:250px;">
                <div class="carousel-item active"><img class="w-100 d-block" src="{SITEURL}themes/{THEME}/img/banners/007.hostpapa.300x250.gif" alt="Slide Image" style="max-height:250Px;"></div>
                <div class="carousel-item" style="max-height:250px;"><img class="w-100 d-block" src="{SITEURL}themes/{THEME}/img/banners/05-08-15-09-50-41_300x250-Rectangle.jpg" alt="Slide Image" style="max-height:250px;"></div>
                <div class="carousel-item"><img class="w-100 d-block" src="{SITEURL}themes/{THEME}/img/banners/003_hostpapa_120x600.gif" alt="Slide Image" height="250px" style="height:auto;"></div>
            </div>
            <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-slide="next"><span class="sr-only">Next</span></a></div>
        </div>
    </div>
    
    <div class="container">