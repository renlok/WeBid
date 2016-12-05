    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_25_0005}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12"> 
				<form name="profile_fields" action="" method="post">
                    <table class="table table-bordered table-striped">
                    <tr>
                        <td>{L_781}</td>
                        <td>
                            {L_yes}<input type="radio" name="birthdate" value="y" <!-- IF REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="birthdate" value="n" <!-- IF ! REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="birthdate_regshow" value="y" <!-- IF DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="birthdate_regshow" value="n" <!-- IF ! DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_782}</td>
                        <td>
                            {L_yes}<input type="radio" name="address" value="y" <!-- IF REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="address" value="n" <!-- IF ! REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="address_regshow" value="y" <!-- IF DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="address_regshow" value="n" <!-- IF ! DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_783}</td>
                        <td>
                            {L_yes}<input type="radio" name="city" value="y" <!-- IF REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="city" value="n" <!-- IF ! REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="city_regshow" value="y" <!-- IF DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="city_regshow" value="n" <!-- IF ! DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_784}</td>
                        <td>
                            {L_yes}<input type="radio" name="prov" value="y" <!-- IF REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="prov" value="n" <!-- IF ! REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="prov_regshow" value="y" <!-- IF DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="prov_regshow" value="n" <!-- IF ! DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_785}</td>
                        <td>
                            {L_yes}<input type="radio" name="country" value="y" <!-- IF REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="country" value="n" <!-- IF ! REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="country_regshow" value="y" <!-- IF DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="country_regshow" value="n" <!-- IF ! DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_786}</td>
                        <td>
                            {L_yes}<input type="radio" name="zip" value="y" <!-- IF REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="zip" value="n" <!-- IF ! REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="zip_regshow" value="y" <!-- IF DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="zip_regshow" value="n" <!-- IF ! DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_787}</td>
                        <td>
                            {L_yes}<input type="radio" name="tel" value="y" <!-- IF REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="tel" value="n" <!-- IF ! REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                        <td>{L_780}</td>
                        <td>
                            {L_yes}<input type="radio" name="tel_regshow" value="y" <!-- IF DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                            {L_no}<input type="radio" name="tel_regshow" value="n" <!-- IF ! DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_530}">
				</form>
            </div>
        </div>
       </div>
     </div>
<!-- INCLUDE footer.tpl -->
