<!-- INCLUDE header.tpl -->
    	<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>{L_5436} <i class="fa fa-angle-double-right"></i> {L_5068}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="wordlist" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> {ERROR}</div>
<!-- ENDIF -->
                    <table class="table table-bordered table-striped">
                    <tr valign="top">
                        <td width="109">&nbsp;</td>
                        <td width="375">{L_5069}</td>
                    </tr>
                    <tr valign="top">
                        <td>{L_5070}</td>
                        <td>
                            <input type="radio" name="wordsfilter" value="y"{WFYES}> {L_030}
                            <input type="radio" name="wordsfilter" value="n"{WFNO}> {L_029}
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>{L_5071}</td>
                        <td>
                            {L_5072}<br>
                            <textarea name="filtervalues" class="form-control">{WORDLIST}</textarea>
                        </td>
                    </tr>
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