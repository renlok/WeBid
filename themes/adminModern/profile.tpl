		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_25_0005}</h4>
				<form name="profile_feilds" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr valign="top">
							<td width="50%">{L_781}</td>
							<td>
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
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>