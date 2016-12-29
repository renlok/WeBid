    	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_607}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
                <form name="conf" action="" method="post">
<!-- IF B_PREVIEW -->
					<div class="main-box">{PREVIEW}</div>
<!-- ENDIF -->
				<table class="table table-bordered table-striped">
					<tr valign="top">
						<td width="175">{L_5299}</td>
						<td style="padding:3px;">
							{SELECTBOX}
						</td>
					</tr>
					<tr valign="top">
						<td width="175">{L_332}</td>
						<td style="padding:3px;">
							<input type="text" name="subject" value="{SUBJECT}" size="50" maxlength="255">
						</td>
					</tr>
					<tr valign="top">
						<td width="175">{L_605}</td>
						<td style="padding:3px;">
							{EDITOR}
						</td>
					</tr>
				</table>
<!-- IF B_PREVIEW -->
					<span class="smallspan">{L_606}</span>
                    <input type="hidden" name="action" value="submit">
                    <input type="submit" name="act" class="centre" value="{L_007}">
<!-- ELSE -->
                    <input type="hidden" name="action" value="preview">
                    <input type="submit" name="act" class="btn btn-primary" value="{L_25_0224}">
<!-- ENDIF -->
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				</form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
