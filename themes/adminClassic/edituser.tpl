		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}&nbsp;&gt;&gt;&nbsp;{L_511}</h4>
				<form name="errorlog" action="" method="post">
					<table width="98%" celpadding="0" cellspacing="0" class="blank">
					<tr>
						<td width="204">{L_302} *</td>
						<td><input type="text" name="name" size="40" maxlength="255" value="{REALNAME}"></td>
						<td><b>{L_448}</b></td>
					</tr>
					<tr>
						<td>{L_003}</td>
						<td>{USERNAME}</td>
						<td rowspan="15" width="33%" valign="top">
							{USERGROUPS}
						</td>
					</tr>
					<tr class="bg">
						<td>&nbsp;</td>
						<td><small>{L_243}</small></td>
					</tr>
					<tr class="bg">
						<td>{L_004} *</td>
						<td><input type="password" name="password" size="20" maxlength="20"></td>
					</tr>
					<tr class="bg">
						<td>{L_004} *</td>
						<td><input type="password" name="repeat_password" size="20" maxlength="20"></td>
					</tr>
					<tr>
						<td>{L_303} *</td>
						<td><input type="text" name="email" size="50" maxlength="50" value="{EMAIL}"></td>
					</tr>
					<tr>
						<td>{L_252}{REQUIRED(0)}</td>
						<td><input type="text" name="birthdate" size="10" maxlength="10" value="{DOB}"></td>
					</tr>
					<tr>
						<td>{L_009}{REQUIRED(1)}</td>
						<td><input type="text" name="address" size="40" maxlength="255" value="{ADDRESS}"></td>
					</tr>
					<tr>
						<td>{L_010}{REQUIRED(2)}</td>
						<td><input type="text" name="city" size="40" maxlength="255" value="{CITY}"></td>
					</tr>
					<tr>
						<td>{L_011}{REQUIRED(3)}</td>
						<td><input type="text" name="prov" size="40" maxlength="255" value="{PROV}"></td>
					</tr>
					<tr>
						<td>{L_012}{REQUIRED(5)}</td>
						<td><input type="text" name="zip" size="15" maxlength="15" value="{ZIP}"></td>
					</tr>
					<tr>
						<td>{L_014}{REQUIRED(4)}</td>
						<td>
							<select name="country">
								<option value=""></option>
								{COUNTRY_LIST}
							</select>
						</td>
					</tr>
					<tr>
						<td>{L_013}{REQUIRED(6)}</td>
						<td><input type="text" name="phone" size="40" maxlength="40" value="{PHONE}"></td>
					</tr>
					<tr>
						<td>{L_763}</td>
						<td><input type="text" name="balance" size="40" maxlength="10" value="{BALANCE}"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><a href="userfeedback.php?id={ID}">{L_208}</a></td>
					</tr>
					</table>
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="offset" value="{OFFSET}">
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_071}">
				</form>
			</div>
		</div>
