<html>
<head>
<title>{SITENAME}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{INCURL}themes/{THEME}/css/style.css">
<script type="text/javascript" src="{SITEURL}js/jquery.js"></script>
<script type="text/javascript" src="{SITEURL}js/google_converter.js"></script>
</head>
<body>
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well grid-margin-top-md">
                     <legend>{L_085}</legend>
			<form name="form1" method="post" action="">
            	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                          <div class="alert alert-info" role="alert" id="results">{CONVERSION}</div>
                             <div class="col-lg-8 col-lg-offset-2">
                                <div class="form-group">
				{L_082}
                                <input type="text" name="amount" id="amount" class="form-control" value="{AMOUNT}">
                                </div><br>
                                <div class="form-group">
                                {L_083}
                                <select name="fromCurrency" id="fromCurrency" class="form-control">
<!-- BEGIN from -->
								<option value="{from.VALUE}"<!-- IF from.B_SELECTED --> selected="true"<!-- ENDIF -->>{from.VALUE} {from.NAME}</option>
<!-- END from -->
				</select>
                                </div><br>
                                <div class="form-group">
                                {L_088}
                                <select name="toCurrency" class="form-control" id="toCurrency">
<!-- BEGIN to -->
								<option value="{to.VALUE}"<!-- IF to.B_SELECTED --> selected="true"<!-- ENDIF -->>{to.VALUE} {to.NAME}</option>
<!-- END to -->
				</select>
		           </div>
                            </div><br>	
				<div style="text-align:center">
                	<input class="btn btn-primary" type="button" name="convert" id="convert" value="{L_25_0176}">
				</div>
			</form>
		</div>
		<div style="text-align:center">
			<input class="btn btn-danger btn-xs" type="button" value="Close" onClick="javascript:window.close()">
		</div>
		<br>
	</div>
</div>
</div>
</body>
</html>