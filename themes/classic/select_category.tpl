<style type="text/css">.box {height: 100; width:300;}</style>
<script type="text/javascript">
function SubmitBoxes(N)
{
	$('#catformbox').val(N);
	$('#catform').submit();
}
</script>
<div class="content">
	<div class="tableContent2">
		<div class="titTable2">{L_028}</div>
<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
<!-- ENDIF -->
		<a name="goto"></a>
		<form name="catform" id="catform" action="select_category.php#goto" method="post">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<input type="hidden" name="action" value="process">
			<input type="hidden" name="box" value="" id="catformbox">
			<input type="hidden" name="cat_no" value="{CAT_NO}">
			<table width="80%" border="0" cellpadding="4" class="content centre">
				<tr>
					<td colspan="2" valign="top">
						<!-- IF CAT_NO eq 2 -->{L_2__0041} {COST}<!-- ELSE -->{L_2__0038}<!-- ENDIF -->
					</td>
				</tr>
				<tr>
<!-- BEGIN boxes -->
					<td align="center" style="width:{boxes.PERCENT}%;">
						<select name="cat{boxes.I}" class="box" size="15" onchange="SubmitBoxes({boxes.I})" style="width:230px;">
	<!-- BEGIN cats -->
							<option value="{boxes.cats.K}" {boxes.cats.SELECTED}>{boxes.cats.CATNAME}</option>
	<!-- END cats -->
						</select>
					</td>
	<!-- IF boxes.B_NOWLINE -->
				</tr>
				<tr>
	<!-- ENDIF -->
<!-- END boxes -->
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3" >
<!-- IF B_SHOWBUTTON -->
						<input type="submit" name="submitit" value="<!-- IF B_EDITING -->{L_25_0168}<!-- ELSE -->{L_2__0047}<!-- ENDIF -->" class="button">
<!-- ENDIF -->
					</td>
				</tr>
			</table>
		</form>
<!-- IF CAT_NO eq 2 && ! B_SHOWBUTTON -->
		<div class="padding" style="text-align:right;">
			<form name="catform" action="sell.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="act" value="skipexcat">
				<input type="submit" name="submitit" value="{L_805}" class="button">
			</form>
		</div>
<!-- ENDIF -->
	</div>
</div>
