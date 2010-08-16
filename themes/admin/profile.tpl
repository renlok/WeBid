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
            	<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_25_0005}</h4>
				<form name="profile_feilds" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr valign="top">
                        <td width="25%">{L_781}</td>
                        <td width="75%">
                            {L_030}<input type="radio" name="birthdate" value="y" <!-- IF REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="birthdate" value="n" <!-- IF ! REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="birthdate_regshow" value="y" <!-- IF DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="birthdate_regshow" value="n" <!-- IF ! DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_782}</td>
                        <td>
                            {L_030}<input type="radio" name="address" value="y" <!-- IF REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="address" value="n" <!-- IF ! REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="address_regshow" value="y" <!-- IF DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="address_regshow" value="n" <!-- IF ! DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_783}</td>
                        <td>
                            {L_030}<input type="radio" name="city" value="y" <!-- IF REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="city" value="n" <!-- IF ! REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="city_regshow" value="y" <!-- IF DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="city_regshow" value="n" <!-- IF ! DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_784}</td>
                        <td>
                            {L_030}<input type="radio" name="prov" value="y" <!-- IF REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="prov" value="n" <!-- IF ! REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="prov_regshow" value="y" <!-- IF DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="prov_regshow" value="n" <!-- IF ! DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_785}</td>
                        <td>
                            {L_030}<input type="radio" name="country" value="y" <!-- IF REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="country" value="n" <!-- IF ! REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="country_regshow" value="y" <!-- IF DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="country_regshow" value="n" <!-- IF ! DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_786}</td>
                        <td>
                            {L_030}<input type="radio" name="zip" value="y" <!-- IF REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="zip" value="n" <!-- IF ! REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="zip_regshow" value="y" <!-- IF DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="zip_regshow" value="n" <!-- IF ! DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_787}</td>
                        <td>
                            {L_030}<input type="radio" name="tel" value="y" <!-- IF REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="tel" value="n" <!-- IF ! REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td>{L_780}</td>
                        <td>
                            {L_030}<input type="radio" name="tel_regshow" value="y" <!-- IF DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                            {L_029}<input type="radio" name="tel_regshow" value="n" <!-- IF ! DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="submit" name="act" class="centre" value="{L_530}">
				</form>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->