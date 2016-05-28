<!-- INCLUDE user_menu_header.tpl -->
<div class="row">
	<div class="col-md-2">
		<div class="text-center outbid"><p class="text-warning">{L_30_0098}</p></div>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<table class="table table-bordered table-condensed table-striped">
				<tr>
					<th align="center">
						{L_168}
					</th>
					<th width="15%" align="center">
						{L_461}
					</th>
					<th width="15%" align="center">
						{L_116}
					</th>
					<th width="15%" align="center">
						{L_171}
					</th>
				</tr>
<!-- BEGIN bids -->
				<tr {bids.BGCOLOUR}>
					<td align="left">
						<a href="item.php?id={bids.ID}">{bids.TITLE}</a>
					</td>
					<td>
						<!-- IF bids.QTY gt 1 -->{bids.BID} x {bids.QTY} {L_5492}<!-- ENDIF -->
						<!-- IF bids.PROXYBID ne '' --><p><span class="smallspan">{bids.PROXYBID}</span></p><!-- ENDIF -->
					</td>
					<td>
						{bids.CBID}
					</td>
					<td align="center">
						{bids.TIMELEFT}
					</td>
				</tr>
<!-- END bids -->
<!-- IF NUM_BIDS eq 0 -->
				<tr align="center">
					<td colspan="5">&nbsp;</td>
				</tr>
<!-- ENDIF -->
			</table>
		</div>
	</div>
</div>

<!-- INCLUDE user_menu_footer.tpl -->
