<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<div style="padding:40px;" align="center">
	<form name="login" action="login.php" method="post">
	<table width="415" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF" style="border: 2px #000000 outset;">
<!-- IF PAGE eq 1 -->
		<tr bgcolor="#336699">
			<td colspan="2" align="center" style="padding:10px; color:#FFFFFF;">
				<b>:: {L_441} ::</b>
			</td>
		</tr>
<!-- ELSE -->
		<tr bgcolor="#33CC33">
			<td colspan="2" align="center" style="padding:10px;">
				<b>:: {L_442} ::</b>
			</td>
		</tr>
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
		<tr bgcolor="yellow">
			<td class="error" colspan="2" align="center">{ERROR}</td>
		</tr>
<!-- ENDIF -->
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

<!-- INCLUDE footer.tpl -->