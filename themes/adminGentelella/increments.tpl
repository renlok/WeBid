   <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_128}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="increments" action="" method="post">
					<div class="plain-box">
                    	{L_135}
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b>{L_240}</b></th>
                            <th><b>{L_241}</b></th>
                            <th><b>{L_137}</b></th>
                            <th width="10%"><b>{L_008}</b></th>
                        </tr>
<!-- BEGIN increments -->
                        <tr>
                             <td>&nbsp;</td>
                             <td>
                                <input type="hidden" name="id[]" value="{increments.ID}">
                                <input type="text" name="lows[]" value="{increments.LOW}" class="form-control">
                             </td>
                             <td><input type="text" name="highs[]" value="{increments.HIGH}" class="form-control"></td>
                     <td><input type="text" name="increments[]" value="{increments.INCREMENT}" class="form-control"></td>
                             <td align="center"><input type="checkbox" name="delete[]" value="{increments.ID}"></td>
                        </tr>
<!-- END increments -->
                        <tr>
                            <td colspan="4" align="right">{L_30_0102}</td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
                        </tr>
                        <tr>
                            <td>{L_518}</td>
                            <td>
                                <input type="hidden" name="id[]" value="">
                                <input type="text" name="lows[]" class="form-control">
                            </td>
                            <td><input type="text" name="highs[]" class="form-control"></td>
                            <td><input type="text" name="increments[]" class="form-control"></td>
                            <td align="center">&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_089}">
				</form>
            </div>
        </div>
         </div>
        </div>
<!-- INCLUDE footer.tpl -->
