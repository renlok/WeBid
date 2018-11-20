    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_5232}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<form name="deletefaqs" action="" method="post">
					<table class="table table-bordered table-striped">
                    <tr>
                        <td colspan="3"><a href="newfaq.php">{L_5231}</a></td>
                    </tr>
<!-- BEGIN cats -->
                    <tr>
                        <th width="86%">{cats.CAT}</th>
                        <th>&nbsp;</th>
                    </tr>
	<!-- BEGIN faqs -->
                    <tr>
                        <td><a href="editfaq.php?id={faqs.ID}">{faqs.FAQ}</a></td>
                        <td align="center">
                            <input type="checkbox" name="delete[]" value="{faqs.ID}">
                        </td>
                    </tr>
	<!-- END faqs -->
<!-- END cats -->
                    <tr>
                        <td align="right">{L_30_0102}</td>
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
