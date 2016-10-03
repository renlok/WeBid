
            <div style="margin-left:auto; margin-right:auto;">

</div>
<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_25_0018}</li>
            <li>/</li>
            <li title="">{L_5232}</li>
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
      <form name="editfaq" action="" method="post">
					<table width="98%" cellspacing="0" class="blank">
                    <tr>
                        <td>{L_5238}</td>
                        <td>&nbsp;</td>
                        <td>
                        	<select name="category">
<!-- BEGIN cats -->
								<option value="{cats.ID}"<!-- IF cats.ID eq FAQ_CAT -->selected="selected"<!-- ENDIF -->>{cats.CAT}</option>
<!-- END cats -->
                            </select>
                        </td>
                    </tr>
<!-- BEGIN qs -->
                    <tr>
	<!-- IF qs.S_FIRST_ROW -->
    					<td>{L_5239}:</td>
    <!-- ELSE -->
    					<td>&nbsp;</td>
    <!-- ENDIF -->
                        <td align="right"><img src="../includes/flags/{qs.LANG}.gif"></td>
                        <td><input type="text" name="question[{qs.LANG}]" maxlength="200" value="{qs.QUESTION}"></td>
                    </tr>
<!-- END qs -->
<!-- BEGIN as -->
                    <tr>
	<!-- IF as.S_FIRST_ROW -->
    					<td valign="top">{L_5240}:</td>
    <!-- ELSE -->
    					<td>&nbsp;</td>
    <!-- ENDIF -->
                        <td align="right" valign="top"><img src="../includes/flags/{as.LANG}.gif"></td>
                        <td><textarea name="answer[{as.LANG}]" cols="40" rows="15">{as.ANSWER}</textarea></td>
                    </tr>
<!-- END as -->
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
