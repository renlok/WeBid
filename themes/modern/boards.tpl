<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<legend>
			{L_5030}
		</legend>
		<div class="panel panel-default">
			<table class="table table-striped table-bordered table-condensed">
				<tr>
					<th width="50%" valign="top">
						{L_5034}
					</th>
					<th width="25%" valign="top">
						{L_5043}
					</th>
					<th width="25%" valign="top">
						{L_5053}
					</th>
				</tr>
<!-- BEGIN boards -->
				<tr>
					<td width="50%" valign="top">
						<a href="{SITEURL}msgboard.php?board_id={boards.ID}">{boards.NAME}</a>
					</td>
					<td width="25%" valign="top" align="center">
						{boards.NUMMSG}
					</td>
					<td width="25%" valign="top" align="center">
						{boards.LASTMSG}
					</td>
				</tr>
<!-- END boards -->
			</table>
		</div>
	</div>
</div>