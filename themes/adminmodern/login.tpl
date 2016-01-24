<html>
<head>
	<title>WeBid Administration back-end</title>
	<link rel="stylesheet" type="text/css" href="{SITEURL}/themes/admin/style.css" />
</head>
<body style="margin:0;">
<div style="width:400px; padding:40px;" class="centre">
	<div class="plain-box">
<!-- IF PAGE eq 1 -->
		<div class="info-box"><b>{L_441}</b></div>
<!-- ELSE -->
		<div class="success-box"><b>{L_442}</b></div>
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
		<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
		<form action="login.php" method="post">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<table width="100%" border="0" cellspacing="0" cellpadding="1" class="blank">
				<tr>
					<td align="right" stype="width:170px;">
						{L_003}
					</td>
					<td style="padding:10px;">
						<input type="text" name="username" size="20">
					</td>
				</tr>
				<tr>
					<td align="right">
						{L_004}
					</td>
					<td style="padding:10px;">
						<input type="password" name="password" size="20">
					</td>
				</tr>
<!-- IF PAGE eq 1 -->
				<tr>
					<td align="right">
						{L_005}
					</td>
					<td style="padding:10px;">
						<input type="password" name="repeat_password" size="20">
					</td>
				</tr>
<!-- ENDIF -->
				<tr>
					<td align="center" colspan="2">
<!-- IF PAGE eq 1 -->
						<input type="hidden" name="action" value="insert">
						<input type="submit" name="submit" value="{L_5204}">
<!-- ELSE -->
						<input type="hidden" name="action" value="login">
						<input type="submit" name="submit" value="{L_052}">
<!-- ENDIF -->
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<div>
	<div>

<!-- INCLUDE footer.tpl -->