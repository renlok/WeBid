<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_045} <i class="fa fa-angle-double-right"></i> {L_2_0004}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="banips" action="" method="post">
                	<table class="table table-bordered table-striped">
                    <tr>
                        <td colspan="3">{L_667} <b>{NICK}</b></td>
                        <td align="right">{L_559}: {LASTLOGIN}</td>
                    </tr>
                    <tr>
                        <th width="35%"><b>{L_087}</b></th>
                        <th width="27%"><b>{L_2_0009}</b></th>
                        <th width="21%"><b>{L_560}</b></th>
                        <th width="17%"><b>{L_5028}</b></th>
                    </tr>
<!-- BEGIN ips -->
                    <tr<!-- IF users.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
                        <td>
	<!-- IF ips.TYPE eq 'first' -->
    						{L_2_0005}
    <!-- ELSE -->
    						{L_221}
    <!-- ENDIF -->
                        </td>
                        <td align="center">{ips.IP}</td>
                        <td align="center">
	<!-- IF ips.ACTION eq 'accept' -->
    						{L_2_0012}
    <!-- ELSE -->
    						{L_2_0013}
    <!-- ENDIF -->
                        </td>
                        <td>
	<!-- IF ips.ACTION eq 'accept' -->
                            <input type="checkbox" name="deny[]" value="{ips.ID}">
                            &nbsp;{L_2_0006}
    <!-- ELSE -->
                            <input type="checkbox" name="accept[]" value="{ips.ID}">
                            &nbsp;{L_2_0007}
    <!-- ENDIF -->
                        </td>
                    </tr>
<!-- END ips -->
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="{ID}">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_2_0015}">
				</form>
                <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td align="center">
                            {L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                            <br>
                            {PREV}
<!-- BEGIN pages -->
                            {pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
                            {NEXT}
                        </td>
                    </tr>
				</table>
				<div class="plain-box"><a href="listusers.php" class="small">{L_5279}</a></div>
            </div>
        </div>
         </div>
        </div>
<!-- INCLUDE footer.tpl -->
