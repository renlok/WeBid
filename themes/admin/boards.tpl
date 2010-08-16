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
            	<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5032}</h4>
				<form name="deletelogs" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
					<div class="plain-box"><b>{L_5040}</b></div>
					<table width="98%" cellspacing="0">
                    <tr>
                        <th width="6%">{L_129}</th>
                        <th>{L_294}</th>
                        <th width="10%" align="center">{L_5046}</th>
                        <th width="12%" align="center">{L_5043}</th>
                        <th width="16%">&nbsp;</th>
                    </tr>
<!-- BEGIN boards -->
                    <tr>
                        <td>{boards.ID}</td>
                        <td>
                            <a href="editboards.php?id={boards.ID}">{boards.NAME}</a>
	<!-- IF boards.ACTIVE eq 2 -->
							<b>[{L_5039}]</b>
	<!-- ENDIF -->
                        </td>
                        <td align="center">{boards.MSGTOSHOW}</td>
                        <td align="center">{boards.MSGCOUNT}</td>
                        <td align="center">
                            <input type="checkbox" name="delete[]" value="{boards.ID}">
                        </td>
                    </tr>
<!-- END boards -->
                    <tr>
                        <td colspan="4" align="right">{L_30_0102}</td>
                        <td align="center"><input type="checkbox" class="selectall" name="delete"></td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="delete">
                    <input type="submit" name="act" class="centre" value="{L_008}">
				</form>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->