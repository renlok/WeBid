<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	$("#startall").click(function() {
		$("input[@class=startnow]").each(function() {
			if (this.checked) {
				this.checked = false;
			} else {
				this.checked = true;
			}
		});
		return false;
	});
	$("#deleteall").click(function() {
		$("input[@class=O_delete]").each(function() {
			if (this.checked) {
				this.checked = false;
			} else {
				this.checked = true;
			}
		});
		return false;
	});
	$("#processdel").submit(function() {
		if (confirm('{L_30_0087}')){
			return true;
		} else {
			return false;
		}
	});
});
</script>
<form name="open" method="post" action="" id="processdel">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="right">
			<dl class="phpa-tabs">
				<dd><a href="yourauctions.php">{L_619}</a></dd>
				<dd><a href="yourauctions_c.php">{L_204}</a></dd>
				<dd><a href="yourauctions_s.php">{L_2__0056}</a></dd>
				<dd><a href="yourauctions_sold.php">{L_25_0119}</a></dd>
			</dl>
		</td>
	</tr>
</table>
	<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
	<tr bgcolor="{TBLHEADERCOLOUR}">
			<td class="titTable1">
				<a href="yourauctions_p.php?pa_ord=title&pa_type={ORDERNEXT}">{L_624}</a>
<!-- IF ORDERCOL eq 'title' -->
				<a href="yourauctions_p.php?pa_ord=title&pa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="15%">
				<a href="yourauctions_p.php?pa_ord=starts&pa_type={ORDERNEXT}">{L_25_0116}</a>
<!-- IF ORDERCOL eq 'starts' -->
				<a href="yourauctions_p.php?pa_ord=starts&pa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="15%">
				<a href="yourauctions_p.php?pa_ord=ends&pa_type={ORDERNEXT}">{L_25_0117}</a>
<!-- IF ORDERCOL eq 'ends' -->
				<a href="yourauctions_p.php?pa_ord=ends&pa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="10%" align="center">
				{L_298}
			</td>
			<td class="titTable1" width="10%" align="center">
				{L_008}
			</td>
			<td class="titTable1" width="9%" align="center" bgcolor="#FFFF00">
				{L_25_0118}
			</td>
		</tr>
<!-- IF B_AREITEMS -->
	<!-- BEGIN items -->
		<tr bgcolor="{items.BGCOLOUR}">
			<td width="32%">
				<a href="item.php?id={items.ID}">{items.TITLE}</a>
			</td>
			<td width="11%" bgcolor="#FFFFAA">
				{items.STARTS}
			</td>
			<td width="11%">
				{items.ENDS}
			</td>
			<td width="6%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
				<a href="edit_active_auction.php?id={items.ID}"><img src="images/edititem.gif" width="13" height="17" alt="{L_512}" border="0"></a>
		<!-- ENDIF -->
			</td>
			<td width="8%" align="center">
		<!-- IF items.B_HASNOBIDS -->
				<input type="checkbox" name="O_delete[]" value="{items.ID}" class="O_delete">
		<!-- ENDIF -->
			</td>
			<td width="6%" align="center">
				<input type="checkbox" name="startnow[]" value="{items.ID}" class="startnow">
			</td>
		</tr>
	<!-- END items -->
<!-- ENDIF -->
	<tr bgcolor="{BGCOLOUR}">
	  <td colspan="4">&nbsp;</td>
	  <td align="center"><a href="#" id="deleteall">{L_30_0102}</a></td>
	  <td align="center"><a href="#" id="startall">{L_30_0102}</a></td>
	</tr>
		<tr>
			<td colspan="10" align="center">
				<input type="hidden" name="action" value="delopenauctions">
				<input type="submit" name="Submit" value="{L_631}" class="button">
			</td>
		</tr>
	</table>
</form>

<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td align="center">
			{L_5117}&nbsp;&nbsp;{PAGE}
			{L_5118}&nbsp;&nbsp;{PAGES}
			<br>
			{PREV}
<!-- BEGIN pages -->
			{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
			{NEXT}
		</td>
	</tr>
</table>

<!-- INCLUDE user_menu_footer.tpl -->