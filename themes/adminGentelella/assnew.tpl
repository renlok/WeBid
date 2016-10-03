
            <div style="margin-left:auto; margin-right:auto;">

</div>
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
            	<form name="addnew" action="" method="post">
                    <table width="98%" cellpadding="2" class="blank">
<!-- BEGIN lang -->
						<tr valign="top">
	<!-- IF lang.S_FIRST_ROW -->
    						<td align="right">{L_519}:</td>
    <!-- ELSE -->
    						<td>&nbsp;</td>
    <!-- ENDIF -->
                            <td width="35" align="right"><img src="../includes/flags/{lang.LANG}.gif"></td>
                            <td><input type="text" name="title[{lang.LANG}]" size="40" maxlength="255" value="{lang.TITLE}"></td>
                        </tr>
<!-- END lang -->
<!-- BEGIN lang -->
						<tr>
	<!-- IF lang.S_FIRST_ROW -->
    						<td valign="top" align="right">{L_520}:</td>
    <!-- ELSE -->
    						<td>&nbsp;</td>
    <!-- ENDIF -->
                            <td align="right" valign="top"><img src="../includes/flags/{lang.LANG}.gif"></td>
                            <td><textarea name="content[{lang.LANG}]" cols="45" rows="20">{lang.CONTENT}</textarea></td>
                        </tr>
<!-- END lang -->
                        </tr>
                        <tr>
                            <td align="right">{L_521}</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="radio" name="suspended" value="0"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_030}
                                <input type="radio" name="suspended" value="1"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_029}
                            </td>
                        </tr>
                    </table>
<!-- IF ID ne '' -->
                    <input type="hidden" name="id" value="{ID}">
<!-- ENDIF -->
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" class="centre" value="{BUTTON}">
				</form>
            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
