<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en" dir="{DOCDIR}">
<head>
<title>{PAGE_TITLE}</title>
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/style.css">
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
</head>
<body>
<div class="container">
	<div id="logo">
		{LOGO}
	</div>
	<div class="content">
		<div class="tableContent3">
			<div class="titTable2">
				{L_5236}
			</div>
			<div class="padding">
				<form name="faqsindex" action="viewhelp.php" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<select name="cat" onChange="document.faqsindex.submit()">
						<option value="">- {FNAME} -</option>
<!-- BEGIN cats -->
						<option value="{cats.ID}">{cats.CAT}</option>
<!-- END cats -->
					</select>
					<div style="text-align:right">
						<a href="help.php">{L_5243}</a> | <a href="javascript:window.close()">{L_678}</a>
					</div>
				</form>
				<h1>{FNAME}</h1>
				<ul>
<!-- BEGIN faqs -->
					<li><a href="#faq{faqs.ID}">{faqs.Q}</a></li>
<!-- END faqs -->
				</ul>
<!-- BEGIN faqs -->
				<a name="faq{faqs.ID}"></a>
				<h1>{faqs.Q}</h1>
				<p>{faqs.A}</p>
				<p style="text-align:right"><a href="#top">{L_5245}</a></p>
<!-- END faqs -->
			</div>
		</div>
	</div>
</div>
</body>
</html>