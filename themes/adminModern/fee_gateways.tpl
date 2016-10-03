<!-- INCLUDE header.tpl -->

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0012} <i class="fa fa-angle-double-right"></i> {L_445}</h2>
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
          <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> {ERROR}</div>
          <!-- ENDIF -->
          <table class="table table-bordered table-striped">
            <!-- BEGIN gateways -->
            <tr>
              <th colspan="2"><b>{gateways.NAME}</b></th>
            </tr>
            <tr>
              <td width="50%"><a href="{gateways.WEBSITE}" target="_blank">{gateways.ADDRESS_NAME}</a>:<br>
                <input type="text" name="{gateways.PLAIN_NAME}_address" value="{gateways.ADDRESS}" class="form-control">
                
                <!-- IF gateways.B_PASSWORD -->
                
                <p>{gateways.ADDRESS_PASS}:<br>
                  <input type="text" name="{gateways.PLAIN_NAME}_password" value="{gateways.PASSWORD}" class="form-control">
                </p>
                
                <!-- ENDIF --></td>
              <td><p>
                  <input type="checkbox" name="{gateways.PLAIN_NAME}_required"{gateways.REQUIRED}>
                  {L_446}</p>
                <p>
                  <input type="checkbox" name="{gateways.PLAIN_NAME}_active"{gateways.ENABLED}>
                  {L_447}</p></td>
            </tr>
            <!-- END gateways -->
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