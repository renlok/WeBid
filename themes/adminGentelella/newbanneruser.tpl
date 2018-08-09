    	<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0011} <i class="fa fa-angle-double-right"></i> {L_banner_admin} <i class="fa fa-angle-double-right"></i> {L__0026}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="newuser" action="" method="post">
                    <table class="table table-bordered table-striped">
                    <tr>
                    	<td>{L_302}</td>
                        <td><input type="text" name="name" value="{NAME}" class="form-control"></td>
                    </tr>
                    <tr>
                    	<td>{L__0022}</td>
                        <td><input type="text" name="company" value="{COMPANY}" class="form-control"></td>
                    </tr>
                    <tr>
                    	<td>{L_107}</td>
                        <td><input type="text" name="email" value="{EMAIL}" class="form-control"></td>
                    </tr>
					</table>
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="hidden" name="action" value="insert">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_569}">
				</form>
            </div>
        </div>
         </div>
        </div>
<!-- INCLUDE footer.tpl -->
