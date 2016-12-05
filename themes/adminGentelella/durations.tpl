<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_069}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="durations" action="" method="post">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b>{L_097}</b></th>
                            <th><b>{L_087}</b></th>
                            <th width="5%"><b>{L_008}</b></th>
                        </tr>
<!-- BEGIN dur -->
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="text" name="new_days[{dur.S_ROW_COUNT}]" value="{dur.DAYS}" size="5"></td>
                            <td><input type="text" name="new_durations[{dur.S_ROW_COUNT}]" value="{dur.DESC}" size="25"></td>
                            <td align="center"><input type="checkbox" name="delete[]" value="{dur.S_ROW_COUNT}"></td>
                        </tr>
<!-- END dur -->
                        <tr>
                            <td colspan="3" align="right">{L_30_0102}</td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
                        </tr>
                        <tr>
                            <td>{L_518}</td>
                            <td><input type="text" name="new_days[]" class="form-control" maxlength="5"></td>
                            <td><input type="text" name="new_durations[]" class="form-control"></td>
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
