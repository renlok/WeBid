        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_25_0018} <i class="fa fa-angle-double-right"></i> {L_516}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12"> 
                <div class="plain-box">{NEWS_COUNT}{L_517} <a href="addnew.php"><i class="fa fa-plus"></i> {L_518}</a></div>
                <table class="table table-bordered table-striped">
                <tr>
                	<th width="20%">{L_314}</th>
                	<th width="60%">{L_312}</th>
                	<th>{L_297}</th>
                </tr>
<!-- BEGIN news -->
                <tr<!-- IF news.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
                	<td>{news.DATE}</td>
                	<td <!-- IF news.SUSPENDED eq 1 -->style="background: #FAD0D0; color: #B01717; font-weight: bold;"<!-- ENDIF -->>{news.TITLE}</td>
                	<td>
                    	<a href="editnew.php?id={news.ID}&PAGE={PAGE}">{L_298}</a><br>
						<a href="deletenews.php?id={news.ID}&PAGE={PAGE}">{L_008}</a>
                    </td>
                </tr>
<!-- END news -->
                </table>
                <table width="98%" cellpadding="0" cellspacing="0" class="blank">
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
            </div>
        </div>
       </div>
        </div>
