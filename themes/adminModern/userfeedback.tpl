		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="container">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}&nbsp;&gt;&gt;&nbsp;{L_222}</h4>
				<table class="table table-striped table-bordered">
					<tr>
						<td align="right" colspan="2"><b>{NICK} ({FB_NUM}) <!-- IF FB_ICON ne '' --><img src="{SITEURL}images/icons/{FB_ICON}" alt="{FB_ICON}" class="fbstar"><!-- ENDIF --></b></td>
					</tr>
<!-- BEGIN feedback -->
					<tr<!-- IF feedback.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
						<td>
							<img align="middle" src="{SITEURL}images/{feedback.FB_TYPE}.png">&nbsp;&nbsp;<b>{feedback.FB_FROM}</b>&nbsp;&nbsp;<span class="small">({L_506}{feedback.	FB_TIME})</span>
							<p>{feedback.FB_MSG}</p>
						</td>
						<td align="right">
							<a href="edituserfeed.php?id={feedback.FB_ID}">{L_298}</a> | <a href="deleteuserfeed.php?id={feedback.FB_ID}&user={ID}">{L_008}</a>
						</td>
					</tr>
<!-- END feedback -->
				</table>
				<table class="table table-striped table-bordered">
					<tr>
						<td align="center">
							{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
							<br>
							{PREV}
<!-- BEGIN pages -->
							{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
							{NEXT}
						</td>
					</tr>
				</table>
			</div>
		</div>
