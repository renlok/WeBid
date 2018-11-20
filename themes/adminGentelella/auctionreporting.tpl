<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_reporting_settings}</h4>
				<div class="clearfix"></div>
	  </div>
	  <div class="col-md-12">
				<form name="reporting" action="" method="post">
					<div class="plain-box">
						{L_allow_reporting}
<!-- IF ALLOW eq '1' -->
							<input type="checkbox" name="reporting[allow_reporting]" value="true" checked>
<!-- ELSE -->
							<input type="checkbox" name="reporting[allow_reporting]" value="false">
<!-- ENDIF -->
					</div>
					<div><br></div>
					<div class="plain-box">{L_reporting_reasons_explain}</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th>&nbsp;</th>
							<th><b>{L_auction_reporting_reasons}</b></th>
							<th><b>{L_008}</b></th>
						</tr>
<!-- BEGIN reporting -->
						<tr>
							<td>
								<input type="hidden" name="reporting[{reporting.ID}][id]" value="{reporting.ID}" size="10">
							</td>
							<td>
								<input type="text" name="reporting[{reporting.ID}][reason]" value="{reporting.REASON}" size="110">
							</td>
							<td align="center">
								<input type="checkbox" name="delete[]" value="{reporting.ID}">
							</td>
						</tr>
<!-- END reporting -->
						<tr>
							<td colspan="2" align="right">{L_30_0102}</td>
							<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_394}</td>
							<td>
								<input type="text" name="new_reason" size="110">
							</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
				</div>
			</div>
		</div>
	</div>
<!-- INCLUDE footer.tpl -->
