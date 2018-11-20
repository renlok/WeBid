        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_5158}<i>{SITENAME}</i><br>{STATSMONTH}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12"> 
                <div style="text-align: center;" >
                	<a class="centre" href="viewbrowserstats.php">{L_5165}</a> | <a class="centre" href="viewplatformstats.php">{L_5318}</a>
                </div>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td colspan="3"><b>{L_5164}</b></td>
                    </tr>
                    <tr>
                        <td width="22" class="highbar">&nbsp;</td>
                        <td width="144"><b>&nbsp;{L_5161} : </b></td>
                        <td width="78"><b>{TOTAL_PAGEVIEWS}</b></td>
                    </tr>
                    <tr>
                    	<td class="midbar">&nbsp;</td>
                        <td><b>&nbsp;{L_5162} : </b></td>
                        <td><b>{TOTAL_UNIQUEVISITORS}</b></td>
                    </tr>
                    <tr>
                        <td class="lowbar">&nbsp;</td>
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
</div>
</div>

<!-- INCLUDE footer.tpl -->
