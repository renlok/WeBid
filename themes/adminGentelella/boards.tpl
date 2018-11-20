<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_board_management}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="deletelogs" action="" method="post">
          <div class="plain-box"><b>{L_delete_board_warning}</b></div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="6%">{L_129}</th>
						<th>{L_294}</th>
						<th width="10%" align="center">{L_show}</th>
						<th width="12%" align="center">{L_num_messages}</th>
              <th width="16%">&nbsp;</th>
            </tr>
            <!-- BEGIN boards -->
            <tr>
              <td>{boards.ID}</td>
              <td><a href="editboards.php?id={boards.ID}">{boards.NAME}</a> 
                <!-- IF boards.ACTIVE eq 2 --> 
                <b>[{L_5039}]</b> 
                <!-- ENDIF --></td>
              <td align="center">{boards.MSGTOSHOW}</td>
              <td align="center">{boards.MSGCOUNT}</td>
              <td align="center"><input type="checkbox" name="delete[]" value="{boards.ID}"></td>
            </tr>
            <!-- END boards -->
            <tr>
              <td colspan="4" align="right">{L_30_0102}</td>
              <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
            </tr>
          </table>
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <input type="submit" name="act" class="btn btn-primary" value="{L_008}">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- INCLUDE footer.tpl -->
