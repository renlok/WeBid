	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_239} <i class="fa fa-angle-double-right"></i> {PAGE_TITLE}</h2>
                                    <div class="clearfix"></div>
                                </div>
          <div class="col-md-12">
				<div class="plain-box">{NUM_AUCTIONS} {L_311}<!-- IF B_SEARCHUSER --> {L_934}{USERNAME}<!-- ENDIF --></div>
                <table class="table table-bordered table-striped">
                <tr>
                    <th align="center"><b>{L_017}</b></th>
                    <th align="center"><b>{L_557}</b></th>
                    <th align="left"><b>{L_297}</b></th>
                <tr>
                <!-- BEGIN auctions -->
                <tr<!-- IF auctions.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
                    <td>
                        <!-- IF auctions.SUSPENDED eq 1 -->
                        <span style="color:#FF0000">{auctions.TITLE}</span>
                        <!-- ELSE -->
                        {auctions.TITLE}
                        <!-- ENDIF -->
                        <p>[ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</p>
                    </td>
                    <td>
                        <b>{L_003}:</b> {auctions.USERNAME}<br>
                        <b>{L_625}:</b> {auctions.START_TIME}<br>
                        <b>{L_626}:</b> {auctions.END_TIME}<br>
                        <b>{L_041}:</b> {auctions.CATEGORY}
                    </td>
                    <td align="left">
                        <a href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a><br>
                        <a href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a><br>
                        <a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">
                    <!-- IF auctions.SUSPENDED eq 0 -->
                        {L_300}
                    <!-- ELSE -->
                        {L_310}
                    <!-- ENDIF -->
                    	</a>
                    <!-- IF auctions.B_HASWINNERS -->
                        <br><a href="viewwinners.php?id={auctions.ID}&offset={PAGE}">{L__0163}</a>
                    <!-- ENDIF -->
                    </td>
                </tr>
                <!-- END auctions -->
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
<!-- INCLUDE footer.tpl -->
