
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
            <li class="current">{L_5052}</li>
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
      <form name="errorlog" action="" method="post">
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td width="24%">{L_5034}</td>
                        <td width="76%">
                            <input type="text" name="name" size="25" maxlength="255" value="{NAME}">
                        </td>
                    </tr>
                    <tr>
                        <td>{L_5043}</td>
                        <td>{MESSAGES} (<a href="editmessages.php?id={ID}">{L_5063}</a>)</td>
                    </tr>
                    <tr>
                        <td>{L_5053}</td>
                        <td>{LAST_POST}</td>
                    </tr>
                    <tr>
                        <td>{L_5035}</td>
                        <td>
                            <p>{L_5036}</p>
                            <input type="text" name="msgstoshow" size="4" maxlength="4" value="{MSGTOSHOW}">
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="radio" name="active" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_5038}<br>
                            <input type="radio" name="active" value="2"<!-- IF B_DEACTIVE --> checked="checked"<!-- ENDIF -->> {L_5039}
                        </td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="{ID}">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="centre" value="{L_530}">
				</form>

            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
