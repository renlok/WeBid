    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0012} <i class="fa fa-angle-double-right"></i> {L_766}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
                	<form action="" method="get" class="form-horizontal">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                	<table class="table table-bordered table-striped">
                    <tr>
                    	<td>{L_313}</td>
                    	<td>
                        	<input type="text" name="username" value="{USER_SEARCH}" class="form-control">
                        </td>
                    </tr>
                    <tr>
                    	<td>{L_856}</td>
                    	<td>
                        <input type="text" name="from_date" id="from_date" value="{FROM_DATE}" class="form-control" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'from_date','controlname': 'from_date'});
						</script>
                        -
                        <input type="text" name="to_date" id="to_date" value="{TO_DATE}" class="form-control" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'to_date','controlname': 'to_date'});
						</script>
                        </td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td>
                        	<input type="submit" name="act" value="{L_275}" class="btn btn-primary">
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <table width="98%" cellpadding="0" cellspacing="0">
                <tr style="background-color:{TBLHEADERCOLOUR}">
					<th align="center">{L_1041}</th>
<!-- IF NO_USER_SEARCH -->
					<th align="center">{L_313}</th>
<!-- ENDIF -->
					<th>{L_1039}</th>
					<th align="center">{L_1053}</th>
					<th align="center">{L_560}</th>
				</tr>
<!-- BEGIN invoices -->
				<tr>
					<td align="center">
						<span class="titleText125">{L_1041}: {invoices.INVOICE}</span>
						<p class="smallspan">{invoices.DATE}</p>
					</td>
	<!-- IF NO_USER_SEARCH -->
					<td align="center">{invoices.USER}</td>
	<!-- ENDIF -->
					<td>{invoices.INFO}</td>
					<td align="center">{invoices.TOTAL}</td>
					<td align="center">
						<!-- IF invoices.PAID --><p>{L_898}</p><!-- ENDIF --><a href="{SITEURL}order_print.php?id={invoices.INVOICE}" tagret="_blank">{L_1058}</a>
					</td>
				</tr>
<!-- END invoices -->
                </table>
<!-- IF PAGNATION -->
                <table class="table table-bordered table-striped">
                    <tr>
                        <td align="center">
                            {L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                            <br>
                            {PREV}
	<!-- BEGIN pages -->
                            {pages.PAGE}&nbsp;&nbsp;
	<!-- END pages -->
                            {NEXT}
                        </td>
                    </tr>
				</table>
<!-- ENDIF -->
            </div>
        </div>
         </div>
        </div>
<!-- INCLUDE footer.tpl -->
