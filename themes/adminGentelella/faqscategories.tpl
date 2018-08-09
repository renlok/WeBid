    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_5236} <i class="fa fa-angle-double-right"></i> {L_5230}</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                       <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<form name="newfaqcat" action="" method="post">
                    <table class="table table-bordered table-striped">
<!-- IF B_ADDCAT -->
                        <tr bgcolor="#FFFF66">
    						<td>{L_165}</td>
                            <td colspan="2">
	<!-- BEGIN lang -->
                                <p>{lang.LANG}:&nbsp;<input type="text" name="cat_name[{lang.LANG}]" class="form-control" maxlength="200"></p>
	<!-- END lang -->
                                <input type="submit" name="action" value="{L_5204}">
                            </td>
                        </tr>
<!-- ELSE -->
                        <tr>
                            <td colspan="3"><a href="faqscategories.php?do=add">{L_5234}</a></td>
                        </tr>
<!-- ENDIF -->
                        <tr>
                            <th width="14%"><b>{L_5237}</b></th>
                            <th><b>{L_287}</b></th>
                            <th width="14%"><b>{L_008}</b></th>
                        </tr>
<!-- BEGIN cats -->
                        <tr<!-- IF cats.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
                            <td>{cats.ID}</td>
                            <td><a href="editfaqscategory.php?id={cats.ID}">{cats.CATEGORY}</a> <!-- IF cats.FAQS gt 0 -->{cats.FAQSTXT}<!-- ENDIF --></td>
                            <td align="center"><input type="checkbox" name="delete[]" value="{cats.ID}"></td>
                        </tr>
<!-- END cats -->
                    </table>
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="action" class="btn btn-primary" value="{L_008}">
				</form>
            </div>
        </div>
         </div>
        </div>
<!-- INCLUDE footer.tpl -->
