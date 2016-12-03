<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_239} <i class="fa fa-angle-double-right"></i> {PAGE_TITLE}</h2>
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
            <td width="20%">{L_312}</td>
            <td>{TITLE}</td>
          </tr>
          <tr>
            <td>{L_313}</td>
            <td>{NICK}</td>
          </tr>
          <tr>
            <td>{L_314}</td>
            <td>{STARTS}</td>
          </tr>
          <tr>
            <td>{L_022}</td>
            <td>{DURATION}</td>
          </tr>
          <tr>
            <td>{L_287}</td>
            <td>{CATEGORY}</td>
          </tr>
          <tr>
            <td>{L_018}</td>
            <td>{DESCRIPTION}</td>
          </tr>
          <tr>
            <td>{L_116}</td>
            <td>{CURRENT_BID}</td>
          </tr>
          <tr>
            <td>{L_258}</td>
            <td>{QTY}</td>
          </tr>
          <tr>
            <td>{L_021}</td>
            <td>{RESERVE_PRICE}</td>
          </tr>
          <tr>
            <td>{L_300}</td>
            <td><!-- IF SUSPENDED eq 0 -->
              {L_029}
              <!-- ELSE -->
              {L_030}
              <!-- ENDIF --></td>
          </tr>
          <tr>
            <td colspan="2"><!-- IF SUSPENDED eq 0 -->
              {L_323}
              <!-- ELSE -->
              {L_324}
              <!-- ENDIF --></td>
          </tr>
          <tr>
            <td width="204">&nbsp;</td>
            <td><form name="details" action="" method="post">
                <input type="hidden" name="id" value="{ID}">
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
