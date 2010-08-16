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
            	<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_525}&nbsp;&gt;&gt;&nbsp;{L_562}</h4>
                <form name="editadmin" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <tr>
                            <td>{L_003}</td>
                            <td>{USERNAME}</td>
                        </tr>
                        <tr>
                            <td>{L_558}</td>
                            <td>{CREATED}</td>
                        </tr>
                        <tr>
                            <td>{L_559}</td>
                            <td>{LASTLOGIN}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{L_563}</td>
                        </tr>
                        <tr>
                            <td>{L_004}</td>
                            <td><input type="password" name="password" size="25"></td>
                        </tr>
                        <tr>
                            <td>{L_564}</td>
                            <td><input type="password" name="repeatpassword" size="25"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                            	<input type="radio" name="status" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_566}<br>
                  				<input type="radio" name="status" value="2"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_567}
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="{ID}">
                    <input type="submit" name="act" class="centre" value="{L_530}">
                </form>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->