

            	        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_448}</h2>
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
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong>{ERROR}</div>
<!-- ENDIF -->
                    <table class="table table-bordered table-striped">
                    <tr>
                        <th><b>{L_449}</b></th>
                        <th><b>{L_450}</b></th>
                        <th><b>{L_451}</b></th>
                        <th><b>{L_578}</b></th>
                        <th><b>{L_579}</b></th>
                        <th><b>{L_580}</b></th>
                        <th>&nbsp;</th>
                    </tr>
<!-- IF B_EDIT -->
                    <tr>
                        <td colspan="7"><b>{L_452}</b></td>
                    </tr>
                    <tr>
                        <td>{GROUP_ID}</td>
                        <td><input type="text" name="group_name" value="{EDIT_NAME}" class="form-control"></td>
                        <td><input type="text" name="user_count" value="{USER_COUNT}" class="form-control"></td>
                        <td>
                            <select name="can_sell" class="form-control">
                                <option value="1" {CAN_SELL_Y}>{L_030}</option>
                                <option value="0" {CAN_SELL_N}>{L_029}</option>
                            </select>
                        </td>
                        <td>
                            <select name="can_buy" class="form-control">
                                <option value="1" {CAN_BUY_Y}>{L_030}</option>
                                <option value="0" {CAN_BUY_N}>{L_029}</option>
                            </select>
                        </td>
                        <td>
                            <select name="auto_join" class="form-control">
                                <option value="1" {AUTO_JOIN_Y}>{L_030}</option>
                                <option value="0" {AUTO_JOIN_N}>{L_029}</option>
                            </select>
                        </td>
                        <td><input type="hidden" name="id" value="{GROUP_ID}"></td>
                    </tr>
                    <tr>
                        <th colspan="7">&nbsp;</th>
                    </tr>
<!-- ENDIF -->
<!-- BEGIN groups -->
                    <tr>
                        <td>{groups.ID}</td>
                        <td>{groups.NAME}</td>
                        <td>{groups.USER_COUNT}</td>
                        <td>{groups.CAN_SELL}</td>
                        <td>{groups.CAN_BUY}</td>
                        <td>{groups.AUTO_JOIN}</td>
                        <td><a href="usergroups.php?id={groups.ID}&action=edit" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> {L_298}</a></td>
                    </tr>
<!-- END groups -->
                    <tr>
                        <td colspan="7"><a href="usergroups.php?action=new"><i class="fa fa-plus"></i> {L_518}</a></td>
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