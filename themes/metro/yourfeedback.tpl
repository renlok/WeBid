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
			({L_506}{fbs.FBDATE} {L_25_0177} {fbs.AUCTIONURL})
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
</table>

<!-- INCLUDE user_menu_footer.tpl -->