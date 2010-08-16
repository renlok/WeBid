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
            	<h4 class="rounded-top rounded-bottom">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_516}</h4>
<!-- IF ERROR ne '' -->
				<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
                <div class="plain-box">{NEWS_COUNT}{L_517} <a href="addnew.php">{L_518}</a></div>
                <table width="98%" cellpadding="0" cellspacing="0">
                <tr>
                	<th width="20%">{L_314}</th>
                	<th width="60%">{L_312}</th>
                	<th>{L_297}</th>
                </tr>
<!-- BEGIN news -->
                <tr {news.BG}>
                	<td>{news.DATE}</td>
                	<td <!-- IF news.SUSPENDED eq 1 -->style="background: #FAD0D0; color: #B01717; font-weight: bold;"<!-- ENDIF -->>{news.TITLE}</td>
                	<td>
                    	<a href="editnew.php?id={news.ID}&PAGE={PAGE}">{L_298}</a><br>
						<a href="deletenew.php?id={news.ID}&PAGE={PAGE}">{L_008}</a>
                    </td>
                </tr>
<!-- END news -->
                </table>
                <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td align="center">
                            {L_5117}&nbsp;&nbsp;{PAGE}
                            {L_5118}&nbsp;&nbsp;{PAGES}
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
<!-- INCLUDE footer.tpl -->