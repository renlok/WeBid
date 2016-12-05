<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_045} <i class="fa fa-angle-double-right"></i> {ACTION}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <table class="table table-bordered table-striped">
          <tr>
            <td width="204">{L_302}</td>
            <td>{REALNAME}</td>
          </tr>
          <tr>
            <td>{L_003}</td>
            <td>{USERNAME}</td>
          </tr>
          <tr>
            <td>{L_303}</td>
            <td>{EMAIL}</td>
          </tr>
          <tr>
            <td>{L_252}</td>
            <td>{DOB}</td>
          </tr>
          <tr>
            <td>{L_009}</td>
            <td>{ADDRESS}</td>
          </tr>
          <tr>
            <td>{L_011}</td>
            <td>{PROV}</td>
          </tr>
          <tr>
            <td>{L_012}</td>
            <td>{ZIP}</td>
          </tr>
          <tr>
            <td>{L_014}</td>
            <td>{COUNTRY}</td>
          </tr>
          <tr>
            <td>{L_013}</td>
            <td>{PHONE}</td>
          </tr>
          <tr>
            <td>{L_222}</td>
            <td><p><a href="userfeedback.php?id={ID}">{L_208}</a></p></td>
          </tr>
          <tr>
            <td width="204">&nbsp;</td>
            <td>{QUESTION}</td>
          </tr>
          <tr>
            <td width="204">&nbsp;</td>
            <td><form name="details" action="" method="post">
                <input type="hidden" name="id" value="{ID}">
                <input type="hidden" name="mode" value="{MODE}">
                <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                <input type="submit" name="action" value="{L_030}" class="btn btn-primary">
                <input type="submit" name="action" value="{L_029}" class="btn btn-primary">
              </form></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- INCLUDE footer.tpl -->
