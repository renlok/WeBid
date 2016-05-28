<style type="text/css">.box {height: 100; width:300;}</style>
<script type="text/javascript">
function SubmitBoxes(N)
{
	$('#catformbox').val(N);
	$('#catform').submit();
}
</script>
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6 col-sm-offset-3 well">
			<legend>{L_028}</legend>
<!-- IF ERROR ne '' -->
			<div class="alert alert-danger" role="alert">
				{ERROR}
			</div>
<!-- ENDIF -->
			<div class="row">
				<a name="goto"></a>
				<form name="catform" id="catform" action="select_category.php#goto" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="hidden" name="action" value="process">
					<input type="hidden" name="box" value="" id="catformbox">
					<input type="hidden" name="cat_no" value="{CAT_NO}">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group">
							<label><!-- IF CAT_NO eq 2 -->{L_2__0041} {COST}<!-- ELSE -->{L_2__0038}<!-- ENDIF --></label>
<!-- BEGIN boxes -->
							<select name="cat{boxes.I}" class="form-control" onchange="SubmitBoxes({boxes.I})">
								<option value="any"}>{L_2__0047}</option>
	<!-- BEGIN cats -->
								<option value="{boxes.cats.K}" {boxes.cats.SELECTED}>{boxes.cats.CATNAME}</option>
	<!-- END cats -->
							</select>
							<br>
	<!-- IF boxes.B_NOWLINE -->
	<!-- ENDIF -->
<!-- END boxes -->
						</div>
					</div>
<!-- IF B_SHOWBUTTON -->
					<div class="text-center">
						<input type="submit" name="submitit" value="<!-- IF B_EDITING -->{L_25_0168}<!-- ELSE -->{L_2__0047}<!-- ENDIF -->" class="btn btn-primary">
					</div>
<!-- ENDIF -->
				</form>
			</div>
<!-- IF CAT_NO eq 2 && ! B_SHOWBUTTON -->
			<div class="text-center">
				<form name="catform" action="sell.php" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="hidden" name="act" value="skipexcat">
					<input type="submit" name="submitit" value="{L_805}" class="btn btn-primary">
				</form>
			</div>
<!-- ENDIF -->
		</div>
	</div>
</div>