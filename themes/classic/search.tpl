<div class="tableContent2">
	<div class="titTable2">
		{L_199}
	</div>
	<div class="table2">
<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
<!-- ELSE -->
	<!-- IF NUM_AUCTIONS gt 0 -->
		<!-- INCLUDE browse.tpl -->
	<!-- ELSE -->
		<div class="padding" align="center">
			{L_198}
		</div>
	<!-- ENDIF -->
<!-- ENDIF -->
	</div>
</div>