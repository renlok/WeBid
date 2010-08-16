<!-- INCLUDE header.tpl -->
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<div class="box">
                	<h4 class="rounded-top">{L_5436}</h4>
                    <div class="rounded-bottom">
                    	<ul class="menu">
                        	<li><a href="{SITEURL}admin/maintainance.php">{L__0001}</a></li>
                        	<li><a href="{SITEURL}admin/wordsfilter.php">{L_5068}</a></li>
                        	<li><a href="{SITEURL}admin/errorlog.php">{L_891}</a></li>
                        </ul>
                    </div>
                </div>
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
            	<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_525}</h4>
				<form name="errorlog" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
					<div class="plain-box"><a href="newadminuser.php">{L_367}</a></div>
                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <th width="30%">{L_003}</th>
                            <th width="16%">{L_558}</th>
                            <th width="19%">{L_559}</th>
                            <th width="12%">{L_560}</th>
                            <th width="23%">{L_561}</th>
                        </tr>
<!-- BEGIN users -->
                        <tr {users.BG}>
                            <td><a href="editadminuser.php?id={users.ID}">{users.USERNAME}</a></td>
                            <td align="center">{users.CREATED}</td>
                            <td align="center">{users.LASTLOGIN}</td>
                            <td align="center">{users.STATUS}</td>
                            <td align="center"><input type="checkbox" name="delete[]" value="{users.ID}"></td>
                        </tr>
<!-- END users -->
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="submit" name="Submit" value="{L_561}">
				</form>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->