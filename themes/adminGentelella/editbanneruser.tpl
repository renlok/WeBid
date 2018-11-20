            <div style="margin-left:auto; margin-right:auto;">
</div>
<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_25_0011}</li>
            <li>/</li>
            <li title="">{L__0008}</li>
			<li>/</li>
            <li class="current">{L_511}</li>
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
      <form name="editbanneruser" action="" method="post">
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                    	<td>{L_302}</td>
                    	<td><input type="text" name="name" value="{NAME}"></td>
                    </tr>
                    <tr>
                    	<td>{L__0022}</td>
                    	<td><input type="text" name="company" value="{COMPANY}"></td>
                    </tr>
                    <tr>
                    	<td>{L_107}</td>
                    	<td><input type="text" name="email" value="{EMAIL}"></td>
                    </tr>
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
