

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_276} <i class="fa fa-angle-double-right"></i> {L_132}</h2>
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
          <div class="plain-box">
            <p>{L_161}</p>
            <!-- BEGIN langs --> 
            <a href="categoriestrans.php?lang={langs.LANG}"><img align="middle" src="{SITEURL}inc/flags/{langs.LANG}.gif" border="0"></a> 
            <!-- END langs --> 
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th><b>{L_771}</b></th>
              <th><b>{L_772}</b></th>
            </tr>
            <!-- BEGIN cats -->
            <tr {cats.BG}>
              <td><input type="text" name="categories_o[]" value="{cats.CAT_NAME}" class="form-control" disabled></td>
              <td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.TRAN_CAT}" class="form-control"></td>
            </tr>
            <!-- END cats -->
          </table>
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <input type="submit" name="act" class="btn btn-primary" value="{L_089}">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- INCLUDE footer.tpl -->