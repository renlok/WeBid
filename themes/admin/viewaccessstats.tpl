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
            	<h4 class="rounded-top rounded-bottom">{L_25_0023}&nbsp;&gt;&gt;&nbsp;{L_5143}</h4>
				<div style="font-size: 16px; font-weight: bold; text-align: center;" class="centre">
					{L_5158}<i>{SITENAME}</i><br>
					{STATSMONTH}
				</div>
                <div style="text-align: center;" class="centre">
                	<a href="viewbrowserstats.php">{L_5165}</a> | <a href="viewdomainstats.php">{L_5166}</a> | <a href="viewplatformstats.php">{L_5318}</a>
                </div>
                <table width="250" cellspacing="1" cellpadding="0" class="blank">
                    <tr>
                        <td colspan="3"><b>{L_5164}</b></td>
                    </tr>
                    <tr>
                        <td width="22" bgcolor="#006699">&nbsp;</td>
                        <td width="144"><b>&nbsp;{L_5161} : </b></td>
                        <td width="78"><b>{TOTAL_PAGEVIEWS}</b></td>
                    </tr>
                    <tr>
                    	<td bgcolor="#66CC00">&nbsp;</td>
                        <td><b>&nbsp;{L_5162} : </b></td>
                        <td><b>{TOTAL_UNIQUEVISITORS}</b></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFF00">&nbsp;</td>
                        <td><b>&nbsp;{L_5163} :</b></td>
                        <td><b>{TOTAL_USERSESSIONS}</b></td>
                    </tr>
                </table>

                <table width="98%" cellspacing="1" cellpadding="0" class="blank">
                <tr>
                    <th align="center" width="80"><b>{STATSTEXT}</b></td>
                    <th height="21" style="text-align:right;">{L_829}<a href="viewaccessstats.php?type=d">{L_109}</a>/ <a href="viewaccessstats.php?type=w">{L_828}</a>/ <a href="viewaccessstats.php?type=m">{L_830}</a></td>
                </tr>
<!-- BEGIN sitestats -->
                <tr class="bg">
                    <td align="center" height="45"><b>{sitestats.DATE}</b></td>
                    <td>
	<!-- IF sitestats.PAGEVIEWS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
						<div style="height:15px; width:{sitestats.PAGEVIEWS_WIDTH}%; background-color:#006699; color:#FFFFFF;"><b>{sitestats.PAGEVIEWS}</b></div>
	<!-- ENDIF -->
	<!-- IF sitestats.UNIQUEVISITORS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
						<div style="height:15px; width:{sitestats.UNIQUEVISITORS_WIDTH}%; background-color:#66CC00; color:#FFFFFF;"><b>{sitestats.UNIQUEVISITORS}</b></div>
	<!-- ENDIF -->
	<!-- IF sitestats.USERSESSIONS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
	<!-- ELSE -->
						<div style="height:15px; width:{sitestats.USERSESSIONS_WIDTH}%; background-color:#FFFF00;"><b>{sitestats.USERSESSIONS}</b></div>
	<!-- ENDIF -->
                    </td>
                </tr>
<!-- END sitestats -->
				</table>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->