<!-- INCLUDE header.tpl -->
<link rel="stylesheet" type="text/css" href="{SITEURL}inc/calendar.css">
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom">{L_854}&nbsp;&gt;&gt;&nbsp;{L_854}</h4>
				<div class="plain-box">
                	<form action="" method="post">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                	<table cellpadding="0" cellspacing="0" width="100%" class="blank">
                    <tr>
                    	<td>{L_855}</td>
                    	<td>
                        	{L_5281} <input type="radio" name="type" value="m"<!-- IF TYPE eq 'm' --> checked="checked"<!-- ENDIF -->>
                        	{L_827} <input type="radio" name="type" value="w"<!-- IF TYPE eq 'w' --> checked="checked"<!-- ENDIF -->>
                        	{L_5285} <input type="radio" name="type" value="d"<!-- IF TYPE eq 'd' --> checked="checked"<!-- ENDIF -->>
                        	{L_2__0027} <input type="radio" name="type" value="a"<!-- IF TYPE eq 'a' --> checked="checked"<!-- ENDIF -->>
                        </td>
                    </tr>
                    <tr>
                    	<td>{L_856}</td>
                    	<td>
                        <input type="text" name="from_date" id="from_date" value="{FROM_DATE}" size="20" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'from_date','controlname': 'from_date'});
						</script>
                        -
                        <input type="text" name="to_date" id="to_date" value="{TO_DATE}" size="20" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'to_date','controlname': 'to_date'});
						</script> [Date format:(dd-mm-yyyy)]
                        </td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td>
                        	<input type="submit" name="act" value="{L_275}">
                        </td>
                    </tr>
					 <tr>
                    	<td>
						Period<br>
						<!-- IF START_END_DATE eq 1 && FROM_DATE eq 0 && TO_DATE eq 0 -->
						
						<b> ALL </b>
						<!-- ELSE -->
						<!-- IF FROM_DATE neq 0  -->
						<b>From:</b> Selected Date   <br>
						<!-- ELSE -->
						<b>From:</b> {START_DATE}   <br>
						<!-- ENDIF -->
						<!-- IF TO_DATE neq 0 -->
						<b>To:</b>  Selected Date
						<!-- ELSE -->
						<!-- IF START_END_DATE eq 1 && TO_DATE eq 0 -->
						<b>To:</b>  {TO_DATE_REPL}
						<!-- ELSE -->
						<b>To:</b>  {END_DATE}<!-- ENDIF -->
						<!-- ENDIF -->
						<!-- ENDIF -->
						</td>
                    	<td style="vertical-align:middle;">
                        	Total Sales: {TOTAL_AUCT_SALES}</a><br>
							(from {TOTALAUCTIONS} fees)
                        </td>
                    </tr>
					
                    </table>
              </form>
					
<table width="100%" class="">
<tr style="titTable6">
<th style="text-align: center;" class="titTable6 ">Invoice: </th>
<th style="width: 8%; text-align: center;" class="titTable6 rounded-left">User</th>
<th style="width: 8%; text-align: center;" class="titTable6 ">Total</th>
<th style="text-align: center;" class="titTable6 ">Status</th>

</tr>
<!-- BEGIN topay -->
<tr>
<td style="text-align: center;">Invoice: {topay.INVOICE}<br>Auction ID: {topay.ID}
<br>Date: {topay.DATE}</td>
<td style="text-align: center;">{topay.FEE_USER}</td>
<td style="text-align: center;">{topay.FEE_VALUE_F}</td>
<td style="text-align: center;" >{topay.PAID}{topay.TICK}<br><a href="{topay.PDF}">PDF</a></td>
</tr>
<!-- END topay -->
                </table>
<!-- IF PAGNATION -->
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
<!-- ENDIF -->
            </div>
        </div>
<!-- INCLUDE footer.tpl -->