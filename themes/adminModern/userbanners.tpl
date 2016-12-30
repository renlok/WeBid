		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0011}&nbsp;&gt;&gt;&nbsp;{L__0008}&nbsp;&gt;&gt;&nbsp;{L__0024}</h4>
				<form name="upldbanner" action="" method="post" enctype="multipart/form-data">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">{L_5180}</div>
								<div class="col-md-3">{NAME}</div>
								<div class="col-md-3"><a href="editbannersuser.php?id={ID}"><img src="{SITEURL}themes/{THEME}/images/bullet_wrench.png"></a></div>
							</div>
							<div class="row">
								<div class="col-md-3">{L__0022}</div>
								<div class="col-md-3">{COMPANY}</div>
							</div>
							<div class="row">
								<div class="col-md-3">{L_303}</div>
								<div class="col-md-3">{EMAIL}</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12"><strong>{L__0043}</strong></div>
							</div>
<!-- BEGIN banners -->
							<div class="row">
								<div class="col-md-12">
<!-- IF banners.TYPE eq 'swf' -->
									<object width="{banners.WIDTH}" height="{banners.HEIGHT}">
										<param name="movie" value="{SITEURL}{banners.BANNER}">
										<param name="quality" value="high">
										<embed src="{SITEURL}{banners.BANNER}" width="{banners.WIDTH}" height="{banners.HEIGHT}">
									</object>
	<!-- ELSE -->
									<a target="_blank" href="{banners.URL}"><img border="0" alt="{banners.ALT}" src="{SITEURL}{banners.BANNER}"></a>
	<!-- ENDIF -->
								</div>
							</div>
							<div class="row">
								<div class="col-md-12"><a target="_blank" href="{banners.URL}">{banners.SPONSERTEXT}</a></div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0050} <strong><a target="_blank" href="{banners.URL}">{banners.URL}</a></strong></div>
								<div class="col-md-1">{L__0049} <strong>{banners.VIEWS}</strong></div>
								<div class="col-md-1">{L__0051} <strong>{banners.CLICKS}</strong></div>
								<div class="col-md-2">{L__0045}: <strong>{banners.PURCHASED}</strong></div>
								<div class="col-md-2">
									<a href="viewfilters.php?banner={banners.ID}&amp;id={ID}" class="new-window" alt="{L__0052}"><img src="{SITEURL}themes/{THEME}/images/cog.png" alt="{L__0052}"	></a>
	<!-- IF NOTEDIT -->
									<a href="editbanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/images/application_form_edit.png" alt="{L__0055}"></a>
									<a href="deletebanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/images/bin.png" alt="{L_008}"></a>
	<!-- ENDIF -->
								</div>
							</div>
							<br>
<!-- END banners -->
							<div class="row">
								<div class="col-md-12"><strong><!-- IF NOTEDIT -->{L__0041}<!-- ELSE -->{L__0055}<!-- ENDIF --></strong></div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0029}</div>
								<div class="col-md-6"><input type="file" name="bannerfile" size="40">{L__0042}<p>{L__0036}</p></div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0030}</div>
								<div class="col-md-6"><input type="text" name="url" SIZE="45" value="{URL}">{L__0042}<p>{L__0037}</p></div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0031}</div>
								<div class="col-md-6"><input type="text" name="sponsortext" SIZE="45" value="{SPONSORTEXT}"><p>{L__0038}</p></div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0032}</div>
								<div class="col-md-6"><input type="text" name="alt" SIZE="45" value="{ALT}"><p>{L__0038}</p></div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0045}</div>
								<div class="col-md-6"><input type="text" name="purchased" SIZE="8" value="{PURCHASED}"><p>{L__0046}</p></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12"><strong>{L__0033}</strong></div>
							</div>
							<div class="row">
								<div class="col-md-12">{L__0039}</div>
							</div>
							<div class="row">
								<div class="col-md-6">{L_276}</div>
								<div class="col-md-6">
									<select name="category[]" rows="12" multiple>
									<!-- BEING categories -->
										<option value="{categories.CAT_ID}"<!-- IF categories.B_SELECTED --> selected="true"<!-- ENDIF -->>{categories.CAT_NAME}</option>
									<!-- END categories -->
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">{L__0035}</div>
								<div class="col-md-6"><textarea class="form-control" name="keywords" cols="45" rows="8">{KEYWORDS}</textarea></div>
							</div>
						</div>
					</div>
					<input type="hidden" name="action" value="insert">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="banner" value="{BANNERID}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act"><!-- IF NOTEDIT -->{L__0040}<!-- ELSE -->{L__0055}<!-- ENDIF --></button>
				</form>
			</div>
		</div>
