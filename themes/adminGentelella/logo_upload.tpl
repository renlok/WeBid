		<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
				<h2>{L_25_0009} <i class="fa fa-angle-double-right"></i> {L_30_0215}</h2>
<div class="clearfix"></div>
      </div>
      <div class="col-md-12">
				<form name="logo" action="" method="post" enctype="multipart/form-data">
<table class="table table-bordered table-striped">
								<td class="col-md-3">{L_your_logo}</td>
								<td class="col-md-9"><img src="{IMAGEURL}"></td>
							</tr>
							<div class="row">
								<td class="col-md-3">{L_upload_new_logo}</td>
								<td class="col-md-9">
									<label class="btn btn-primary" for="logo">
										Browse <input id="logo" type="file" name="logo" style="display:none;">
									</label>
								</td>
							</div>
						</div>
					</div>
</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_30_0215}</button>
				</form>
			</div>
		</div>
