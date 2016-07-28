<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en" dir="{DOCDIR}">
<head>
<title>{PAGE_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/style.css">

</head>
<body>
<div class="container">
	<div class="row grid-margin-top-md">
		<div class="col-md-12">
			{LOGO}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<legend>
				{L_5236}
			</legend>
			<div class="text-right grid-margin-btm-md">
				<a class="btn btn-warning btn-xs" href="help.php">{L_5243}</a> <a class="btn btn-danger btn-xs" href="javascript:window.close()">{L_678}</a>
			</div>
			<div class="well">
				<form name="faqsindex" action="viewhelp.php" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<select class="form-control" name="cat" onChange="document.faqsindex.submit()">
						<option value="">- {FNAME} -</option>
<!-- BEGIN cats -->
						<option value="{cats.ID}">{cats.CAT}</option>
<!-- END cats -->
					</select>
				</form>
			</div>
			<legend>{FNAME}</legend>
			<div class="panel panel-default">
				<div class="list-group">
<!-- BEGIN faqs -->
					<a class="list-group-item" href="#faq{faqs.ID}">{faqs.Q}</a>
<!-- END faqs -->
				</div>
			</div>
<!-- BEGIN faqs -->
			<div class="panel panel-default">
				<a name="faq{faqs.ID}"></a>
				<div class="panel-heading">{faqs.Q}</div>
				<div class="panel-body">{faqs.A}
					<div class="text-right"><a href="#top"><span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"></span></a></div>
				</div>
			</div>
<!-- END faqs -->
		</div>
	</div>
</div>
</body>
</html>