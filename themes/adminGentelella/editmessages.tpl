
            <div style="margin-left:auto; margin-right:auto;">

</div>
<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_25_0018}</li>
            <li>/</li>
            <li title="">{L_5032}</li>
            <li>/</li>
            <li title="">{BOARD_NAME}</li>
			<li>/</li>
            <li class="current">{L_5063}</li>
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
      <table width="98%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#FFFF66" colspan="4">
							<form name="clearmessages" action="" method="post">
                            {L_5065}
                            <input type="text" name="days">
                            {L_5115}
                            <input type="hidden" name="action" value="purge">
                            <input type="hidden" name="id" value="{ID}">
                            <input type="submit" name="submit" class="centre" value="{L_5029}">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th width="55%">{L_5059}</th>
                        <th width="15%">{L_5060}</th>
                        <th width="15%">{L_314}</th>
                        <th width="15%">&nbsp;</th>
                    </tr>
<!-- BEGIN msgs -->
                    <tr<!-- IF msgs.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
                        <td>{msgs.MESSAGE}</td>
                        <td>{msgs.POSTED_BY}</td>
                        <td>{msgs.POSTED_AT}</td>
                        <td><a href="editmessage.php?id={ID}&msg={msgs.ID}">{L_298}</a>&nbsp;|&nbsp;<a href="deletemessage.php?board_id={ID}&id={msgs.ID}">{L_008}</a></td>
                    </tr>
<!-- END msgs -->
                </table>

            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
