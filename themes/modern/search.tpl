<div class="row">
	<div class="col-md-12">
		<legend>{L_199}</legend>
<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
<!-- ELSE -->
	<!-- IF NUM_AUCTIONS gt 0 -->
		<!-- INCLUDE browse.tpl -->
	<!-- ELSE -->
		<div class="alert alert-danger" role="alert">
			{L_198}
		</div>
	<!-- ENDIF -->
<!-- ENDIF -->
	</div>
</div>