<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administration Interface! |</title>

<!-- Bootstrap core CSS -->

<link href="{SITEURL}themes/{THEME}/css/bootstrap.min.css" rel="stylesheet">
<link href="{SITEURL}themes/{THEME}/fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="{SITEURL}themes/{THEME}/css/animate.min.css" rel="stylesheet">

<!-- Custom styling plus plugins -->
<link href="{SITEURL}themes/{THEME}/css/custom.css" rel="stylesheet">
<link href="{SITEURL}themes/{THEME}/css/icheck/flat/green.css" rel="stylesheet">
<script src="{SITEURL}themes/{THEME}/js/jquery.min.js"></script>

<!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>
<div id="wrapper">
  <div id="login" class="animate form">
    <section class="login_content">
      <form action="login.php" method="post" class="form-horizontal">
           <h1>Administration Interface</h1>
        <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
        <div class="form-group">
        <label class="col-sm-3 control-label">{L_username}: </label>
         <div class="col-sm-9">
        <input type="text" name="username" class="form-control has-feedback-left" placeholder="UserName">
        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>
  </div>
        <div class="form-group">
        <label class="col-sm-3 control-label">{L_password}: </label>
        <div class="col-sm-9">
        <input type="password" name="password" class="form-control has-feedback-left" placeholder="Password">
         <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
        </div></div>
        <!-- IF PAGE eq 1 -->
        
        <input type="hidden" name="action" value="insert">
        <input type="submit" name="submit" value="{L_5204}" class="btn btn-theme btn-block">
        
        <!-- ELSE -->
        
        <input type="hidden" name="action" value="login">
        <input type="submit" name="submit" value="{L_052}" class="btn btn-theme btn-block">
        
        <!-- ENDIF -->
        <div class="clearfix"></div>
        <div class="separator">
              <div>
            <h1><i class="fa fa-circle-o-notch" style="font-size: 26px;"></i> Webid!</h1>
            <p>&copy; 2008 - {L_COPY_YEAR} All Rights Reserved.</p>
          </div>
        </div>
      </form>
      <!-- form --> 
      
    </section>
    <!-- content --> 
  </div>
</div>
<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/jquery.backstretch.min.js"></script> 
<script>
        $.backstretch("{SITEURL}themes/{THEME}/images/login-bg.jpg", {speed: 500});
    </script>
</body>
</html>
