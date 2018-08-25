<!-- INCLUDE user_menu_header.tpl -->

<table width="90%" border="0" cellpadding="1" cellspacing="0" align="center">
	<tr>
		<td colspan="2" align="right">
			<b>{USERNICK}</b> ({USERFB}) <!-- IF USER_FB_ICON ne '' --><img src="{SITEURL}images/icons/{USER_FB_ICON}" alt="{USER_FB_ICON}" class="fbstar"><!-- ENDIF -->
		</td>
	</tr>
<!-- BEGIN fbs -->
	<tr {fbs.BGCOLOUR}>
		<td valign="top">
			<img src="{fbs.IMG}" align="middle" alt="">
		</td>
		<td valign="top">
			<b><a href="{fbs.USFLINK}">{fbs.USERNAME} ({fbs.USFEED})</a></b> <!-- IF fbs.FB_ICON ne '' --><img src="{SITEURL}images/icons/{fbs.FB_ICON}" alt="{fbs.FB_ICON}" class="fbstar"><!-- ENDIF -->
			({L_506}{fbs.FBDATE} {L_25_0177}
	<!-- IF fbs.AUCTION_TITLE eq '' -->
			{L_113}{fbs.AUCTION_ID}
	<!-- ELSE -->
			<a href="item.php?id={fbs.AUCTION_ID}">{fbs.AUCTION_TITLE}</a>
	<!-- ENDIF -->
			)
			<br>
			<b>{L_504}: </b>{fbs.FEEDBACK}
		</td>
	</tr>
<!-- END fbs -->
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
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

<!-- INCLUDE user_menu_footer.tpl -->
