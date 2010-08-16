<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>WeBid Administration back-end</title>

<style type="text/css">
body {
	scrollbar-face-color: #0083D7;
	scrollbar-shadow-color: #0000cc;
	scrollbar-highlight-color: #0083D7;
	scrollbar-3dlight-color: #ffffff;
	scrollbar-darkshadow-color: #000066;
	scrollbar-track-color: #B7FFFF;
	scrollbar-arrow-color: #ffffff;
}
.menutitle{
	cursor: pointer;
	font-family: Verdana, Arial;
	font-size: 10px;
	color:#666666;
	text-align:left;
	text-decoration: none;
	font-weight:bold;
	padding: 4px;
}
.submenu{
	font-family: Verdana, Arial;
	font-size: 10px;
	padding: 2px;
	text-decoration: none;
	text-color: #666666
}
.submenulink{
	font-family: Verdana, Arial;
	font-size: 10px;
	padding: 2px;
	text-decoration: none;
	text-color: #666666
}
.bullet {
	list-style-image: url({SITEURL}admin/images/bul.gif);
}
</style>

<script type="text/javascript">
/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

if (document.getElementById){ //DynamicDrive.com change
	document.write('<style type="text/css">\n')
	document.write('.submenu{display: none;}\n')
	document.write('</style>\n')
}

function SwitchMenu(obj){
	if (document.getElementById) {
		var el = document.getElementById(obj);
		var ar = document.getElementById("masterdiv").getElementsByTagName("span"); //DynamicDrive.com change
		if (el.style.display != "block"){ //DynamicDrive.com change
			for (var i = 0; i < ar.length; i++){
				if (ar[i].className == "submenu") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		} else {
			el.style.display = "none";
		}
	}
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#edf8ff" background="{SITEURL}admin/images/bac_bar.gif" text="#000000" link="#666666" vlink="#000000" alink="#3366CC">
<!-- IF B_ADMINLOGIN -->
<div id="masterdiv">
<table width="200" height="100%" border="0" cellpadding="0" cellspacing="0" background="{SITEURL}admin/images/bac_bar.gif">
  <tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="2" cellpadding="0">
		<tr>
			<td align="center"><img src="{SITEURL}admin/images/i_hom.gif" width="17" height="18"></td>
			<td><a href="{SITEURL}admin/home.php" target="content" class="menutitle"><b>{L_166}</b></a></td>
  		</tr>
		 <tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
	</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_set.gif" width="21" height="19" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('settings')">{L_5142}</div>
			<span class="submenu" id="settings">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/settings.php" target="content" class="submenulink">{L_526}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/auctions.php" target="content" class="submenulink">{L_5087}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/displaysettings.php" target="content" class="submenulink">{L_788}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/spam.php" target="content" class="submenulink">{L_749}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/usersettings.php" target="content" class="submenulink">{L_894}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/errorhandling.php" target="content" class="submenulink">{L_409}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/countries.php" target="content" class="submenulink">{L_081}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/payments.php" target="content" class="submenulink">{L_075}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/durations.php" target="content" class="submenulink">{L_069}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/increments.php" target="content" class="submenulink">{L_128}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/membertypes.php" target="content" class="submenulink">{L_25_0169}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/checkversion.php" target="content" class="submenulink">{L_25_0169a}</a><br><br>
			<b><FONT COLOR=#666666>{L_276}</FONT></b><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/categories.php" target="content" class="submenulink">{L_078}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/categoriestrans.php" target="content" class="submenulink">{L_132}</a><br><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_pre.gif" width="16" height="19" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('preferences')">{L_25_0008}</div>
			<span class="submenu" id="preferences">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/currency.php" target="content" class="submenulink">{L_5004}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/time.php" target="content" class="submenulink">{L_344}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/buyitnow.php" target="content" class="submenulink">{L_2__0025}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/defaultcountry.php" target="content" class="submenulink">{L_5322}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/counters.php" target="content" class="submenulink">{L_2__0057}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/multilingual.php" target="content" class="submenulink">{L_2__0002}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/catsorting.php" target="content" class="submenulink">{L_25_0146}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/metatags.php" target="content" class="submenulink">{L_25_0178}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/contactseller.php" target="content" class="submenulink">{L_25_0216}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/buyerprivacy.php" target="content" class="submenulink">{L_236}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_fee.gif" width="16" height="19" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('fees')">{L_25_0012}</div>
			<span class="submenu" id="fees">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/fees.php" target="content" class="submenulink">{L_25_0012}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/fee_gateways.php" target="content" class="submenulink">{L_445}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/enablefees.php" target="content" class="submenulink">{L_395}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_gra.gif" width="19" height="19" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('graphic')">{L_25_0009}</div>
			<span class="submenu" id="graphic">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/theme.php" target="content" class="submenulink">{L_26_0002}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/clearcache.php" target="content" class="submenulink">{L_30_0031}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_ban.gif" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('banners')">{L_25_0011}</div>
			<span class="submenu" id="banners">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/banners.php" target="content" class="submenulink">{L_5205}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/managebanners.php" target="content" class="submenulink">{L__0008}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_use.gif" width="24" height="18" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('users')">{L_25_0010}</div>
			<span class="submenu" id="users">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/listusers.php" target="content" class="submenulink">{L_045}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/usergroups.php" target="content" class="submenulink">{L_448}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/profile.php" target="content" class="submenulink">{L_048}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/activatenewsletter.php" target="content" class="submenulink">{L_25_0079}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/newsletter.php" target="content" class="submenulink">{L_607}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/banips.php" target="content" class="submenulink">{L_2_0017}</a><br><br>
			<b><FONT COLOR=#666666>{L_365}</FONT></b><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/newadminuser.php" target="content" class="submenulink">{L_367}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/adminusers.php" target="content" class="submenulink">{L_525}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_auc.gif" width="24" height="15" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('auctions')">{L_239}</div>
			<span class="submenu" id="auctions">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/listauctions.php" target="content" class="submenulink">{L_067}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/listclosedauctions.php" target="content" class="submenulink">{L_214}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/listsuspendedauctions.php" target="content" class="submenulink">{L_5227}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_con.gif" width="22" height="19" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('contents')">{L_25_0018}</div>
			<span class="submenu" id="contents">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/news.php" target="content" class="submenulink">{L_516}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/aboutus.php" target="content" class="submenulink">{L_5074}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/terms.php" target="content" class="submenulink">{L_5075}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/privacypolicy.php" target="content" class="submenulink">{L_402}</a><br><br>
			<b><FONT COLOR=#666666>{L_148}</FONT></b><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/faqscategories.php" target="content" class="submenulink">{L_5230}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/newfaq.php" target="content" class="submenulink">{L_5231}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/faqs.php" target="content" class="submenulink">{L_5232}</a><br><br>
			<b><FONT COLOR=#666666>{L_5030}</FONT></b><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/boardsettings.php" target="content" class="submenulink">{L_5047}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/newboard.php" target="content" class="submenulink">{L_5031}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/boards.php" target="content" class="submenulink">{L_5032}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_sta.gif" width="21" height="19" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('stats')">{L_25_0023}</div>
			<span class="submenu" id="stats">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/stats_settings.php" target="content" class="submenulink">{L_5142}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/viewaccessstats.php" target="content" class="submenulink">{L_5143}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/viewbrowserstats.php" target="content" class="submenulink">{L_5165}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/viewplatformstats.php" target="content" class="submenulink">{L_5318}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/viewdomainstats.php" target="content" class="submenulink">{L_5166}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_too.gif" width="20" height="20" hspace="0"></td>
		  <td width="170">
		  	<div class="menutitle" onClick="SwitchMenu('tools')">{L_5436}</div>
			<span class="submenu" id="tools">
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/maintainance.php" target="content" class="submenulink">{L__0001}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/wordsfilter.php" target="content" class="submenulink">{L_5068}</a><br>
			<img src="{SITEURL}admin/images/bul.gif" hspace="2"><a href="{SITEURL}admin/errorlog.php" target="content" class="submenulink">{L_891}</a><br>
			</span>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
		<tr>
		  <td width="30" align="center" valign="top"><img src="{SITEURL}admin/images/i_help.gif" width="18" height="19" hspace="0"></td>
		  <td width="170">
		  	<a href="{SITEURL}admin/help.php" target="content" class="menutitle"><b>{L_148}</b></A>
		  </TD>
		</tr>
		<tr>
		  <td colspan=2><img src="{SITEURL}admin/images/bar_sep.gif" width="196" height="3" vspace="1"></td>
		</tr>
	  </table></td>
  </tr>
</table>
</div>
<!-- ENDIF -->
</body>
</html>
