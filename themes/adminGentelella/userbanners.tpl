
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                                <div class="x_title">
                                   <h2>{L_25_0011} <i class="fa fa-angle-double-right"></i> {L__0008} <i class="fa fa-angle-double-right"></i> {L__0024}</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                       <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12"> </h4>
				<form name="upldbanner" action="" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered table-striped">
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
                    <table class="table table-bordered table-striped">
                    <tr>
                    	<th colspan="5">{L__0043}</th>
                    </tr>
<!-- BEGIN banners -->
                    <tr<!-- IF banners.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
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
                        	<a href="viewfilters.php?banner={banners.ID}&amp;id={ID}" class="new-window" alt="{L__0052}"><img src="{SITEURL}themes/{THEME}/images/cog.png" alt="{L__0052}"></a>
	<!-- IF NOTEDIT -->
                        	<a href="editbanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/images/application_form_edit.png" alt="{L__0055}"></a>
                        	<a href="deletebanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/images/bin.png" alt="{L_008}"></a>
	<!-- ENDIF -->
                        </td>
                    </tr>
<!-- END banners -->
                    </table>
                    <table class="table table-bordered table-striped">
                    <tr>
                    	<th colspan="2"><!-- IF NOTEDIT -->{L__0041}<!-- ELSE -->{L__0055}<!-- ENDIF --></th>
                    </tr>
                    <tr>
                    	<td width="30%">{L__0029}</td>
                    	<td><input type="file" name="bannerfile" class="btn btn-default">{L__0042}<p>{L__0036}</p></td>
                    </tr>
                    <tr>
                    	<td>{L__0030}</td>
                    	<td><input type="text" name="url" class="form-control" value="{URL}">{L__0042}<p>{L__0037}</p></td>
                    </tr>
                    <tr>
                    	<td>{L__0031}</td>
                    	<td><input type="text" name="sponsortext" class="form-control" value="{SPONSORTEXT}"><p>{L__0038}</p></td>
                    </tr>
                    <tr>
                    	<td>{L__0032}</td>
                    	<td><input type="text" name="alt" class="form-control" value="{ALT}"><p>{L__0038}</p></td>
                    </tr>
                    <tr>
                    	<td>{L__0045}</td>
                    	<td><input type="text" name="purchased" class="form-control" value="{PURCHASED}"><p>{L__0046}</p></td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<p>{L__0033}</p>
                        	<p>{L__0039}</p>
                        </td>
                    </tr>
                    <tr>
                    	<td>{L_276}</td>
                    	<td>
                        <select name="category[]" rows="12" multiple>
                        <!-- BEING categories -->
                          <option value="{categories.CAT_ID}"<!-- IF categories.B_SELECTED --> selected="true"<!-- ENDIF -->>{categories.CAT_NAME}</option>
                        <!-- END categories -->
                        </select>
                      </td>
                    </tr>
                    <tr>
                    	<td>{L__0035}</td>
                    	<td><textarea name="keywords" class="form-control">{KEYWORDS}</textarea></td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="insert">
                    <input type="hidden" name="id" value="{ID}">
                    <input type="hidden" name="banner" value="{BANNERID}">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="btn btn-primary" value="<!-- IF NOTEDIT -->{L__0040}<!-- ELSE -->{L__0055}<!-- ENDIF -->">
				</form>
            </div>
        </div>
        </div>
        </div>
<!-- INCLUDE footer.tpl -->
