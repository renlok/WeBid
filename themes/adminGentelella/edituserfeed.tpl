
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
            <li title="">{RATED_USER}</li>
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
      <form name="editfeedback" action="" method="post">
                    <div class="plain-box">
                    	{RATER_USER} {L_506}{RATED_USER}
                    </div>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                    	<td>{L_503}</td>
                    	<td>
                        	<input type="radio" name="aTPL_rate" value="1" <!-- IF SEL1 -->checked="checked"<!-- ENDIF -->>
                            <img src="{SITEURL}images/positive.png" border="0">
                            <input type="radio" name="aTPL_rate" value="0" <!-- IF SEL2 -->checked="checked"<!-- ENDIF -->>
                            <img src="{SITEURL}images/neutral.png" border="0">
                            <input type="radio" name="aTPL_rate" value="-1" <!-- IF SEL3 -->checked="checked"<!-- ENDIF -->>
                            <img src="{SITEURL}images/negative.png" border="0">
                        </td>
                    </tr>
                    <tr>
                    	<td>{L_504}</td>
                    	<td>
                        	<textarea name="TPL_feedback" rows="10" cols="50">{FEEDBACK}</textarea>
                        </td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="centre" value="{L_530}">
				</form>

            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
