
            <div style="margin-left:auto; margin-right:auto;">

</div>
<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_25_0018}</li>
            <li>/</li>
            <li title="">{L_5236}</li>
            <li>/</li>
            <li title="">{L_5230}</li>
			<li>/</li>
            <li class="current">{FAQ_NAME}</li>
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
<!-- BEGIN flangs -->
                    <tr>
	<!-- IF flangs.S_FIRST_ROW -->
                        <td width="20%">{L_5284}</td>
    <!-- ELSE -->
    					<td>&nbsp;</td>
    <!-- ENDIF -->
                        <td width="5%"><img src="{SITEURL}includes/flags/{flangs.LANGUAGE}.gif"></td>
                        <td width="75%" valign="top">
                            <input type="text" name="category[{flangs.LANGUAGE}]" size="50" maxlength="150" value="{flangs.TRANSLATION}">
                        </td>
                    </tr>
<!-- END langs -->
                    </table>
                    <input type="hidden" name="id" value="{ID}">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="centre" value="{L_530}">
				</form>

            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
