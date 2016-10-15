		<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
				<h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L__0026}</h2>
<div class="clearfix"></div>
      </div>
      <div class="col-md-12"> 
				<form name="errorlog" action="" method="post">
					<table class="table table-bordered table-striped">
					<tr>
						<td width="204">{L_302} *</td>
						<td><input type="text" name="name" class="form-control" maxlength="255" value="{REALNAME}"></td>
						<td><b>{L_448}</b></td>
					</tr>
					<tr>
						<td>{L_username}</td>
						<td><input type="text" name="username" class="form-control" maxlength="255" value="{USERNAME}"></td>
						<td rowspan="15" width="33%" valign="top">
							{USERGROUPS}
						</td>
					</tr>
					<tr class="bg">
						<td>{L_password} *</td>
						<td><input type="password" name="password" class="form-control" maxlength="20"></td>
					</tr>
					<tr class="bg">
						<td>{L_password} *</td>
						<td><input type="password" name="repeat_password" class="form-control" maxlength="20"></td>
					</tr>
					<tr>
						<td>{L_303} *</td>
						<td><input type="text" name="email" class="form-control" maxlength="50" value="{EMAIL}"></td>
					</tr>
					<tr>
						<td>{L_252}{REQUIRED(0)}</td>
						<td><input type="text" name="birthdate" class="form-control" maxlength="10" value="{DOB}"></td>
					</tr>
					<tr>
						<td>{L_009}{REQUIRED(1)}</td>
						<td><input type="text" name="address" class="form-control" maxlength="255" value="{ADDRESS}"></td>
					</tr>
					<tr>
						<td>{L_010}{REQUIRED(2)}</td>
						<td><input type="text" name="city" class="form-control" maxlength="255" value="{CITY}"></td>
					</tr>
					<tr>
						<td>{L_011}{REQUIRED(3)}</td>
						<td><input type="text" name="prov" class="form-control" maxlength="255" value="{PROV}"></td>
					</tr>
					<tr>
						<td>{L_012}{REQUIRED(5)}</td>
						<td><input type="text" name="zip" class="form-control" maxlength="15" value="{ZIP}"></td>
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
						<td><input type="text" name="phone" class="form-control" maxlength="40" value="{PHONE}"></td>
					</tr>
					<tr>
						<td>{L_763}</td>
						<td><input type="text" name="balance" class="form-control" maxlength="10" value="{BALANCE}"></td>
					</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="btn btn-primary" value="{L__0026}">
				</form>
			</div>
		</div>
