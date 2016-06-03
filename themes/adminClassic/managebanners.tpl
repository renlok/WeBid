		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0011}&nbsp;&gt;&gt;&nbsp;{L__0008} : {L__0012}</h4>
				<form name="deleteusers" action="" method="post">
					<div class="plain-box"><a href="newbannersuser.php" class="button">{L__0026}</a></div>
					<table width="98%" cellpadding="0" cellspacing="0">
					<tr>
						<th width="15%">{L_5180}</th>
						<th width="25%">{L__0022}</th>
						<th width="28%">{L_303}</th>
						<th width="11%">{L__0025}</th>
						<th width="10%">&nbsp;</th>
						<th width="11%">{L_008}</th>
					</tr>
<!-- BEGIN busers -->
					<tr {busers.BG}>
						<td><a href="editbannersuser.php?id={busers.ID}">{busers.NAME}</a></td>
						<td>{busers.COMPANY}</td>
						<td><a href="mailto:{busers.EMAIL}">{busers.EMAIL}</a></td>
						<td>{busers.NUM_BANNERS}</td>
						<td><a href="userbanners.php?id={busers.ID}">{L__0024}</a></td>
						<td><input type="checkbox" name="delete[]" value="{busers.ID}"></td>
					</tr>
<!-- END busers -->
					</table>
					<input type="hidden" name="action" value="deleteusers">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L__0028}">
				</form>
			</div>
		</div>
