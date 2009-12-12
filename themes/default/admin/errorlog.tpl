<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
	<td background="{SITEURL}admin/images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr> 
				<td width="30"><img src="{SITEURL}admin/images/i_too.gif"></td>
				<td class="white">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_891}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{L_891}</td>
		</tr>
		<tr>
			<td>
				<form name="conf" action="" method="post">
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td class="error" align="center">{ERROR}</td>
				</tr>
<!-- ENDIF -->
				<tr valign="top">
					<td>
                    	<div style="margin:10px; overflow:scroll; height:500px;">
                        {ERRORLOG}
                        </div>
                    </td>
				</tr>
				<tr>
					<td align="center"><input type="hidden" name="action" value="clearlog">
                    <input type="submit" name="act" value="{L_890}"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->