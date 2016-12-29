    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_5236} <i class="fa fa-angle-double-right"></i> {L_5231}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<form name="newfaq" action="" method="post">
                    <table class="table table-bordered table-striped">
						<tr valign="top">
    						<td align="right">{L_5231}:</td>
    						<td>&nbsp;</td>
                            <td>
                            	<select name="category" class="form-control">
<!-- BEGIN cats -->
                                	<option value="{cats.ID}">{cats.CATEGORY}</option>
<!-- END cats -->
                                </select>
                            </td>
                        </tr>
    <!-- BEGIN qs -->
                        <tr>
    	<!-- IF qs.S_FIRST_ROW -->
        					<td>{L_5239}:</td>
        <!-- ELSE -->
        					<td>&nbsp;</td>
        <!-- ENDIF -->
                            <td align="right"><img src="../includes/flags/{qs.LANG}.gif"></td>
                            <td><input type="text" name="question[{qs.LANG}]" maxlength="200" value="{qs.QUESTION}"></td>
                        </tr>
    <!-- END qs -->
    <!-- BEGIN as -->
                        <tr>
    	<!-- IF as.S_FIRST_ROW -->
        					<td valign="top">{L_5240}:</td>
        <!-- ELSE -->
        					<td>&nbsp;</td>
        <!-- ENDIF -->
                            <td align="right" valign="top"><img src="../includes/flags/{as.LANG}.gif"></td>
                            <td><textarea name="answer[{as.LANG}]" cols="40" rows="15">{as.ANSWER}</textarea></td>
                        </tr>
    <!-- END as -->
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
