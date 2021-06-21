<!-- INCLUDE user_menu_header.tpl -->

<!-- IF TMPMSG ne '' -->
	<p style="background-color;#FF9933;display:block" >
		<b><span style="color:white;">{TMPMSG}</span></b>
	</p>
<!-- ENDIF -->
	<div class="padding">
<!-- IF THISPAGE eq 'account' -->
		<ul class="padding">
			<li><a href="yourfeedback.php">{L_208}</a></li>
			<li><a href="buysellnofeedback.php">{L_207}</a> {FBTOLEAVE}</li>
			<li><a href="mail.php">{L_623}</a> {NEWMESSAGES}</li>
			<li><a href="outstanding.php">{L_422}</a></li>
			<li><a href="invoices.php">{L_1057}</a></li>
		</ul>
		<div class="bigfont underline padding">{L_244}</div>
		<ul class="padding">
			<li><a href="selleremails.php">{L_25_0188}</a></li>
			<li><a href="edit_data.php">{L_621}</a></li>
		</ul>
<!-- ELSEIF THISPAGE eq 'selling' -->
	<!-- IF B_CANSELL -->
		<ul class="padding">
			<li><a href="yourauctions_p.php">{L_25_0115}</a></li>
			<li><a href="yourauctions.php">{L_203}</a></li>
			<li><a href="yourauctions_c.php">{L_204}</a></li>
			<li><a href="yourauctions_s.php">{L_2__0056}</a></li>
			<li><a href="yourauctions_sold.php">{L_25_0119}</a></li>
			<li><a href="selling.php">{L_453}</a><br></li>
		</ul>
	<!-- ELSEIF B_CANREQUESTSELL -->
		<form name="request" action="" method="post">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<p>{L_25_0140}</p>
			<p><input type="submit" name="requesttoadmin" value="{L_25_0141}" class="button"></p>
		</form>
	<!-- ENDIF -->
<!-- ELSEIF THISPAGE eq 'summary' -->
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
			<tr>
				<td class="titTable2">{L_593}</td>
			</tr>
			<tr>
				<td>
					{FBTOLEAVE}
					{NEWMESSAGES}
					{NO_REMINDERS}
					{TO_PAY}
					{BENDING_SOON}
					{BOUTBID}
					{SOLD_ITEMS}
				</td>
			</tr>
		</table>
<!-- ELSE -->
		<ul class="padding">
			<li><a href="auction_watch.php">{L_471}</a></li>
			<li><a href="item_watch.php">{L_472}</a></li>
			<li><a href="yourbids.php">{L_620}</a></li>
			<li><a href="buying.php">{L_454}</a></li>
		</ul>
<!-- ENDIF -->
	</div>

<!-- INCLUDE user_menu_footer.tpl -->
