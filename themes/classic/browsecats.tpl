<div class="tableContent2">
	<div class="titTable2 rounded-top rounded-bottom">
		<a href="browse.php?id=0">{L_287}</a> : {CAT_STRING}
	</div>
	<div class="table2">
<!-- IF TOP_HTML ne '' -->
		<table width="98%" border="0" cellspacing="0" cellpadding="4">
			{TOP_HTML}
		</table>
<!-- ENDIF -->
		<br>
<!-- IF NUM_AUCTIONS gt 0 -->
	<!-- IF ID gt 0 -->
		<form name="catsearch" action="?id={ID}" method="post">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<table width="98%" border="0" cellspacing="0" cellpadding="4" class="catsearch">
				<tr>
					<td>{L_30_0070}&nbsp;<input type="text" name="catkeyword" size="20">&nbsp;<input type="submit" name="" value="{L_103}" class="button">
					&nbsp;&nbsp;<a href="{SITEURL}adsearch.php">{L_464}</a></td>
				</tr>
			</table>
		</form>
	<!-- ENDIF -->
	<!-- INCLUDE browse.tpl -->
<!-- ELSE -->
		<div class="padding" align="center">
			{L_198}
		</div>
<!-- ENDIF -->
	</div>
</div>