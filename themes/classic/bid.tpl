<!-- IF TQTY gt 1 -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#qty").keyup(function(){
			$("#bidcost").html((parseFloat(($("#qty").val()) * ($("#bid").val()))).toFixed(2) + ">{CURRENCY}</a>");
		});
		$("#qty").click(function(){
			$("#bidcost").html((parseFloat(($("#qty").val()) * ($("#bid").val()))).toFixed(2) + ">{CURRENCY}</a>");
		});
		$("#bid").keyup(function(){
			$("#bidcost").html((parseFloat(($("#qty").val()) * ($("#bid").val()))).toFixed(2) + ">{CURRENCY}</a>");
		});
	});
</script>
<!-- ENDIF -->
<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			<!-- IF PAGE eq 1 -->{L_152}<!-- ELSE -->{L_271}<!-- ENDIF -->
		</div>
		<div class="titTable3">
			<a href="{SITEURL}item.php?id={ID}">{L_138}</a>{BID_HISTORY}
		</div>
		<div class="table2 padding" style="text-align:center;">
<!-- IF PAGE eq 1 -->
	<!-- IF ERROR ne '' -->
			<div class="error-box">
				{ERROR}
			</div>
	<!-- ENDIF -->
			<form name="bid" action="{SITEURL}bid.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<table width="60%" border=0 cellpadding="4" style="text-align:left;">
					<tr>
						<td rowspan="6">{IMAGE}</td>
						<td><b>{L_154}</b></td>
						<td>{TITLE}</td>
					</tr>
					<tr bgcolor="#FFFEEE">
						<td><b>{L_116}</b></td>
						<td>{CURRENT_BID}</td>
					</tr>
					<tr>
						<td><b>{L_156}</b></td>
						<td><input type="text" size="5" name="bid" id="bid" value="{BID}">
							<!-- IF ATYPE eq 1 -->({L_283}: {NEXT_BID})<!-- ENDIF --></td>
					</tr>
	<!-- IF TQTY gt 1 -->
					<tr bgcolor="#FFFEEE">
						<td><b>{L_284}:</b></td>
						<td><input type="number" name="qty" id="qty" value="{QTY}" min="1" max="{TQTY}" step="1"></td>
					</tr>
	<!-- ENDIF -->
	<!-- IF B_USERAUTH -->
					<tr>
						<td><b>{L_003}</b></td>
						<td><b>{YOURUSERNAME}</b>
						</td>
					</tr>
					<tr bgcolor="#FFFEEE">
						<td><b>{L_004}</b></td>
						<td><input type="password" name="password" size="20"  value="">
						</td>
					</tr>
	<!-- ENDIF -->
				</table>
				<div style="text-align:center; margin-top:20px;">
					<input type="hidden" name="id" value="{ID}">
					<p>{AGREEMENT}</p>
					<input type="hidden" name="action" value="bid">
					<input type="submit" name="Input" value="{L_5199}" class="button">
				</div>
			</form>
<!-- ELSE -->
			{L_272}&nbsp;
			<a href="{SITEURL}item.php?id={ID}"><b>{TITLE}</b></a><br>
			{L_699} {BID} {L_700}
<!-- ENDIF -->
		</div>
	</div>
</div>