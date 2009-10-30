<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_25_0012}
		</div>
		<div class="table2">
			<table width="100%" border="0" cellpadding="4" cellspacing="1">
				<tr>
					<th colspan="2">{L_431}</th>
				</tr>
<!-- BEGIN setup_fees -->
				<tr style="background-color:{setup_fees.BGCOLOUR};">
					<td align="left">{L_240} {setup_fees.FROM} {L_241} {setup_fees.TO}</td>
					<td align="right">{setup_fees.VALUE}</td>
<!-- END setup_fees -->
				</tr>
			</table>
            <div align="center" style="text-align:center; margin-top:15px;">
<!-- IF B_SIGNUP_FEE -->
				{L_430}: {SIGNUP_FEE}
<!-- ENDIF -->
<!-- IF B_HPFEAT_FEE -->
				{L_433}: {HPFEAT_FEE}
<!-- ENDIF -->
<!-- IF B_BOLD_FEE -->
				{L_439}: {BOLD_FEE}
<!-- ENDIF -->
<!-- IF B_HL_FEE -->
				{L_434}: {HL_FEE}
<!-- ENDIF -->
<!-- IF B_RP_FEE -->
				{L_440}: {RP_FEE}
<!-- ENDIF -->
<!-- IF B_PICTURE_FEE -->
				{L_435}: {PICTURE_FEE}
<!-- ENDIF -->
<!-- IF B_RELIST_FEE -->
				{L_437}: {RELIST_FEE}
<!-- ENDIF -->
<!-- IF B_BUYNOW_FEE -->
				{L_436}: {BUYNOW_FEE}
<!-- ENDIF -->            
            </div>
		</div>
	</div>
</div>
