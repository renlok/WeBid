   <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_525}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<form name="errorlog" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong>{ERROR}</div>
<!-- ENDIF -->
					<div class="plain-box"><a href="newadminuser.php">{L_367}</a></div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="30%">{L_username}</th>
                            <th width="16%">{L_558}</th>
                            <th width="19%">{L_559}</th>
                            <th width="12%">{L_560}</th>
                            <th width="23%">{L_561}</th>
                        </tr>
<!-- BEGIN users -->
                        <tr {users.BG}>
                            <td><a href="editadminuser.php?id={users.ID}">{users.USERNAME}</a></td>
                            <td align="center">{users.CREATED}</td>
                            <td align="center">{users.LASTLOGIN}</td>
                            <td align="center">{users.STATUS}</td>
                            <td align="center"><input type="checkbox" name="delete[]" value="{users.ID}"></td>
                        </tr>
<!-- END users -->
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="Submit" value="{L_561}" class="btn btn-primary">
				</form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
