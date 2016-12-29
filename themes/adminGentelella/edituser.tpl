<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_511} <i class="fa fa-angle-double-right"></i> {L_854}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="errorlog" action="" method="post">
                    <table class="table table-bordered table-striped">
                    <tr>
                        <td width="204">{L_302} *</td>
                        <td><input type="text" name="name" size="40" maxlength="255" value="{REALNAME}"></td>
                        <td><b>{L_448}</b></td>
                    </tr>
                    <tr>
                        <td>{L_003}</td>
                        <td>{USERNAME}</td>
                        <td rowspan="15" width="33%" valign="top">
            						<!-- BEGIN usergroups -->
            							<p><input type="checkbox" name="group[]" value="{usergroups.ID}"<!-- IF usergroups.B_SELECTED --> checked="true"<!-- ENDIF -->> {usergroups.NAME}</p>
            						<!-- END usergroups -->
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
                								<!-- BEGIN countries -->
                									<option value="{countries.COUNTRY}"<!-- IF countries.B_SELECTED --> selected="true"<!-- ENDIF -->>{countries.COUNTRY}</option>
                								<!-- END countries -->
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
                    <input type="hidden" name="idhidden" value="{ID}">
                    <input type="hidden" name="mode" value="{MODE}">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_071}">
				</form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
