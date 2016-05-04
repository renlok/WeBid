<table width="100%" border="0" cellpadding="0" cellspacing="0" class="smallpadding">
	<tr>
		<td width="22%" valign="top" class="columL">
			<div class="titTable1 rounded-left rounded-right">
				{L_276}
			</div>
			<div class="smallpadding">
				<ul>
<!-- BEGIN cat_list -->
					<li>
						<span style="background-color:{cat_list.COLOUR}">
						<a href="browse.php?id={cat_list.ID}">{cat_list.IMAGE}{cat_list.NAME}</a>
	<!-- IF cat_list.CATAUCNUM neq '' -->
						({cat_list.CATAUCNUM})
	<!-- ENDIF -->
						</span>
					</li>
<!-- END cat_list -->
				</ul>
				<a href="{SITEURL}browse.php?id=0">{L_277}</a>
			</div>
		</td>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="maincolum">
<!-- IF B_FEATURED_ITEMS -->
				<tr>
					<td class="titTable4 rounded-left rounded-right">{L_NAY_01}</td>
				</tr>
				<tr>
					<td class="table2">
	<!-- BEGIN featured -->
						<div class="itembox">
							<div><img src="{featured.IMAGE}"></div>
							<div><a href="{SITEURL}item.php?id={featured.ID}">{featured.TITLE}</a><br>{featured.BID}</div>
						</div>
	<!-- END featured -->
					</td>
				</tr>
<!-- ENDIF -->
<!-- IF B_HOT_ITEMS -->
				<tr>
					<td class="titTable4 rounded-left rounded-right">{L_279}</td>
				</tr>
				<tr>
					<td class="table2">
	<!-- BEGIN hotitems -->
						<div class="itembox">
							<div><img src="{hotitems.IMAGE}"></div>
							<div><a href="{SITEURL}item.php?id={hotitems.ID}">{hotitems.TITLE}</a><br>{hotitems.BID}</div>
						</div>
	<!-- END hotitems -->
					</td>
				</tr>
<!-- ENDIF -->
<!-- IF B_AUC_LAST -->
				<tr>
					<td class="titTable4 rounded-left rounded-right">{L_278}</td>
				</tr>
				<tr>
					<td class="table2">
	<!-- BEGIN auc_last -->
						<p style="display:block;" {auc_last.BGCOLOUR}>{auc_last.DATE} <a href="{SITEURL}item.php?id={auc_last.ID}">{auc_last.TITLE}</a></p>
	<!-- END auc_last -->
					</td>
				</tr>
<!-- ENDIF -->
<!-- IF B_AUC_ENDSOON -->
				<tr>
					<td class="titTable4 rounded-left rounded-right">{L_280}</td>
				</tr>
				<tr>
					<td class="table2">
	<!-- BEGIN end_soon -->
					<p style="display:block;" {end_soon.BGCOLOUR}>{end_soon.DATE} <a href="{SITEURL}item.php?id={end_soon.ID}">{end_soon.TITLE}</a></p>
	<!-- END end_soon -->
					</td>
				</tr>
<!-- ENDIF -->
			</table>
		</td>
		<td width="20%" valign="top" class="columR">
<!-- IF B_MULT_LANGS -->
			<div class="titTable1 rounded-left rounded-right">
				{L_2__0001}
			</div>
			<div class="smallpadding">
				{FLAGS}
			</div>
<!-- ENDIF -->
<!-- IF B_LOGIN_BOX -->
	<!-- IF B_LOGGED_IN -->
			<div class="titTable1 rounded-left rounded-right">
				{L_200} {YOURUSERNAME}
			</div>
			<div class="smallpadding">
				<ul>
					<li><a href="{SITEURL}edit_data.php?">{L_244}</a></li>
					<li><a href="{SITEURL}user_menu.php">{L_622}</a></li>
					<li><a href="{SITEURL}logout.php">{L_245}</a></li>
				</ul>
			</div>
	<!-- ELSE -->
			<div class="titTable1 rounded-left rounded-right">
				{L_221}
			</div>
			<div class="smallpadding">
				<form name="login" action="{SITEURL}user_login.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<table width="100%">
					<tr>
						<td width="25%"><label for="username" title="please enter your username">{L_003}</label></td>
						<td width="75%"><input type="text" name="username" id="username" size="10" maxlength="20"></td>
					</tr>
					<tr>
						<td width="25%"><label for="password" title="please enter your password">{L_004}&nbsp;</label></td>
						<td width="75%"><input type="password" name="password" id="password" size="10" maxlength="20"></td>
					</tr>
					</table>
					<p><input type="checkbox" name="rememberme" id="rememberme" value="1"><label for="rememberme">&nbsp;{L_25_0085}</label></p>
					<p align="center"><button type="submit" name="action" class="button" value="Go">{L_275a}</button></p>
					<p><a href="{SITEURL}forgotpasswd.php">{L_215}</a></p>
				</form>
			</div>
	<!-- ENDIF -->
<!-- ENDIF -->
<!-- IF B_HELPBOX -->
			<div class="titTable1 rounded-left rounded-right">
				{L_281}
			</div>
			<div class="smallpadding">
				<ul>
	<!-- BEGIN helpbox -->
					<li><a href="{SITEURL}viewhelp.php?cat={helpbox.ID}" alt="faqs"  class="new-window">{helpbox.TITLE}</a></li>
	<!-- END helpbox -->
				</ul>
			</div>
<!-- ENDIF -->
<!-- IF B_NEWS_BOX -->
			<div class="titTable1 rounded-left rounded-right">
				{L_282}
			</div>
			<div class="smallpadding">
				<ul>
	<!-- BEGIN newsbox -->
					<li>{newsbox.DATE} - <a href="viewnews.php?id={newsbox.ID}">{newsbox.TITLE}</a></li>
	<!-- END newsbox -->
				</ul>
				<a href="{SITEURL}viewallnews.php">{L_341}</a>
			</div>
<!-- ENDIF -->
		</td>
	</tr>
</table>
