<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr> 
				<td width="30"><img src="images/i_sta.gif" ></td>
				<td class="white">{L_25_0023}&nbsp;&gt;&gt;&nbsp;{L_5143}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" cellpadding="2" cellspacing="1" border="0" align="center">
		<tr bgcolor="#FFCC00">
			<td align="center" colspan="2" bgcolor="#eeeeee">
				<p class="title" style="color:#000000">
					{L_5158}<i>{SITENAME}</i><br>
					{L_5281}
				</p>
				<p><a href="viewbrowserstats.php">{L_5165}</a> | <a href="viewdomainstats.php">{L_5166}</a> | <a href="viewplatformstats.php">{L_5318}</a></p>
			</td>
		</tr>
		<tr>
		<td colspan="2">
			<table width="250" border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF">
				<tr>
					<td colspan="3"><b>{L_5164}</b></td>
				</tr>
				<tr>
					<td width="22" bgcolor="#006699">&nbsp;</td>
					<td bgcolor="#FFFFFF" width="144"><b>&nbsp;{L_5161} : </b></td>
					<td bgcolor="#FFFFFF" width="78"><b>{TOTAL_PAGEVIEWS}</b></td>
				</tr>
				<tr>
				<td width="22" bgcolor="#66CC00">&nbsp;</td>
					<td bgcolor="#FFFFFF" width="144"><b>&nbsp;{L_5162} : </b></td>
					<td bgcolor="#FFFFFF" width="78"><b>{TOTAL_UNIQUEVISITORS}</b></td>
				</tr>
				<tr>
					<td width="22" bgcolor="#FFFF00">&nbsp;</td>
					<td bgcolor="#FFFFFF" width="144"><b>&nbsp;{L_5163} :</b></td>
					<td bgcolor="#FFFFFF" width="78"><b>{TOTAL_USERSESSIONS}</b></td>
				</tr>
			</table>
		</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td width="80">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr bgcolor="#CCCCCC">
			<td align="center" width="80"><b>{L_5280}</b></td>
			<td align="right" height="21"><a href="viewaccessstats.php">{L_5282}</a></td>
		</tr>
<!-- BEGIN sitestats -->
		<tr bgcolor="#eeeeee">
			<td align="center" height="45"><b>{sitestats.DATE}</b></td>
			<td>
	<!-- IF sitestats.PAGEVIEWS eq 0 -->
				<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
				<div style="height:15px; width:{sitestats.PAGEVIEWS_WIDTH}%; background-color:#006699; color:#FFFFFF;"><b>{sitestats.PAGEVIEWS}</b></div>
	<!-- ENDIF -->
	<!-- IF sitestats.UNIQUEVISITORS eq 0 -->
				<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
				<div style="height:15px; width:{sitestats.UNIQUEVISITORS_WIDTH}%; background-color:#66CC00; color:#FFFFFF;"><b>{sitestats.UNIQUEVISITORS}</b></div>
	<!-- ENDIF -->
	<!-- IF sitestats.USERSESSIONS eq 0 -->
				<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
				<div style="height:15px; width:{sitestats.USERSESSIONS_WIDTH}%; background-color:#FFFF00;"><b>{sitestats.USERSESSIONS}</b></div>
	<!-- ENDIF -->
			</td>
		</tr>
<!-- END sitestats -->
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->


<!-- INCLUDE header.tpl -->
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom">{L_25_0023}&nbsp;&gt;&gt;&nbsp;{L_5143}</h4>
				<div style="font-size: 16px; font-weight: bold; text-align: center;" class="centre">
					{L_5158}<i>{SITENAME}</i><br>
					{STATSMONTH}
				</div>
                <div style="text-align: center;" class="centre">
                	<a href="viewbrowserstats.php">{L_5165}</a> | <a href="viewdomainstats.php">{L_5166}</a> | <a href="viewplatformstats.php">{L_5318}</a>
                </div>
                <table width="250" cellspacing="1" cellpadding="0" class="blank">
                    <tr>
                        <td colspan="3"><b>{L_5164}</b></td>
                    </tr>
                    <tr>
                        <td width="22" bgcolor="#006699">&nbsp;</td>
                        <td width="144"><b>&nbsp;{L_5161} : </b></td>
                        <td width="78"><b>{TOTAL_PAGEVIEWS}</b></td>
                    </tr>
                    <tr>
                    	<td bgcolor="#66CC00">&nbsp;</td>
                        <td><b>&nbsp;{L_5162} : </b></td>
                        <td><b>{TOTAL_UNIQUEVISITORS}</b></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFF00">&nbsp;</td>
                        <td><b>&nbsp;{L_5163} :</b></td>
                        <td><b>{TOTAL_USERSESSIONS}</b></td>
                    </tr>
                </table>

                <table width="98%" cellspacing="1" cellpadding="0" class="blank">
                <tr>
                    <th align="center" width="80"><b>{STATSTEXT}</b></td>
                    <th height="21" style="text-align:right;">{L_829}<a href="viewaccessstats.php?type=d">{L_109}</a>/ <a href="viewaccessstats.php?type=w">{L_828}</a>/ <a href="viewaccessstats.php?type=m">{L_830}</a></td>
                </tr>
<!-- BEGIN sitestats -->
                <tr class="bg">
                    <td align="center" height="45"><b>{sitestats.DATE}</b></td>
                    <td>
	<!-- IF sitestats.PAGEVIEWS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
						<div style="height:15px; width:{sitestats.PAGEVIEWS_WIDTH}%; background-color:#006699; color:#FFFFFF;"><b>{sitestats.PAGEVIEWS}</b></div>
	<!-- ENDIF -->
	<!-- IF sitestats.UNIQUEVISITORS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
						<div style="height:15px; width:{sitestats.UNIQUEVISITORS_WIDTH}%; background-color:#66CC00; color:#FFFFFF;"><b>{sitestats.UNIQUEVISITORS}</b></div>
	<!-- ENDIF -->
	<!-- IF sitestats.USERSESSIONS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
						<div style="height:15px; width:{sitestats.USERSESSIONS_WIDTH}%; background-color:#FFFF00;"><b>{sitestats.USERSESSIONS}</b></div>
	<!-- ENDIF -->
                    </td>
                </tr>
<!-- END sitestats -->
				</table>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->