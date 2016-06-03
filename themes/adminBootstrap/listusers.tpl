		<script type="text/javascript">
			$(document).ready(function() {
				$('#userfilter').change(function(){
					$('#filter').submit();
				});
			});
		</script>
		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}</h4>
				<div class="plain-box">{TOTALUSERS} {L_301}</div>
				<table width="98%" cellpadding="0" cellspacing="0">
					<tr bgcolor="#FFFF66">
						<td colspan="4">
							<form name="search" action="" method="post">
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
								<p>{L_5024}</p>
								{L_5022} <input type="text" name="keyword" size="25"> <input type="submit" name="submit" value="{L_5023}">
							</form>
						</td>
						<td align="right" colspan="4">
							<form name="filter" id="filter" action="" method="get">
								<select name="usersfilter" id="userfilter">
									<option value="all">{L_5296}</option>
									<option value="active" <!-- IF USERFILTER eq 'active' -->selected<!-- ENDIF -->>{L_5291}</option>
									<option value="admin" <!-- IF USERFILTER eq 'admin' -->selected<!-- ENDIF -->>{L_5294}</option>
									<option value="fee" <!-- IF USERFILTER eq 'fee' -->selected<!-- ENDIF -->>{L_5293}</option>
									<option value="confirmed" <!-- IF USERFILTER eq 'confirmed' -->selected<!-- ENDIF -->>{L_5292}</option>
									<option value="admin_approve" <!-- IF USERFILTER eq 'admin_approve' -->selected<!-- ENDIF -->>{L_25_0136}</option>
								</select>
								<input type="submit" value="{L_5029}" />
							</form>
						</td>
					</tr>
					<tr>
						<th width="15%"><b>{L_293}</b></th>
						<th width="15%"><b>{L_294}</b></th>
						<th width="15%"><b>{L_295}</b></th>
						<th width="15%"><b>{L_296}</b></th>
						<th width="10%"><b>{L_25_0079}</b></th>
						<th width="10%"><b>{L_763}</b></th>
						<th width="10%"><b>{L_560}</b></th>
						<th width="10%"><b>{L_297}</b></th>
					</tr>
<!-- BEGIN users -->
					<tr {users.BG}>
						<td>
							<b>{users.NICK}</b><br>
							&nbsp;<a href="listauctions.php?uid={users.ID}&offset={PAGE}" class="small">{L_5094}</a><br>
							&nbsp;<a href="userfeedback.php?id={users.ID}&offset={PAGE}" class="small">{L_503}</a><br>
							&nbsp;<a href="viewuserips.php?id={users.ID}&offset={PAGE}" class="small">{L_2_0004}</a>
						</td>
						<td>{users.NAME}</td>
						<td>{users.COUNTRY}</td>
						<td><a href="mailto:{users.EMAIL}">{users.EMAIL}</a></td>
						<td align="center">{users.NEWSLETTER}</td>
						<td align="center">
							{users.BALANCE}
	<!-- IF users.BALANCE_CLEAN lt 0 -->
							<p><a href="listusers.php?payreminder=1&id={users.ID}&offset={PAGE}"><small>{L_764}</small></a></p>
	<!-- ENDIF -->
						</td>
						<td>
	<!-- IF users.SUSPENDED eq 0 -->
							<b><span style="color:green;">{L_5291}</span></b>
	<!-- ELSEIF users.SUSPENDED eq 1 -->
							<b><span style="color:violet;">{L_5294}</span></b>
	<!-- ELSEIF users.SUSPENDED eq 7 -->
							<b><span style="color:red;">{L_5297}</span></b>
	<!-- ELSEIF users.SUSPENDED eq 8 -->
							<b><span style="color:orange;">{L_5292}</span></b><br>
							<a href="listusers.php?resend=1&id={users.ID}&offset={PAGE}"><small>{L_25_0074}</small></a>
	<!-- ELSEIF users.SUSPENDED eq 9 -->
							<b><span style="color:red;">{L_5293}</span></b>
	<!-- ELSEIF users.SUSPENDED eq 10 -->
							<b><small style="color:orange;"><a href="excludeuser.php?id={users.ID}&offset={PAGE}">{L_25_0136}</a></small></b>
	<!-- ENDIF -->
						</td>
						<td nowrap>
							<a href="edituser.php?userid={users.ID}&offset={PAGE}"><small>{L_298}</small></a><br>
							<a href="deleteuser.php?id={users.ID}&offset={PAGE}"><small>{L_008}</small></a><br>
							<a href="excludeuser.php?id={users.ID}&offset={PAGE}"><small>
	<!-- IF users.SUSPENDED eq 0 -->
								{L_305}
	<!-- ELSEIF users.SUSPENDED eq 8 -->
								{L_515}
	<!-- ELSE -->
								{L_299}
	<!-- ENDIF -->
							</small></a>
						</td>
					</tr>
<!-- END users -->
				</table>
				<table width="98%" cellpadding="0" cellspacing="0" class="blank">
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
			</div>
		</div>