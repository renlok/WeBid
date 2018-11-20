<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>{L_5142} <i class="fa fa-angle-double-right"></i> {L_276} <i class="fa fa-angle-double-right"></i> {L_078}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <form name="newcat" action="" method="post">
          <div class="plain-box">{L_845}</div>
          <table class="table table-bordered table-striped">
            <tr>
              <td width="10" height="21">&nbsp;</td>
              <td colspan="4" height="21">{CRUMBS}</td>
            </tr>
            <tr>
              <th width="10">&nbsp;</th>
              <th width="40%"><b>{L_087}</b></th>
              <th width="20%"><b>{L_328}</b></th>
              <th width="20%"><b>{L_329}</b></th>
              <th><b>{L_008}</b></th>
            </tr>
            <!-- BEGIN cats -->
            <tr>
              <td width="10" align="right" valign="middle"><a href="categories.php?parent={cats.CAT_ID}"><img src="{SITEURL}images/plus.gif" border="0" alt="Browse Subcategories"></a></td>
              <td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.CAT_NAME}" class="form-control"></td>
              <td><input type="text" name="colour[{cats.CAT_ID}]" value="{cats.CAT_COLOUR}" class="form-control"></td>
              <td><input type="text" name="image[{cats.CAT_ID}]" value="{cats.CAT_IMAGE}" class="form-control"></td>
              <td valign="middle"><input type="checkbox" name="delete[]" value="{cats.CAT_ID}">
                
                <!-- IF cats.B_SUBCATS --> 
                <img src="{SITEURL}themes/{THEME}/images/bullet_blue.png"> 
                <!-- ENDIF --> 
                <!-- IF cats.B_AUCTIONS --> 
                <img src="{SITEURL}themes/{THEME}/images/bullet_red.png"> 
                <!-- ENDIF --></td>
            </tr>
            <!-- END cats -->
            <tr>
              <td colspan="4" align="right">{L_30_0102}</td>
              <td><input type="checkbox" class="selectall" value="delete"></td>
            </tr>
            <tr>
              <td><i class="fa fa-plus"></i> {L_394}</td>
              <td><input type="text" name="new_category" class="form-control"></td>
              <td><input type="text" name="cat_colour" class="form-control"></td>
              <td><input type="text" name="cat_image" class="form-control"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" height="22">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><i class="fa fa-plus"></i> {L_368}</td>
              <td colspan="3"><textarea name="mass_add" class="form-control"></textarea></td>
            </tr>
          </table>
          <input type="hidden" name="parent" value="{PARENT}">
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          <input type="submit" name="action" class="btn btn-primary" value="{L_089}">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- INCLUDE footer.tpl -->
