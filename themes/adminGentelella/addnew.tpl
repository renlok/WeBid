<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_516} <i class="fa fa-angle-double-right"></i> {TITLE}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="addnew" action="" method="post">
          <table class="table table-bordered table-striped">
            <!-- BEGIN lang -->
            <tr valign="top"> 
              <!-- IF lang.S_FIRST_ROW -->
              <td align="right">{L_519}:</td>
              <!-- ELSE -->
              <td>&nbsp;</td>
              <!-- ENDIF -->
              <td width="35" align="right"><img src="../images/flags/{lang.LANG}.gif"></td>
              <td><input type="text" name="title[{lang.LANG}]" class="form-control" maxlength="255" value="{lang.TITLE}"></td>
            </tr>
            <!-- END lang --> 
            <!-- BEGIN lang -->
            <tr> 
              <!-- IF lang.S_FIRST_ROW -->
              <td valign="top" align="right">{L_520}:</td>
              <!-- ELSE -->
              <td>&nbsp;</td>
              <!-- ENDIF -->
              <td align="right" valign="top"><img src="../images/flags/{lang.LANG}.gif"></td>
              <td><textarea name="content[{lang.LANG}]" class="form-control">{lang.CONTENT}</textarea></td>
            </tr>
            <!-- END lang -->
            
              </tr>
            
            <tr>
              <td align="right">{L_521}</td>
              <td>&nbsp;</td>
              <td><input type="radio" name="suspended" value="0"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_yes} <input type="radio" name="suspended" value="1"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_no} </td>
            </tr>
          </table>
          <!-- IF ID ne '' -->
          <input type="hidden" name="id" value="{ID}">
          <!-- ENDIF -->
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <input type="submit" class="btn btn-primary" value="{BUTTON}">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- INCLUDE footer.tpl -->
