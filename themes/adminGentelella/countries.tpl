<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_081}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="payments" action="" method="post">
          <div class="plain-box">
            <p>{L_094}</p>
            <p><img src="../images/nodelete.gif" width="20" height="21" style="vertical-align:middle;"> {L_2__0030}</p>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th>&nbsp;</th>
              <th><b>{L_087}</b></th>
              <th><b>{L_008}</b></th>
            </tr>
            <!-- BEGIN countries -->
            <tr>
              <td>&nbsp;</td>
              <td><input type="text" name="new_countries[]" size="45" value="{countries.COUNTRY}" class="form-control">
                <input type="hidden" name="old_countries[]" value="{countries.COUNTRY}"></td>
              <td align="center">
                <!-- IF countries.B_CAN_DELETE -->
                <input type="checkbox" name="delete[]" value="{countries.COUNTRY}">
                <!-- ELSE -->
                <img src="../images/nodelete.gif" alt="{L_cannot_delete}">
                <!-- ENDIF -->
              </td>
            </tr>
            <!-- END countries -->
            <tr>
              <td colspan="2" align="right">{L_30_0102}</td>
              <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
            </tr>
            <tr>
              <td><i class="fa fa-plus"></i> {L_394}</td>
              <td><input type="text" name="new_countries[]" class="form-control"></td>
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
