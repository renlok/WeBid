<!-- INCLUDE user_menu_header.tpl -->

<!-- IF B_REQUEST or B_TMPMSG -->
	<p style="background-color;#FF9933;display:block" >
	<!-- IF B_TMPMSG -->
		<b><span style="color:white">{TMPMSG}</span></b>
	<!-- ELSE -->
		<b><span style="color:white">{REQUEST}</span></b>
	<!-- ENDIF -->
	</p>
<!-- ENDIF -->

<!-- IF THISPAGE eq 'account' -->
	<ul>
		<li><a href="edit_data.php">{L_621}</a></li>
		<li><a href="yourfeedback.php">{L_208}</a></li>
		<li><a href="buysellnofeedback.php">{L_25_0003}</a> {FBTOLEAVE}</li>
		<li><a href="mail.php">{L_623}</a> {NEWMESSAGES}</li>
        <li><a href="outstanding.php">{L_422}</a></li>
	</ul>
<!-- ELSEIF THISPAGE eq 'selling' -->
	<!-- IF B_CANSELL -->
	<ul>
			<li><a href="select_category.php">{L_028}</a></li>
			<li><a href="selleremails.php">{L_25_0188}</a></li>
			<li><a href="yourauctions_p.php">{L_25_0115}</a></li>
			<li><a href="yourauctions.php">{L_203}</a></li>
			<li><a href="yourauctions_c.php">{L_204}</a></li>
			<li><a href="yourauctions_s.php">{L_2__0056}</a></li>
			<li><a href="yourauctions_sold.php">{L_25_0119}</a></li>
			<li><a href="selling.php">{L_453}</a><br></li>
	</ul>
	<!-- ELSEIF B_ONLYBUYER -->
	<form name="request" action="user_menu.php" method="post">
	<p>
		{L_25_0140} <input type="submit" name="requesttoadmin" value="{L_25_0141}"  class="button">
	</p>
	</form>
	<!-- ENDIF -->
<!-- ELSEIF THISPAGE eq 'summary' -->
	<div class="padding">
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
			<td class="titTable2">{L_593}</td>
		</tr>
		<tr>
			<td>
				{FBTOLEAVE}
				{NEWMESSAGES}
				{NO_REMINDERS}
			</td>
		</tr>
		</table>
	</div>
<!-- ELSE -->
	<ul>
		<li><a href="auction_watch.php">{L_471}</a></li>
		<li><a href="item_watch.php">{L_472}</a></li>
		<li><a href="yourbids.php">{L_620}</a></li>
		<li><a href="buying.php">{L_454}</a></li>
	</ul>
<!-- ENDIF -->

<!-- INCLUDE user_menu_footer.tpl -->