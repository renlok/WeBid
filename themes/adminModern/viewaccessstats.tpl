		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0023}&nbsp;&gt;&gt;&nbsp;{L_5143}</h4>
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>{L_5158}<i>{SITENAME}</i></strong>
						<br>
						{STATSMONTH}
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<a href="viewbrowserstats.php">{L_5165}</a> | <a href="viewplatformstats.php">{L_5318}</a>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12"><strong>{L_5164}</strong></div>
						</div>
						<div class="row">
							<div class="col-md-1" style="background-color: #006699">&nbsp;</div>
							<div class="col-md-3"><strong>&nbsp;{L_5161} : </strong></div>
							<div class="col-md-8"><strong>{TOTAL_PAGEVIEWS}</strong></div>
						</div>
						<div class="row">
							<div class="col-md-1" style="background-color: #66CC00">&nbsp;</div>
							<div class="col-md-3"><strong>&nbsp;{L_5162} : </strong></div>
							<div class="col-md-8"><strong>{TOTAL_UNIQUEVISITORS}</strong></div>
						</div>
						<div class="row">
							<div class="col-md-1" style="background-color: #FFFF00">&nbsp;</div>
							<div class="col-md-3"><strong>&nbsp;{L_5163} :</strong></div>
							<div class="col-md-8"><strong>{TOTAL_USERSESSIONS}</strong></div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2"><strong>{STATSTEXT}</strong></div>
							<div class="col-md-10 text-right"><strong>{L_829}<a href="viewaccessstats.php?type=d">{L_109}</a>/ <a href="viewaccessstats.php?type=w">{L_828}</a>/ <a href="	viewaccessstats.php?type=m">{L_830}</a></strong></div>
						</div>
<!-- BEGIN sitestats -->
						<div class="row">
							<div class="col-md-2"><strong>{sitestats.DATE}</strong></div>
							<div class="col-md-10">
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
							</div>
						</div>
<!-- END sitestats -->
					</div>
				</div>
			</div>
		</div>
