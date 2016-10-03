

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_2_0020}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="errorlog" action="" method="post">
          <!-- IF ERROR ne '' -->
          <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>{ERROR}</div>
          <!-- ENDIF -->
          <table class="table table-bordered table-striped">
            <tr>
              <td colspan="5"> {L_2_0021}
                <input type="text" name="ip">
                <input type="submit" name="Submit2" value="&gt;&gt;" class="btn btn-default btn-xs">
                {L_2_0024} </td>
            </tr>
            <tr>
              <th width="29%"><b>{L_087}</b>
                </td>
              <th width="25%"><b>{L_2_0009}</b>
                </td>
              <th width="19%"><b>{L_560}</b>
                </td>
              <th width="18%"><b>{L_5028}</b>
                </td>
              <th width="9%"><b>{L_008}</b>
                </td>
            </tr>
            <!-- BEGIN ips -->
            <tr {ips.BG}>
              <td>{L_2_0025}</td>
              <td align="center">{ips.IP}</td>
              <td align="center"><!-- IF ips.ACTION eq 'accept' --> 
                {L_2_0012} 
                <!-- ELSE --> 
                {L_2_0013} 
                <!-- ENDIF --></td>
              <td><!-- IF ips.ACTION eq 'accept' -->
                
                <input type="checkbox" name="deny[]" value="{ips.ID}" class="form-control">
                &nbsp;{L_2_0006} 
                <!-- ELSE -->
                
                <input type="checkbox" name="accept[]" value="{ips.ID}" class="form-control">
                &nbsp;{L_2_0007} 
                <!-- ENDIF --></td>
              <td align="center"><input type="checkbox" name="delete[]" value="{ips.ID}"></td>
              <!-- BEGINELSE -->
              <td colspan="5">{L_831}</td>
              <!-- END ips --> 
            </tr>
          </table>
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <input type="submit" name="act" class="btn btn-primary" value="{L_2_0015}">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- INCLUDE footer.tpl -->