        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_5438}<i>{SITENAME}</i><br>{STATSMONTH}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12"> 
     <div style="font-size: 16px; font-weight: bold; text-align: center;" >
				</div>
                <div style="text-align: center;">
                	<a class="centre" href="viewaccessstats.php">{L_5143}</a> | <a class="centre" href="viewbrowserstats.php">{L_5165}</a>
                </div>

                <table class="table table-bordered table-striped">
                <tr>
                    <th align="center" width="80"><b>{L_5156}</b></td>
                    <th height="21" style="text-align:right;">&nbsp;</td>
                </tr>
<!-- BEGIN sitestats -->
					<tr class="bg">
						<td align="center" height="45"><b>{sitestats.PLATFORM}</b></td>
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
</div>
</div>
<!-- INCLUDE footer.tpl -->
