		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0023}&nbsp;&gt;&gt;&nbsp;{L_5165}</h4>
				<div style="font-size: 16px; font-weight: bold; text-align: center;" class="centre">
					{L_5167}<i>{SITENAME}</i><br>
					{STATSMONTH}
				</div>
				<div style="text-align: center;" class="centre">
					<a href="viewaccessstats.php">{L_5143}</a> | <a href="viewplatformstats.php">{L_5318}</a>
				</div>

				<table width="98%" cellspacing="1" cellpadding="0" class="blank">
					<tr>
						<th align="center" width="80"><b>{L_5169}</b></td>
						<th height="21" style="text-align:right;">&nbsp;</td>
					</tr>
<!-- BEGIN sitestats -->
					<tr class="bg">
						<td align="center" height="45"><b>{sitestats.BROWSER}</b></td>
						<td>
	<!-- IF sitestats.NUM eq 0 -->
							<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
							<div style="height:15px; width:{sitestats.WIDTH}%; background-color:#006699; color:#FFFFFF;"><b>{sitestats.PERCENTAGE}%</b></div>
	<!-- ENDIF -->
						</td>
					</tr>
<!-- END sitestats -->
				</table>
			</div>
		</div>