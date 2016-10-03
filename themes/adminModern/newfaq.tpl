<!-- INCLUDE header.tpl -->
    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_5236} <i class="fa fa-angle-double-right"></i> {L_5231}</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                       <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<form name="newfaq" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
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
<!-- BEGIN lang -->
						<tr valign="top">
	<!-- IF lang.S_FIRST_ROW -->
    						<td align="right">{L_5239}:</td>
    <!-- ELSE -->
    						<td>&nbsp;</td>
    <!-- ENDIF -->
                            <td width="35" align="right"><img src="../inc/flags/{lang.LANG}.gif"></td>
                            <td><input type="text" name="question[{lang.LANG}]" class="form-control" maxlength="255" value="{lang.TITLE}"></td>
                        </tr>
<!-- END lang -->
<!-- BEGIN lang -->
						<tr>
	<!-- IF lang.S_FIRST_ROW -->
    						<td valign="top" align="right">{L_5240}:</td>
    <!-- ELSE -->
    						<td>&nbsp;</td>
    <!-- ENDIF -->
                            <td align="right" valign="top"><img src="../inc/flags/{lang.LANG}.gif"></td>
                            <td><textarea name="answer[{lang.LANG}]" class="form-control">{lang.CONTENT}</textarea></td>
                        </tr>
<!-- END lang -->
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