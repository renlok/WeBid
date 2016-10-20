<!DOCTYPE html>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin panel! |</title>

    <!-- Bootstrap core CSS -->

    <link href="{SITEURL}themes/{THEME}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{SITEURL}themes/{THEME}/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="{SITEURL}themes/{THEME}/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="{SITEURL}themes/{THEME}/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="{SITEURL}themes/{THEME}/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="{SITEURL}themes/{THEME}/css/floatexamples.css" rel="stylesheet" type="text/css" />
    <link href="{SITEURL}themes/{THEME}/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <script src="{SITEURL}themes/{THEME}/js/jquery.min.js"></script>
    <script src="{SITEURL}themes/{THEME}/js/nprogress.js"></script>
    <script>
        NProgress.start();
    </script>
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

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    
<body class="nav-md">    
<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;"> <a href="index.php" class="site_title"><i class="fa fa-circle-o-notch"></i> <span>Admin Panel!</span></a> </div>
        <div class="clearfix"></div>
        
        <!-- menu prile quick info -->
        <div class="profile">
          <div class="profile_pic"> <img src="{SITEURL}themes/{THEME}/images/user.png" class="img-circle profile_img"> </div>
          <div class="profile_info"> <span>Welcome</span>
            <h2>{ADMIN_USER}</h2>
          </div>
        </div>
        <!-- /menu prile quick info --> 
        
        <br />
        
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <h3>{L_166}</h3>
            <ul class="nav side-menu">
              <li> <a href="index.php"><i class="fa fa-home"></i> Dashboard </a> </li>
              <li><a><i class="fa fa-edit"></i> {L_5142} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li> <a href="{SITEURL}admin/settings.php">{L_526}</a></li>
                  <li><a href="{SITEURL}admin/auctions.php">{L_auction_settings}</a></li>
                  <li><a href="{SITEURL}admin/displaysettings.php">{L_788}</a></li>
                  <li><a href="{SITEURL}admin/spam.php">{L_749}</a></li>
                  <li><a href="{SITEURL}admin/emailsettings.php">{L_1118}</a></li>
                  <li><a href="{SITEURL}admin/usersettings.php">{L_894}</a></li>
                  <li><a href="{SITEURL}admin/errorhandling.php">{L_409}</a></li>
                  <li><a href="{SITEURL}admin/moderation.php">{L_moderation_settings}</a></li>
                  <li><a href="{SITEURL}admin/countries.php">{L_081}</a></li>
                  <li><a href="{SITEURL}admin/payments.php">{L_075}</a></li>
                  <li><a href="{SITEURL}admin/durations.php">{L_069}</a></li>
                  <li><a href="{SITEURL}admin/increments.php">{L_128}</a></li>
                  <li><a href="{SITEURL}admin/membertypes.php">{L_25_0169}</a></li>
                  <li><a href="{SITEURL}admin/categories.php">{L_078}</a></li>
                  <li><a href="{SITEURL}admin/categoriestrans.php">{L_132}</a></li>
                  <li><a href="{SITEURL}admin/currency.php">{L_5004}</a></li>
                  <li><a href="{SITEURL}admin/time.php">{L_344}</a></li>
                  <li><a href="{SITEURL}admin/buyitnow.php">{L_2__0025}</a></li>
                  <li><a href="{SITEURL}admin/defaultcountry.php">{L_5322}</a></li>
                  <li><a href="{SITEURL}admin/counters.php">{L_2__0057}</a></li>
                  <li><a href="{SITEURL}admin/multilingual.php">{L_2__0002}</a></li>
                  <li><a href="{SITEURL}admin/catsorting.php">{L_25_0146}</a></li>
                  <li><a href="{SITEURL}admin/metatags.php">{L_25_0178}</a></li>
                  <li><a href="{SITEURL}admin/contactseller.php">{L_25_0216}</a></li>
                  <li><a href="{SITEURL}admin/buyerprivacy.php">{L_bidder_privacy}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-desktop"></i> {L_25_0012} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
              <li><a href="{SITEURL}admin/fees.php">{L_25_0012}</a></li>
              <li><a href="{SITEURL}admin/fee_gateways.php">{L_445}</a></li>
              <li><a href="{SITEURL}admin/enablefees.php">{L_395}</a></li>
              <li><a href="{SITEURL}admin/accounts.php">{L_854}</a></li>
              <li><a href="{SITEURL}admin/invoice_settings.php">{L_1094}</a></li>
              <li><a href="{SITEURL}admin/invoice.php">{L_766}</a></li>
              <li><a href="{SITEURL}admin/tax.php">{L_1088}</a></li>
              <li><a href="{SITEURL}admin/tax_levels.php">{L_1083}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-table"></i> {L_25_0009} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/theme.php">{L_26_0002}</a></li>
                  <li><a href="{SITEURL}admin/clearcache.php">{L_30_0031}</a></li>
                  <li><a href="{SITEURL}admin/clear_image_cache.php">{L_30_0031a}</a></li>
                  <li><a href="{SITEURL}admin/logo_upload.php">{L_30_0215}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-bar-chart-o"></i> {L_25_0011} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/banners.php">{L_5205}</a></li>
                  <li><a href="{SITEURL}admin/managebanners.php">{L_banner_admin}</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="menu_section">
            <ul class="nav side-menu">
              <li><a><i class="fa fa-users"></i> {L_25_0010} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/listusers.php">{L_045}</a></li>
                  <li><a href="{SITEURL}admin/newuser.php">{L__0026}</a></li>
                  <li><a href="{SITEURL}admin/usergroups.php">{L_448}</a></li>
                  <li><a href="{SITEURL}admin/profile.php">{L_048}</a></li>
                  <li><a href="{SITEURL}admin/activatenewsletter.php">{L_25_0079}</a></li>
                  <li><a href="{SITEURL}admin/newsletter.php">{L_607}</a></li>
                  <li><a href="{SITEURL}admin/banips.php">{L_ip_addresses}</a></li>
                  <li><a href="{SITEURL}admin/newadminuser.php">{L_367}</a></li>
                  <li><a href="{SITEURL}admin/adminusers.php">{L_525}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-gavel"></i> {L_239} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/listauctions.php">{L_067}</a></li>
                  <li><a href="{SITEURL}admin/listclosedauctions.php">{L_214}</a></li>
                  <li><a href="{SITEURL}admin/listreportedauctions.php">{L_view_reported_auctions}</a></li>
                  <li><a href="{SITEURL}admin/listsuspendedauctions.php">{L_5227}</a></li>
                  <li><a href="{SITEURL}admin/searchauctions.php">{L_067a}</a></li>
                  <li> <a href="{SITEURL}admin/moderateauctions.php">{L_moderation_queue}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-bookmark"></i> {L_25_0018} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/news.php">{L_516}</a></li>
                  <li><a href="{SITEURL}admin/aboutus.php">{L_about_us_page}</a></li>
                  <li><a href="{SITEURL}admin/help.php">{L_148}</a></li>
                  <li><a href="{SITEURL}admin/terms.php">{L_5075}</a></li>
                  <li><a href="{SITEURL}admin/privacypolicy.php">{L_402}</a></li>
                  <li><a href="{SITEURL}admin/cookiespolicy.php">{L_1110}</a></li>
                  <li><a href="{SITEURL}admin/faqscategories.php">{L_5230}</a></li>
                  <li><a href="{SITEURL}admin/newfaq.php">{L_5231}</a></li>
                  <li><a href="{SITEURL}admin/faqs.php">{L_5232}</a></li>
                  <li><a href="{SITEURL}admin/boardsettings.php">{L_msg_board_settings}</a></li>
                  <li><a href="{SITEURL}admin/newboard.php">{L_5031}</a></li>
                  <li><a href="{SITEURL}admin/boards.php">{L_board_management}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-cogs"></i> {L_5436} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/checkversion.php">{L_25_0169a}</a></li>
                  <li><a href="{SITEURL}admin/maintainance.php">{L__0001}</a></li>
                  <li><a href="{SITEURL}admin/wordsfilter.php">{L_5068}</a></li>
                  <li><a href="{SITEURL}admin/errorlog.php">{L_891}</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-bar-chart"></i> {L_25_0023} <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{SITEURL}admin/stats_settings.php">{L_5142}</a></li>
                  <li><a href="{SITEURL}admin/viewaccessstats.php">{L_5143}</a></li>
                  <li><a href="{SITEURL}admin/viewbrowserstats.php">{L_5165}</a></li>
                  <li><a href="{SITEURL}admin/viewplatformstats.php">{L_5318}</a></li>
                  <li><a href="{SITEURL}admin/analytics.php">{L_analytics}</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!-- /sidebar menu -->  
      </div>
    </div>
    
    <!-- top navigation -->
    <div class="top_nav">
      <div class="nav_menu">
        <nav class="" role="navigation">
          <div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
          <ul class="nav navbar-nav navbar-right">
            <li class=""> <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <img src="{SITEURL}themes/{THEME}/images/user.png" alt="">{ADMIN_USER} <span class=" fa fa-angle-down"></span> </a>
              <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a> </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- /top navigation --> 
      <!-- page content -->
    <div class="right_col" role="main"> 
