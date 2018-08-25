<!-- INCLUDE user_menu_header.tpl -->

<div align="center" class="padding">
	<table style="text-align: left; width: 90%; border-collapse: collapse;" border="1" cellpadding="2" cellspacing="2">
		<tbody>
			<tr>
				<td width="150">{L_332}:</td>
				<td>{SUBJECT}</td>
			</tr>
			<tr>
				<td>{L_340}:</td>
				<td>{SENDERNAME} - <span class="small">{SENT}</span></td>
			</tr>
			<tr>
				<td>{L_333}:</td>
				<td>{MESSAGE}</td>
			</tr>
		</tbody>
	</table>
	<p>
	<a href="{SITEURL}mail.php?reply=1&amp;message={HASH}">{L_349}</a>
	&#32;&#32;|&#32;&#32;
	<a href="{SITEURL}mail.php?deleteid[]={ID}" onClick="if ( !confirm('{L_delete_message_confirm}') ) { return false; }">{L_008}</a>
	<br>
	<br>
	<a href="{SITEURL}mail.php">{L_351}</a>
	</p>
</div>

<!-- INCLUDE user_menu_footer.tpl -->
