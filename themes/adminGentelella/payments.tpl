<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_075}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="payments" action="" method="post">
					<div class="plain-box">{L_092}</div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b><strong>{L_payment_name}</strong></b></th>
                            <th><b><strong>{L_clean_payment_name}</strong></b></th>
                            <th><b><strong>{L_008}</strong></b></th>
                        </tr>
<!-- BEGIN payments -->
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                 <input type="hidden" name="payment[{payments.ID}][id]" value="{payments.ID}" class="form-control">
									<input type="text" name="payment[{payments.ID}][name]" value="{payments.NAME}" class="form-control">
                            </td>
                              <td>
                              <input type="text" name="payment[{payments.ID}][clean]" value="{payments.CLEAN}" class="form-control">
                            </td>
                            <td align="center">
                                <input type="checkbox" name="delete[]" value="{payments.ID}">
                            </td>
                        </tr>
<!-- END payments -->
                        <tr>
                            <td colspan="2" align="right">{L_30_0102}</td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>{L_394}</td>
                            <td>
                                <input type="text" name="new_payments" class="form-control">
                            </td>
                              <td>
                             <input type="text" name="new_payments_clean" class="form-control">
                             </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_089}">
				</form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
