
            <div style="margin-left:auto; margin-right:auto;">

</div>
<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_25_0010}</li>
			<li>/</li>
			<li title="">{L_045}</li>
			<li>/</li>
            <li class="current">{L_222}</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End -->

    	<!-- Right Side/Main Content Start -->
    <div id="rightside">
<!-- IF WARNINGREPORT -->
            <!-- Green Status Bar Start -->
        <div class="status error">
        	<p><img src="{SITEURL}themes/{THEME}/img/icons/icon_error.png"  alt="Error" /><span>Error!</span> {WARNINGMESSAGE}</p>
        </div>
        <!-- Green Status Bar End -->
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
        <!-- Blue Status Bar Start -->
        <div class="status info">
        	<p><img src="{SITEURL}themes/{THEME}/img/icons/icon_info.png" alt="Information" /><span>Information:</span>  {ERROR}</p>
        </div>
        <!-- Blue Status Bar End -->
<!-- ENDIF -->

        <!-- Content Box Start -->
        <div class="contentcontainer">
            <div class="contentbox">
     <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                <tr>
                    <td align="right" colspan="2"><b>{NICK} ({FB_NUM}) {FB_IMG}</b></td>
                </tr>
<!-- BEGIN feedback -->
				<tr<!-- IF feedback.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
                	<td>
                    	<img align="middle" src="{SITEURL}images/{feedback.FB_TYPE}.png">&nbsp;&nbsp;<b>{feedback.FB_FROM}</b>&nbsp;&nbsp;<span class="small">({L_506}{feedback.FB_TIME})</span>
                        <p>{feedback.FB_MSG}</p>
                    </td>
                    <td align="right">
                    	<a href="edituserfeed.php?id={feedback.FB_ID}">{L_298}</a> | <a href="deleteuserfeed.php?id={feedback.FB_ID}&user={ID}">{L_008}</a>
                    </td>
                </tr>
<!-- END feedback -->
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

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
