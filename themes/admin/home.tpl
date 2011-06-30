<!-- INCLUDE header.tpl -->
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<div class="box">
                	<h4 class="rounded-top">Something</h4>
                    <div class="rounded-bottom">
                    	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tincidunt varius elit non dapibus. Donec nec mauris quis metus volutpat pellentesque. Mauris justo lacus, porttitor non commodo non, tincidunt et velit. Suspendisse nulla elit, laoreet sit amet gravida vitae, iaculis interdum massa. Aliquam pretium turpis quis odio posuere id molestie risus adipiscing. Suspendisse nisi purus, feugiat quis pellentesque non, ultricies sed metus. Sed mollis leo et leo auctor gravida. Aenean accumsan lacus ut erat viverra bibendum. Nulla eu gravida quam. Phasellus sit amet est massa. Nulla pellentesque facilisis velit dignissim euismod. Sed tincidunt quam eget lorem placerat commodo. Proin ultrices, lectus rutrum posuere tincidunt, ante urna vulputate nulla, id malesuada risus nulla ut odio.
                    </div>
                </div>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
<!-- IF THIS_VERSION eq CUR_VERSION -->
            	<div class="info-box">{L_30_0212}</div>
<!-- ELSE -->
            	<div class="error-box">{L_30_0211}</div>
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
				<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
            	<table width="98%" cellpadding="1" cellspacing="0">
					<tr>
						<th colspan="2">{L_25_0025}</th>
					</tr>
					<tr>
						<td width="172"><strong>{L_528}</strong></td>
						<td>{SITEURL}</td>
					</tr>
					<tr class="bg">
						<td><strong>{L_527}</strong></td>
						<td>{SITENAME}</td>
					</tr>
					<tr>
						<td><strong>{L_540}</strong></td>
						<td>{ADMINMAIL}</td>
					</tr>
					<tr class="bg">
						<td><strong>{L_25_0026}</strong></td>
						<td>{CRON}</td>
					</tr>
					<tr>
						<td><strong>{L_663}</strong></td>
						<td>{GALLERY}</td>
					</tr>
					<tr class="bg">
						<td><strong>{L_2__0025}</strong></td>
						<td>{BUY_NOW}</td>
					</tr>
					<tr>
						<td><strong>{L_5008}</strong></td>
						<td>{CURRENCY}</td>
					</tr>
					<tr class="bg">
						<td><strong>{L_25_0035}</strong></td>
						<td>{TIMEZONE}</td>
					</tr>
					<tr>
						<td><strong>{L_363}</strong></td>
						<td>{DATEFORMAT} <small>({DATEEXAMPLE})</small></td>
					</tr>
					<tr class="bg">
						<td><strong>{L_5322}</strong></td>
						<td>{DEFULTCONTRY}</td>
					</tr>
					<tr>
						<td><strong>{L_2__0002}</strong></td>
						<td>
<!-- BEGIN langs -->
						<p>{langs.LANG}<!-- IF langs.B_DEFAULT --> ({L_2__0005})<!-- ENDIF --></p>
<!-- END langs -->
                        </td>
					</tr>
					<tr class="bg">
						<td><strong>{L_30_0214}</strong></td>
						<td>{THIS_VERSION} ({CUR_VERSION})</td>
					</tr>
				</table>
            	<table width="98%" cellpadding="1" cellspacing="0">
					<tr>
						<th colspan="4">{L_25_0031}</th>
					</tr>
					<tr>
						<td width="25%"><strong>{L_25_0055}</strong></td>
                        <td width="25%">{C_USERS}</td>
                        <td width="25%"><strong>{L_25_0055}</strong></td>
						<td width="25%">
<!-- IF USERCONF eq 0 -->
                        <strong>{L_893}</strong>: {C_IUSERS}<br>
                        <strong>{L_892}</strong>: {C_UUSERS} (<a href="{SITEURL}admin/listusers.php?usersfilter=admin_approve">{L_5295}</a>)
<!-- ELSE -->
                        {C_IUSERS}
<!-- ENDIF -->
                        </td>
					</tr>
					<tr class="bg">
						<td><strong>{L_25_0057}</strong></td>
                        <td>{C_AUCTIONS}</td>
                        <td><strong>{L_354}</strong></td>
						<td>{C_CLOSED}</td>
					</tr>
					<tr>
						<td><strong>{L_25_0059}</strong></td>
                        <td>{C_BIDS}</td>
                        <td><strong>{L_25_0063}</strong></td>
						<td>
                            <p><strong>{L_5161}</strong>: {A_PAGEVIEWS}</p>
                            <p><strong>{L_5162}</strong>: {A_UVISITS}</p>
                            <p><strong>{L_5163}</strong>: {A_USESSIONS}</p>
                        </td>
					</tr>
				</table>
            	<table width="98%" cellpadding="1" cellspacing="0">
					<tr>
						<th colspan="2">{L_080}</th>
					</tr>
					<tr>
						<td width="70%">{L_30_0032}</td>
						<td>
                            <form action="?action=clearcache" method="post">
                            	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                                <input type="submit" name="submit" value="{L_30_0031}">
                            </form>
                        </td>
					</tr>
					<tr class="bg">
						<td>{L_1030}</td>
						<td>
                            <form action="?action=updatecounters" method="post">
                            	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                            	<input type="submit" name="submit" value="{L_1031}">
                            </form>
                        </td>
					</tr>
				</table>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->