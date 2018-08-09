    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_562}</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                       <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
                <form name="editadmin" action="" method="post">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>{L_003}</td>
                            <td>{USERNAME}</td>
                        </tr>
                        <tr>
                            <td>{L_558}</td>
                            <td>{CREATED}</td>
                        </tr>
                        <tr>
                            <td>{L_559}</td>
                            <td>{LASTLOGIN}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{L_563}</td>
                        </tr>
                        <tr>
                            <td>{L_004}</td>
                            <td><input type="password" name="password" size="25"></td>
                        </tr>
                        <tr>
                            <td>{L_564}</td>
                            <td><input type="password" name="repeatpassword" size="25"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                            	<input type="radio" name="status" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_566}<br>
                  				<input type="radio" name="status" value="2"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_567}
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="{ID}">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_530}">
                </form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
