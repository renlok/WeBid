<table width="100%" border="0" cellpadding="0" cellspacing="0" class="content">
  <tr>
	<td width="22%" valign="top" class="columL">
		<table width="100%" border="0" cellspacing="0">
				<tr>
				  <td class="titTable1"><div class="imgTitL"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>
			{L_276}<div class="imgTitR"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="transparent"></div></td>
				</tr>
				<tr>
				  <td class="table1"><div id="table1ul">
				  <ul>
				  <!-- BEGIN cat_list -->
				  <li>
				  	<span style="background-color:{cat_list.COLOUR}">
				  		<a href="browse.php?id={cat_list.ID}">{cat_list.IMAGE}{cat_list.NAME}</a> {cat_list.CATAUCNUM}
					</span>
				  </li>
				  <!-- END cat_list -->
				  </ul>
				  <a href="{SITEURL}browse.php?id=0">{L_277}</a>
				</div></td>
				</tr>
			  </table>

	</td>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="maincolum">
<!-- IF B_AUC_LAST -->
  <tr>
	<td class="titTable4">{L_278}</td>
  </tr>
  <tr>
	<td class="table2">
	<!-- BEGIN auc_last -->
	<p style="background-color:{auc_last.BGCOLOUR};display:block;">{auc_last.DATE} <a href="{SITEURL}item.php?id={auc_last.ID}">{auc_last.TITLE}</a></p>
	<!-- END auc_last -->
	</td>
  </tr>
<!-- ENDIF -->
<!-- IF B_HIGH_BIDS -->
  <tr>
	<td class="titTable4">{L_279}</td>
  </tr>
  <tr>
	<td class="table2">
	<!-- BEGIN max_bids -->
	<p style="background-color:{max_bids.BGCOLOUR};display:block;">{max_bids.FBID} <a href="{SITEURL}item.php?id={max_bids.ID}">{max_bids.TITLE}</a></p>
	<!-- END max_bids -->
	</td>
  </tr>
<!-- ENDIF -->
<!-- IF B_AUC_ENDSOON -->
  <tr>
	<td class="titTable4">{L_280}</td>
  </tr>
  <tr>
	<td class="table2">
	<!-- BEGIN end_soon -->
	<p style="background-color:{end_soon.BGCOLOUR};display:block;">{end_soon.DATE} <a href="{SITEURL}item.php?id={end_soon.ID}">{end_soon.TITLE}</a></p>
	<!-- END end_soon -->
	</td>
  </tr>
<!-- ENDIF -->
<tr><td>&nbsp;</td></tr>
</table>
	</td>
	<td width="20%" valign="top" class="columR">
<!-- IF B_MULT_LANGS -->
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="titTable1"><div class="imgTitL"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>{L_2__0001}<div class="imgTitR"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div></td>
		</tr>
		<tr>
		  <td class="table1">{FLAGS}</td>
		</tr>
	  </table>
<!-- ENDIF -->
<!-- IF B_LOGIN_BOX -->
	<!-- IF B_LOGGED_IN -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="titTable1"><div class="imgTitL"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>{L_200} {YOURUSERNAME}<div class="imgTitR"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div></td>
		</tr>
		<tr>
		  <td>
			<ul>
				<li><a href="{SITEURL}edit_data.php?">{L_244}</a></li>
				<li><a href="{SITEURL}user_menu.php">{L_622}</a></li>
				<li><a href="{SITEURL}logout.php">{L_245}</a></li>
			  </ul></td>
		</tr>
	  </table>
	<!-- ELSE -->
		<FORM NAME="login" ACTION="{SSLURL}login.php" METHOD="post"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="titTable1"><div class="imgTitL"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>{L_221}<div class="imgTitR"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div></td>
		</tr>
        <!-- IF B_LOGIN_ERROR -->
	  	<TR>
		<TD colspan="2" class="errfont">
			{LOGIN_ERROR}
		</TD>
		</TR>
	  <!-- ENDIF -->
		<tr>
		  <td class="table1">
	  <TABLE WIDTH="100%">
	  	<TR>
		<TD WIDTH="25%"><label for="username" title="please enter your username">{L_003}&nbsp;</label></TD>
		<TD WIDTH="75%"><input type="text" name="username" id="username" size="10" MAXLENGTH="20"></TD>
		</TR>
		<TR>
		<TD WIDTH="25%"><label for="password" title="please enter your password">{L_004}&nbsp;</label></TD>
		<TD WIDTH="75%"><input type="password" name="password" id="password" size="10" MAXLENGTH="20"></TD>
		</TR>
	  </TABLE>
			<p><input type="checkbox" name="rememberme" id="rememberme" value="1"><label for="rememberme">&nbsp;{L_25_0085}</label></p>
			<p align="center"><input type="submit" name="action" value="{L_275}" class="button"></p>
			<p><a href="{SITEURL}forgotpasswd.php">{L_215}</a></p></td>
		</tr>
	  </table>
		</FORM>
	<!-- ENDIF -->
<!-- ENDIF -->
<!-- IF B_HELPBOX -->
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="titTable1"><div class="imgTitL"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>{L_281}<div class="imgTitR"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>
</td>
		</tr>
		<tr>
		  <td class="table1ul">
			 <ul>
			 <!-- BEGIN helpbox -->
			 	<li><a href="{SITEURL}viewfaqs.php?cat={helpbox.ID}" alt="faqs"  class="new-window">{helpbox.TITLE}</a></li>
			 <!-- END helpbox -->
			 </ul>
		  </td>
		</tr>
	  </table>
<!-- ENDIF -->
<!-- IF B_NEWS_BOX -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="titTable1"><div class="imgTitL"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>{L_282}<div class="imgTitR"><img src="{SITEURL}images/transparent.gif" width="10" height="10" alt="space"></div>
</td>
		</tr>
		<tr>
		  <td class="table1ul">
			  <ul>
			 <!-- BEGIN newsbox -->
			 	<li>{newsbox.DATE} - <a href="viewnew.php?id={newsbox.ID}">{newsbox.TITLE}</a></li>
			 <!-- END newsbox -->
			 </ul>
		  </td>
		</tr>
	  </table>   
<!-- ENDIF -->
	  </td>
  </tr>
</table>