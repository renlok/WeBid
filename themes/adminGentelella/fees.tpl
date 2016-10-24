         <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0012} <i class="fa fa-angle-double-right"></i> {L_842}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
      <form name="errorlog" action="" method="post">
<!-- IF FEETYPE ne '' -->
                    <table class="table table-bordered table-striped">
                        <tr>
                        	<th colspan="6">{FEETYPE}</th>
                        </tr>
	<!-- IF B_SINGLE -->
                        <tr>
                            <td width="109" height="22">{L_263}</td>
                            <td height="22" colspan="5">
                            <div class="col-sm-6">
                                <input type="text" name="value" value="{VALUE}" class="form-control"></div> <div class="col-sm-3">{CURRENCY}</div>
                            </td>
                        </tr>
	<!-- ELSE -->
                        <tr>
                            <th width="120">&nbsp;</th>
                            <th width="120"><b>{L_240} ({CURRENCY})</b></th>
                            <th width="120"><b>{L_241} ({CURRENCY})</b></th>
                            <th width="120"><b>{L_391} ({CURRENCY})</b></th>
                            <th><b>{L_392}</b></th>
                            <th width="70" align="center"><b>{L_008}</b></th>
                        </tr>
		<!-- BEGIN fees -->
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="hidden" name="tier_id[]" value="{fees.ID}">
                                <input name="fee_from[]" type="text" value="{fees.FROM}" class="form-control">
                            </td>
                            <td><input name="fee_to[]" type="text" value="{fees.TO}" class="form-control"></td>
                            <td><input name="value[]" type="text" value="{fees.VALUE}" class="form-control"></td>
                            <td>
                                <select name="type[]" class="form-control">
                                    <option value="flat"{fees.FLATTYPE}>{L_393}</option>
                                    <option value="perc"{fees.PERCTYPE}>{L_357}</option>
                                </select>
                            </td>
                            <td align="center"><input type="checkbox" name="fee_delete[]" value="{fees.ID}" class="form-control"></td>
                        </tr>
		<!-- END fees -->
                        <tr>
                            <td>{L_394}</td>
                            <td><input name="new_fee_from" type="text" class="form-control" value="{FEE_FROM}"></td>
                            <td><input name="new_fee_to" type="text" class="form-control" value="{FEE_TO}"></td>
                            <td><input name="new_value" type="text" class="form-control" value="{FEE_VALUE}"></td>
                            <td>
                                <select name="new_type" class="form-control">
                                    <option value="flat"<!-- IF FEE_TYPE eq 'flat' --> selected<!-- ENDIF -->>{L_393}</option>
                                    <option value="perc"<!-- IF FEE_TYPE eq 'perc' --> selected<!-- ENDIF -->>{L_357}</option>
                                </select>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
	<!-- ENDIF -->
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" value="{L_530}" class="btn btn-primary">
                    <div class="plain-box">&nbsp;</div>
<!-- ENDIF -->
					<table class="table table-bordered table-striped">
                        <tr>
                            <th colspan="2"><b>{L_417}</b></th>
                        </tr>
                        <tr>
                            <td width="50%"><a href="{SITEURL}admin/fees.php?type=signup_fee">{L_430}</a></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <th colspan="2"><b>{L_431}</b></th>
                        </tr>
                        <tr>
                            <td><a href="{SITEURL}admin/fees.php?type=setup">{L_432}</a> </td>
                            <td><a href="{SITEURL}admin/fees.php?type=relist_fee">{L_437}</a> </td>
                        </tr>
                        <tr>
                            <td><a href="{SITEURL}admin/fees.php?type=hpfeat_fee">{L_433}</a> </td>
                            <td><a href="{SITEURL}admin/fees.php?type=bolditem_fee">{L_439}</a> </td>
                        </tr>
                        <tr>
                            <td><a href="{SITEURL}admin/fees.php?type=hlitem_fee">{L_434}</a> </td>
                            <td><a href="{SITEURL}admin/fees.php?type=rp_fee">{L_440}</a> </td>
                        </tr>
                        <tr>
                            <td><a href="{SITEURL}admin/fees.php?type=picture_fee">{L_435}</a> </td>
                            <td><a href="{SITEURL}admin/fees.php?type=buyout_fee">{L_436}</a> </td>
                        </tr>
                        <tr>
                            <td><a href="{SITEURL}admin/fees.php?type=buyer_fee">{L_775}</a></td>
                            <td><a href="{SITEURL}admin/fees.php?type=endauc_fee">{L_791}</a></td>
                        </tr>
                        <tr>
                            <td><a href="{SITEURL}admin/fees.php?type=subtitle_fee">{L_803}</a></td>
                            <td><a href="{SITEURL}admin/fees.php?type=excat_fee">{L_804}</a></td>
                        </tr>
                    </table>
				</form>

            </div>
        </div>
</div>
</div>

<!-- INCLUDE footer.tpl -->
