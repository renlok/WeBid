        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                                <div class="x_title">
                                   <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_045}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<div class="plain-box">{TOTALUSERS} {L_301}</div>
                <table class="table table-bordered table-striped">
                	<tr>
                        <td colspan="4">
                            <form name="search" action="" method="post" class="form-inline">
                            <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                            	<p>{L_5024}</p>
                                <div class="form-group">
    <label for="exampleInputName2">{L_5022} </label>
                        <input type="text" name="keyword" class="form-control">
                        <input type="submit" name="submit" value="{L_5023}" class="btn btn-primary"></div>
                            </form>
                        </td>
                        <td align="right" colspan="4">
                            <form name="filter" id="filter" action="" method="get" class="form-inline">
                             <div class="form-group">
                                <select name="usersfilter" id="userfilter" class="form-control">
                                    <option value="all">{L_all_users}</option>
                                    <option value="active" <!-- IF USERFILTER eq 'active' -->selected<!-- ENDIF -->>{L_active_users}</option>
                                    <option value="admin" <!-- IF USERFILTER eq 'admin' -->selected<!-- ENDIF -->>{L_suspended_by_admin}</option>
                                    <option value="fee" <!-- IF USERFILTER eq 'fee' -->selected<!-- ENDIF -->>{L_signup_fee_unpaid}</option>
                                    <option value="confirmed" <!-- IF USERFILTER eq 'confirmed' -->selected<!-- ENDIF -->>{L_account_never_confirmed}</option>
                                    <option value="admin_approve" <!-- IF USERFILTER eq 'admin_approve' -->selected<!-- ENDIF -->>{L_25_0136}</option>
                                </select>
                                <input type="submit" value="{L_5029}" class="btn btn-primary" /></div>
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
                    <tr<!-- IF users.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
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
                            <b><span style="color:green;">{L_active_users}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 1 -->
                            <b><span style="color:violet;">{L_suspended_by_admin}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 7 -->
                            <b><span style="color:red;">{L_5297}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 8 -->
                            <b><span style="color:orange;">{L_account_never_confirmed}</span></b><br>
                            <a href="listusers.php?resend=1&id={users.ID}&offset={PAGE}"><small>{L_25_0074}</small></a>
    <!-- ELSEIF users.SUSPENDED eq 9 -->
                            <b><span style="color:red;">{L_signup_fee_unpaid}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 10 -->
                            <b><small style="color:orange;"><a href="excludeuser.php?id={users.ID}&offset={PAGE}">{L_25_0136}</a></small></b>
    <!-- ENDIF -->
                        </td>
                        <td nowrap>
                            <a href="edituser.php?userid={users.ID}&offset={PAGE}"><small>{L_298}</small></a><br>
                            <a href="deleteuser.php?id={users.ID}&offset={PAGE}"><small>{L_008}</small></a><br>
                            <a href="excludeuser.php?id={users.ID}&offset={PAGE}"><small>
    <!-- IF users.SUSPENDED eq 0 -->
                                {L_suspend_user}
    <!-- ELSEIF users.SUSPENDED eq 8 -->
                                {L_activate_user}
    <!-- ELSE -->
                                {L_activate_user}
    <!-- ENDIF -->
                            </small></a>
                        </td>
                    </tr>
<!-- END users -->
                </table>
                <table>
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
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
