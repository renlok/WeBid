<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0011} <i class="fa fa-angle-double-right"></i> {L_banner_admin}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="deleteusers" action="" method="post">
          <div class="plain-box"><a href="newbannersuser.php"><i class="fa fa-plus"></i> {L__0026}</a></div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="15%">{L_5180}</th>
              <th width="25%">{L__0022}</th>
              <th width="28%">{L_303}</th>
              <th width="11%">{L__0025}</th>
              <th width="10%">&nbsp;</th>
              <th width="11%">{L_008}</th>
            </tr>
            <!-- BEGIN busers -->
            <tr<!-- IF busers.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
              <td><a href="editbannersuser.php?id={busers.ID}">{busers.NAME}</a></td>
              <td>{busers.COMPANY}</td>
              <td><a href="mailto:{busers.EMAIL}">{busers.EMAIL}</a></td>
              <td>{busers.NUM_BANNERS}</td>
              <td><a href="userbanners.php?id={busers.ID}">{L__0024}</a></td>
              <td><input type="checkbox" name="delete[]" value="{busers.ID}"></td>
            </tr>
            <!-- END busers -->
          </table>
          <input type="hidden" name="action" value="deleteusers">
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <input type="submit" name="act" class="btn btn-primary" value="{L__0028}">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- INCLUDE footer.tpl -->
