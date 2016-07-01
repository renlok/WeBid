<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	$("#startall").click(function() {
		var checked_status = this.checked;
		$("input[name='startnow[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#deleteall").click(function() {
		var checked_status = this.checked;
		$("input[name='O_delete[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#processdel").submit(function() {
		if (confirm('{L_30_0087}'))
		{
			return true;
		}
		else
		{
			return false;
		}
	});
});
</script>
<!-- IF USER_MESSAGE ne '' -->
<div class="success-box">{USER_MESSAGE}</div>
<!-- ENDIF -->
<form name="open" method="post" action="" id="processdel">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<dl class="tabs">
		<dd><a href="yourauctions.php">{L_619}</a></dd>
		<dd class="active"><a href="yourauctions_p.php">{L_25_0115}</a></dd>
		<dd><a href="yourauctions_c.php">{L_204}</a></dd>
		<dd><a href="yourauctions_s.php">{L_2__0056}</a></dd>
		<dd><a href="yourauctions_sold.php">{L_25_0119}</a></dd>
	</dl>
	<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
		<tr>
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
		<tr {items.BGCOLOUR}>
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
				<input type="checkbox" name="O_delete[]" value="{items.ID}">
		<!-- ENDIF -->
			</td>
			<td width="6%" align="center">
				<input type="checkbox" name="startnow[]" value="{items.ID}">
			</td>
		</tr>
	<!-- END items -->
<!-- ENDIF -->
		<tr {BGCOLOUR}>
			<td colspan="4" align="right">{L_30_0102}</td>
			<td align="center"><input type="checkbox" id="deleteall"></td>
			<td align="center"><input type="checkbox" id="startall"></td>
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
			{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
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
