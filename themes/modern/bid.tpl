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
<div class="row">
	<div class="col-md-12">
		<div class="col-md-8 col-md-offset-2 well">
			<legend>
				<!-- IF PAGE eq 1 -->{L_152}<!-- ELSE -->{L_271}<!-- ENDIF -->
			</legend>
			<div class="row">
				<div class="col-md-6">
					<nav>
						<ul class="pager">
							<li class="previous"><a href="{SITEURL}item.php?id={ID}"><span aria-hidden="true">&larr;</span>{L_138}</a></li>
							<li>{BID_HISTORY}</li>
						</ul>
					</nav>
				</div>
			</div>
<!-- IF PAGE eq 1 -->
	<!-- IF ERROR ne '' -->
			<div class="alert alert-danger" role="alert">
				{ERROR}
			</div>
	<!-- ENDIF -->
			<form class="form-horizontal" name="bid" action="{SITEURL}bid.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="col-md-12 text-center">{IMAGE}</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="col-sm-5 control-label">{L_154}</label>
						<div class="col-sm-7"><p class="form-control-static">{TITLE}</p></div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label">{L_116}</label>
						<div class="col-sm-7"><p class="form-control-static">{CURRENT_BID}</p></div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label">{L_156}</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="bid" id="bid" value="{BID}">
							<!-- IF ATYPE eq 1 -->({L_283}: {NEXT_BID})<!-- ENDIF -->
						</div>
					</div>
	<!-- IF TQTY gt 1 -->
					<div class="form-group">
						<label class="col-sm-5 control-label">{L_284}:</label>
						<div class="col-sm-7">
							<input type="number" class="form-control" name="qty" id="qty" value="{QTY}" min="1" max="{TQTY}" step="1">
						</div>
					</div>
	<!-- ENDIF -->
	<!-- IF B_USERAUTH -->
					<div class="form-group">
						<label class="col-sm-5 control-label">{L_003}</label>
						<div class="col-sm-7"><p class="form-control-static">{YOURUSERNAME}</p></div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label">{L_004}</label>
						<div class="col-sm-7"><input type="password" name="password" class="form-control"  value="">
						</div>
					</div>
	<!-- ENDIF -->
					<div class="text-center">
						<input type="hidden" name="id" value="{ID}">
						<div class="alert alert-success" role="alert">{AGREEMENT}</div>
						<input type="hidden" name="action" value="bid">
						<input type="submit" name="Input" value="{L_5199}" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
<!-- ELSE -->
		<div class="alert alert-success" role="alert">
			{L_699} {BID} {L_700}<br>
			{L_272}&nbsp;
			<a href="{SITEURL}item.php?id={ID}"><b>{TITLE}</b></a><br>
		</div>
<!-- ENDIF -->
	</div>
</div>