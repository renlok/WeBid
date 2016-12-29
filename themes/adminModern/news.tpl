		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
			<div class="col-md-9">
			<div class="container">
				<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_516}</h4>
				<div class="plain-box">{NEWS_COUNT}{L_517}</div>
				<table class="table table-striped table-bordered">
					<tr>
						<th width="20%">{L_314}</th>
						<th width="60%">{L_312}</th>
						<th>{L_297}</th>
					</tr>
<!-- BEGIN news -->
					<tr<!-- IF news.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
						<td>{news.DATE}</td>
						<td <!-- IF news.SUSPENDED eq 1 -->style="background: #FAD0D0; color: #B01717; font-weight: bold;"<!-- ENDIF -->>{news.TITLE}</td>
						<td>
							<a class="btn-primary btn" href="editnew.php?id={news.ID}&PAGE={PAGE}">{L_298}</a><br>
							<a class="btn-primary btn" href="deletenews.php?id={news.ID}&PAGE={PAGE}">{L_008}</a>
						</td>
					</tr>
<!-- END news -->
				</table>
				<div class="plain-box"><a href="addnew.php" class="button">{L_518}</a></div>
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
