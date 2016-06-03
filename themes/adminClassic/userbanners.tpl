		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0011}&nbsp;&gt;&gt;&nbsp;{L__0008}&nbsp;&gt;&gt;&nbsp;{L__0024}</h4>
				<form name="upldbanner" action="" method="post" enctype="multipart/form-data">
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="10%">{L_5180}</td>
							<td width="80%">{NAME}</td>
							<td rowspan="3" align="center" valign="middle">
								<a href="editbannersuser.php?id={ID}"><img src="{SITEURL}themes/{THEME}/images/bullet_wrench.png"></a>
							</td>
						</tr>
						<tr>
							<td>{L__0022}</td>
							<td>{COMPANY}</td>
						</tr>
						<tr>
							<td>{L_303}</td>
							<td>{EMAIL}</td>
						</tr>
					</table>
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th colspan="5">{L__0043}</th>
						</tr>
<!-- BEGIN banners -->
						<tr {banners.BG}>
							<td colspan="5" align="center">
	<!-- IF banners.TYPE eq 'swf' -->
								<object width="{banners.WIDTH}" height="{banners.HEIGHT}">
									<param name="movie" value="{SITEURL}{banners.BANNER}">
									<param name="quality" value="high">
									<embed src="{SITEURL}{banners.BANNER}" width="{banners.WIDTH}" height="{banners.HEIGHT}"></embed>
								</object>
	<!-- ELSE -->
								<a target="_blank" href="{banners.URL}"><img border="0" alt="{banners.ALT}" src="{SITEURL}{banners.BANNER}"></a>
	<!-- ENDIF -->
								<p><a target="_blank" href="{banners.URL}">{banners.SPONSERTEXT}</a></p>
							</td>
						</tr>
						<tr>
							<td>{L__0050} <strong><a target="_blank" href="{banners.URL}">{banners.URL}</a></strong></td>
							<td>{L__0049} <strong>{banners.VIEWS}</strong></td>
							<td>{L__0051} <strong>{banners.CLICKS}</strong></td>
							<td>{L__0045}: <strong>{banners.PURCHASED}</strong></td>
							<td align="center">
								<a href="viewfilters.php?banner={banners.ID}&amp;id={ID}" class="new-window" alt="{L__0052}"><img src="{SITEURL}themes/{THEME}/images/cog.png" alt="{L__0052}"	></a>
	<!-- IF NOTEDIT -->
								<a href="editbanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/images/application_form_edit.png" alt="{L__0055}"></a>
								<a href="deletebanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/images/bin.png" alt="{L_008}"></a>
	<!-- ENDIF -->
							</td>
						</tr>
<!-- END banners -->
					</table>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th colspan="2"><strong><!-- IF NOTEDIT -->{L__0041}<!-- ELSE -->{L__0055}<!-- ENDIF --></strong></th>
						</tr>
						<tr>
							<td width="30%">{L__0029}</td>
							<td><input type="file" name="bannerfile" size="40">{L__0042}<p>{L__0036}</p></td>
						</tr>
						<tr>
							<td>{L__0030}</td>
							<td><input type="text" name="url" SIZE="45" value="{URL}">{L__0042}<p>{L__0037}</p></td>
						</tr>
						<tr>
							<td>{L__0031}</td>
							<td><input type="text" name="sponsortext" SIZE="45" value="{SPONSORTEXT}"><p>{L__0038}</p></td>
						</tr>
						<tr>
							<td>{L__0032}</td>
							<td><input type="text" name="alt" SIZE="45" value="{ALT}"><p>{L__0038}</p></td>
						</tr>
						<tr>
							<td>{L__0045}</td>
							<td><input type="text" name="purchased" SIZE="8" value="{PURCHASED}"><p>{L__0046}</p></td>
						</tr>
						<tr>
							<td colspan="2">
								<p>{L__0033}</p>
								<p>{L__0039}</p>
							</td>
						</tr>
						<tr>
							<td>{L_276}</td>
							<td>{CATEGORIES}</td>
						</tr>
						<tr>
							<td>{L__0035}</td>
							<td><textarea name="keywords" cols="45" rows="8">{KEYWORDS}</textarea></td>
						</tr>
					</table>
					<input type="hidden" name="action" value="insert">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="banner" value="{BANNERID}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="<!-- IF NOTEDIT -->{L__0040}<!-- ELSE -->{L__0055}<!-- ENDIF -->">
				</form>
			</div>
		</div>
