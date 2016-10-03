<!-- INCLUDE header.tpl -->
    	 	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_5436} <i class="fa fa-angle-double-right"></i> {L_25_0169a}</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                       <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<form name="errorlog" action="" method="post">
                <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
<!-- IF ERROR ne '' -->
					<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> {ERROR}</div>
<!-- ENDIF -->
                    Your Version: <b>{MYVERSION}</b><br>
                    Current Version: {REALVERSION}<br>
                    {TEXT}
				</form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->