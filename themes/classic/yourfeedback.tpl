<!-- INCLUDE user_menu_header.tpl -->

<table width="90%" border="0" cellpadding="1" cellspacing="0" align="center">
	<tr>
		<td colspan="2" align="right">
			<b>{USERNICK}</b> ({USERFB}) {USERFBIMG}
		</td>
	</tr>
<!-- BEGIN fbs -->
	<tr {fbs.BGCOLOUR}>
		<td valign="top">
			<img src="{fbs.IMG}" align="middle" alt="">
		</td>
		<td valign="top">
			<b><a href="{fbs.USFLINK}">{fbs.USERNAME} ({fbs.USFEED})</a></b>&nbsp;{fbs.USICON}
			({L_506}{fbs.FBDATE} {L_25_0177} 
	<!-- IF AUCTION_TITLE eq '' -->
			{L_113}{AUCTION_ID}
	<!-- ELSE -->
			<a href="item.php?id={AUCTION_ID}">{AUCTION_TITLE}</a>
	<!-- ENDIF -->
			)
			<br>
			<b>{L_504}: </b>{fbs.FEEDBACK}
		</td>
	</tr>
<!-- END fbs -->
	<tr {BGCOLOUR}>
		<td colspan="2" align="right">
			{PAGENATION}
		</td>
	</tr>
	<tr>
</table>
<div align="center">
<table width="90%" border="0" elpadding="0" celspacing="0">
	<tr>
	<td align="center">
	<br>
	<form method="post" action="{SITE_URL}user_menu.php?cptab=account">
	<input type="submit" value="<< {L_25_0081}">
	</form>
	</td>
	</tr>
</table>

</div>

<!-- INCLUDE user_menu_footer.tpl -->