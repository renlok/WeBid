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
            	<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5032}&nbsp;&gt;&gt;&nbsp;{BOARD_NAME}&nbsp;&gt;&gt;&nbsp;{L_5276}</h4>
				<form name="editmessage" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <tr>
                            <td width="24%" valign="top">{L_5059}</td>
                            <td>
                                <textarea rows="8" cols="40" name="message">{MESSAGE}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>{L_5060}</td>
                            <td>{USER} - {POSTED}</td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="{BOARD_ID}">
                    <input type="hidden" name="msg" value="{MSG_ID}">
                    <input type="submit" name="act" class="centre" value="{L_530}">
				</form>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->