<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}/themes/{THEME}/style.css" />
</head>
<body style="margin:0;">
<div style="width:400px; padding:40px;" class="centre">
	<div class="plain-box" style="text-align:center; padding: 10px; font-size: 1.4em;">
	<form action="" method="post">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	{L_delete_category_move_auctions}
	<table cellpadding="0" cellspacing="0">
<!-- BEGIN categories -->
	<!-- IF categories.HAS_CHILDREN -->
			<tr>
				<td>{categories.NAME}</td><td>
					<select name="delete[{categories.ID}]">
						<option value="delete">{L_008}</option>
						<option value="move">{L_840}: </option>
					</select>
				</td>
				<td><input type="text" size="5" name="moveid[{categories.ID}]"></td>
			</tr>
	<!-- ELSE -->
			<input type="hidden" name="delete[{categories.ID}]" value="delete">
	<!-- ENDIF -->
<!-- END categories -->
		</table>
		<p>{L_this_cannot_be_undone}</p>
		<div class="break">&nbsp;</div>
		<button type="submit" name="action" value="Yes">{L_yes}</button>
		<button type="submit" name="action" value="No">{L_no}</button>
	</form>
	</div>
</div>
<div>
