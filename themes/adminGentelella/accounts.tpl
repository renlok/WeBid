<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0012} <i class="fa fa-angle-double-right"></i> {L_854}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form action="" method="post">
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <table class="table table-bordered table-striped">
            <tr>
              <td>{L_855}</td>
              <td> {L_monthly_report} <input type="radio" name="type" value="m"<!-- IF TYPE eq 'm' --> checked="checked"<!-- ENDIF -->>
                {L_weekly_report} <input type="radio" name="type" value="w"<!-- IF TYPE eq 'w' --> checked="checked"<!-- ENDIF -->>
                {L_5285} <input type="radio" name="type" value="d"<!-- IF TYPE eq 'd' --> checked="checked"<!-- ENDIF -->>
                {L_2__0027} <input type="radio" name="type" value="a"<!-- IF TYPE eq 'a' --> checked="checked"<!-- ENDIF -->> </td>
            </tr>
            <tr>
              <td>{L_856}</td>
              <td><div id="sandbox-container">
                  <input type="text" name="from_date" id="from_date" value="{FROM_DATE}" maxlength="19">
                </div>
                <script type="text/javascript">
							new tcal ({'id': 'from_date','controlname': 'from_date'});
						</script>
                -
                <div id="sandbox-container">
                  <input type="text" name="to_date" id="to_date" value="{TO_DATE}" maxlength="19">
                </div>
                <script type="text/javascript">
							new tcal ({'id': 'to_date','controlname': 'to_date'});
						</script></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" name="act" value="{L_275}" class="btn btn-primary"></td>
            </tr>
          </table>
        </form>
        <table class="table table-bordered table-striped">
          <!-- IF PAGNATION -->
          <tr>
            <th><b>{L_313}</b></th>
            <th><b>{L_766}</b></th>
            <th align="center"><b>{L_314}</b></th>
            <th align="center"><b>{L_391}</b></th>
          <tr>
            <!-- ELSE -->
          <tr>
            <th><b>{L_314}</b></th>
            <th align="center"><b>{L_857}</b></th>
          <tr>
            <!-- ENDIF -->
            <!-- BEGIN accounts -->
            <!-- IF PAGNATION -->
          <tr<!-- IF accounts.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
            <td>{accounts.RNAME} ({accounts.NICK})</td>
            <td>{accounts.TEXT}</td>
            <td align="center">{accounts.DATE}</td>
            <td align="center">{accounts.AMOUNT}</td>
          </tr>
          <!-- ELSE -->
          <tr<!-- IF accounts.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
            <td>{accounts.DATE}</td>
            <td align="center">{accounts.AMOUNT}</td>
          </tr>
          <!-- ENDIF -->
          <!-- END accounts -->
        </table>
        <!-- IF PAGNATION -->
        <table>
          <tr>
            <td align="center"> {L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES} <br>
              {PREV}
              <!-- BEGIN pages -->
              {pages.PAGE}&nbsp;&nbsp;
              <!-- END pages -->
              {NEXT} </td>
          </tr>
        </table>
        <!-- ENDIF -->
      </div>
    </div>
  </div>
</div>

<!-- INCLUDE footer.tpl -->
