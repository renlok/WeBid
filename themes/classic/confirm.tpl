<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_248}
		</div>
		<div class="table2" style="text-align:center">
<!-- IF PAGE eq 'error' -->
			<div class="error-box">
				{ERROR}
			</div>
<!-- ELSEIF PAGE eq 'confirm' -->
			<form name="registration" action="{SITEURL}confirm.php" method="post">
				<p>{L_267}</p>
				<input type="hidden" name="id" value="{USERID}">
				<input type="hidden" name="hash" value="{HASH}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<button type="submit" name="action" value="Confirm">{L_249}</button>
				<button type="submit" name="action" value="Refuse">{L_250}</button>
			</form>
<!-- ELSEIF PAGE eq 'confirmed' -->
			{L_330}
<!-- ELSEIF PAGE eq 'refused' -->
			{L_331}
<!-- ENDIF -->
		</div>
	</div>
</div>