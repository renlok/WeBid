<!-- INCLUDE user_menu_header.tpl -->

<div class="padding">
	<form action="" method="post" name="thisform" id="thisform">
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<table width="100%" cellspacing="0" cellpadding="4" border="0" >
			<tr>
				<td width="93%">
					{L_25_0195}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="startemailmod" value="yes"{B_AUCSETUPY}>
					{L_25_0196}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="startemailmod" value="no"{B_AUCSETUPN}>
					{L_25_0197}
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="93%">
					{L_25_0189}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="endemailmod" value="one"{B_CLOSEONE}>
					{L_25_0190}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="endemailmod" value="cum"{B_CLOSEBULK}>
					{L_25_0191}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="endemailmod" value="none"{B_CLOSENONE}>
					{L_25_0193}
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="93%">
					{L_903}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="emailtype" value="text"{B_EMAILTYPET}> {L_915} <input type="radio" name="emailtype" value="html"{B_EMAILTYPEH}> {L_902}
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="hidden" name="action" value="update">
					<input type="submit" name="Submit" value="{L_530}" class="button">
					<br>
					<br>
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- INCLUDE user_menu_footer.tpl -->
