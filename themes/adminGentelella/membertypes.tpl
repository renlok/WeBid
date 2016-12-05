<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_25_0169}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="memberlevels" action="" method="post">
          <div class="plain-box">{L_25_0170}</div>
          <table class="table table-bordered table-striped">
            <tr>
              <th>&nbsp;</th>
              <th><b>{L_25_0171}</b></th>
              <th><b>{L_25_0167}</b></th>
              <th>&nbsp;</th>
              <th width="5%"><b>{L_008}</b></th>
            </tr>
            <!-- BEGIN mtype -->
            <tr>
              <td>&nbsp;</td>
              <td><input type="hidden" name="old_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}">
                <input type="text" name="new_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}" class="form-control"></td>
              <td><input type="hidden" name="old_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}">
                <input type="text" name="new_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}" class="form-control"></td>
              <td><img src="../images/icons/{mtype.ICON}" align="middle"></td>
              <td align="center"><input type="checkbox" name="delete[]" value="{mtype.ID}"></td>
            </tr>
            <!-- END mtype -->
            <tr>
              <td colspan="4" align="right">{L_30_0102}</td>
              <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
            </tr>
            <tr>
              <td>{L_518}</td>
              <td><input type="text" name="new_membertype[feedbacks]" class="form-control"></td>
              <td><input type="text" name="new_membertype[icon]" class="form-control"></td>
              <td colspan="2">&nbsp;</td>
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
