<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<legend>{L_25_0012}</legend>
		<div class="row">
			<div class="col-md-8">
<!-- IF B_SETUP_FEE -->
				<table class="table table-striped table-bordered table-condensed">
					<tr>
						<th colspan="2">{L_431}</th>
					</tr>
	<!-- BEGIN setup_fees -->
					<tr {setup_fees.BGCOLOUR}>
						<td align="left">{L_240} {setup_fees.FROM} {L_241} {setup_fees.TO}</td>
						<td align="right">{setup_fees.VALUE}</td>
	<!-- END setup_fees -->
					</tr>
				</table>
<!-- ENDIF -->
<!-- IF B_BUYER_FEE -->
				<table class="table table-striped table-bordered table-condensed">
					<tr>
						<th colspan="2">{L_775}</th>
					</tr>
	<!-- BEGIN buyer_fee -->
					<tr {buyer_fee.BGCOLOUR}>
						<td align="left">{L_240} {buyer_fee.FROM} {L_241} {buyer_fee.TO}</td>
						<td align="right">{buyer_fee.VALUE}</td>
	<!-- END buyer_fee -->
					</tr>
				</table>
<!-- ENDIF -->
<!-- IF B_ENDAUC_FEE -->
				<table class="table table-striped table-bordered table-condensed">
					<tr>
						<th colspan="2">{L_791}</th>
					</tr>
	<!-- BEGIN endauc_fee -->
					<tr {endauc_fee.BGCOLOUR}>
						<td align="left">{L_240} {endauc_fee.FROM} {L_241} {endauc_fee.TO}</td>
						<td align="right">{endauc_fee.VALUE}</td>
	<!-- END endauc_fee -->
					</tr>
				</table>
<!-- ENDIF -->
			</div>
			<div class="col-md-4">
				<div class="well well-sm">
<!-- IF B_SIGNUP_FEE -->
					<p>{L_430}: {SIGNUP_FEE}</p>
<!-- ENDIF -->
<!-- IF B_HPFEAT_FEE -->
					<p>{L_433}: {HPFEAT_FEE}</p>
<!-- ENDIF -->
<!-- IF B_BOLD_FEE -->
					<p>{L_439}: {BOLD_FEE}</p>
<!-- ENDIF -->
<!-- IF B_HL_FEE -->
					<p>{L_434}: {HL_FEE}</p>
<!-- ENDIF -->
<!-- IF B_RP_FEE -->
					<p>{L_440}: {RP_FEE}</p>
<!-- ENDIF -->
<!-- IF B_PICTURE_FEE -->
					<p>{L_435}: {PICTURE_FEE}</p>
<!-- ENDIF -->
<!-- IF B_RELIST_FEE -->
					<p>{L_437}: {RELIST_FEE}</p>
<!-- ENDIF -->
<!-- IF B_BUYNOW_FEE -->
					<p>{L_436}: {BUYNOW_FEE}</p>
<!-- ENDIF -->
<!-- IF B_EXCAT_FEE -->
					<p>{L_804}: {EXCAT_FEE}</p>
<!-- ENDIF -->
<!-- IF B_SUBTITLE_FEE -->
					<p>{L_803}: {SUBTITLE_FEE}</p>
<!-- ENDIF -->
				</div>
			</div>
		</div>
	</div>
</div>