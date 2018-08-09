<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0012} <i class="fa fa-angle-double-right"></i> {L_445}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="errorlog" action="" method="post">
          <table class="table table-bordered table-striped">
            <!-- BEGIN gateways -->
            <tr>
              <th colspan="2"><b>{gateways.NAME}</b></th>
            </tr>
            <tr>
              <td width="50%"><input type="hidden" name="{gateways.PLAIN_NAME}[id]" value="{gateways.GATEWAY_ID}"></br>
											<a href="{gateways.WEBSITE}" target="_blank">{gateways.ADDRESS_NAME}</a>:<br><input type="text" name="{gateways.PLAIN_NAME}[address]" value="{gateways.ADDRESS}" class="form-control">
                
                <!-- IF gateways.B_PASSWORD -->
                
                <p>{gateways.PASSWORD_NAME}:<br>
                  <input type="text" name="{gateways.PLAIN_NAME}[password]" value="{gateways.PASSWORD}" class="form-control">
                </p>
                <!-- ELSE -->
		<input type="hidden" name="{gateways.PLAIN_NAME}[password]" value="">
                <!-- ENDIF --></td>
              <td><p>
                  <input type="checkbox" name="{gateways.PLAIN_NAME}[required]"{gateways.REQUIRED}>
                  {L_446}</p>
                <p>
                  <input type="checkbox" name="{gateways.PLAIN_NAME}[active]"{gateways.ENABLED}>
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
