<!-- IF B_COUNTDOWN -->
<script type="text/javascript">
$(document).ready(function() {
	var currenttime = '{ENDS_IN}';
	function padlength(what)
	{
		var output=(what.toString().length == 1)? '0' + what : what;
		return output;
	}
	function displaytime()
	{
		currenttime -= 1;
		if (currenttime > 0){
			var hours = Math.floor(currenttime / 3600);
			var mins = Math.floor((currenttime - (hours * 3600)) / 60);
			var secs = Math.floor(currenttime - (hours * 3600) - (mins * 60));
			var timestring = padlength(hours) + ':' + padlength(mins) + ':' + padlength(secs);
			$("#ending_counter").html(timestring);
			setTimeout(displaytime, 1000);
		} else {
			$("#ending_counter").html('<div class="error-box">{L_911}</div>');
		}
	}
	setTimeout(displaytime, 1000);
});
</script>
<!-- ENDIF -->
<div class="row">
	<div class="col-md-12">
           <ul class="breadcrumb"><b>{L_041}:</b> {TOPCATSPATH}</ul>
	 <div class="panel panel-default">
            <div class="panel-body">
            	<div class="col-md-9 item-title text-capitalize">{TITLE}</div>
                <div class="col-md-3" style="text-align: right;"><span class="label label-default">{L_113}: {ID}</span><br><br>
		<!-- IF B_CANEDIT -->
	  			<a class="btn btn-primary btn-xs href="{SITEURL}edit_active_auction.php?id={ID}">{L_30_0069}</a>
                <!-- ENDIF -->
                </div>
	    </div>
  	</div>

        <div class="well well-sm" style="text-align: right;">
		{VIEW_HISTORY1} |
		<a href="{SITEURL}friend.php?id={ID}">{L_106}</a> | 
<!-- IF B_CANCONTACTSELLER -->
		<a href="{SITEURL}send_email.php?auction_id={ID}">{L_922}</a> | 
<!-- ENDIF -->
<!-- IF B_LOGGED_IN -->
		<a href="{SITEURL}item_watch.php?{WATCH_VAR}={ID}">{WATCH_STRING}</a>
<!-- ELSE -->
		<a href="{SITEURL}user_login.php?">{L_5202}</a>
<!-- ENDIF -->
	</div>
<!-- IF B_USERBID -->
	<div class="alert alert-success" role="alert">
		{YOURBIDMSG}
	</div>
<!-- ENDIF -->
	<br>

            <div class="row grid-padding">
             <div class="col-md-4 col-sm-5 grid-padding">
                 <!-- IF B_HASIMAGE -->
                       <img class="thumbnail img-responsive center-block" src="{SITEURL}getthumb.php?w={THUMBWIDTH}&fromfile={PIC_URL}" border="0" align="center"><br>
	         <!-- IF B_HASGALELRY -->
                       <div class="col-md-6 col-md-offset-3 panel panel-default" style="text-align: center;">
		       <a href="#gallery"><span class="glyphicon glyphicon-camera" aria-hidden="true" style="padding-right: 5px;"></span>{L_694}</a></div>
	         <!-- ENDIF -->
                 <!-- ENDIF -->
             </div>
             <div class="col-md-4 col-sm-7">
                  
					  <div>{L_611} <font color="#ff3300"><b>{AUCTION_VIEWS}</b></font> {L_612}</div>
					 <div> <a href="#description"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a>
					  <a href="#description">{L_018}</a> &nbsp;&nbsp;&nbsp;</div> 
					  <table class="table table-bordered table-striped">
						<!-- auction type -->
						<tr>
						 <td width="50%" align="left">{L_261}: </td>
						  <td align="left">{AUCTION_TYPE}</td>
						</tr>
						<!-- higher bidder -->
<!-- IF B_HASBUYER and B_NOTBNONLY -->
						<tr>
						  <td width='50%' style="leftpan" valign="top">
							{L_117}:
						  </td>
						  <td>
	<!-- BEGIN high_bidders -->
							<p>
		<!-- IF B_BIDDERPRIV -->
							<b>{high_bidders.BUYER_NAME}</b>
		<!-- ELSE -->
							<a href="{SITEURL}profile.php?user_id={high_bidders.BUYER_ID}&auction_id={ID}"><b>{high_bidders.BUYER_NAME}</b></a>
							<b>(<a href="{SITEURL}feedback.php?id={high_bidders.BUYER_ID}&faction=show">{high_bidders.BUYER_FB}</a>)</b> 
		<!-- ENDIF -->
							{high_bidders.BUYER_FB_ICON}</p>
	<!-- END high_bidders -->
						  </td>
						 </tr>
<!-- ENDIF -->
<!-- IF QTY gt 1 -->
						<tr>
						  <td width="50%" align="left">{L_901}: </td>
						  <td align="left">{QTY}</td>
						</tr>
<!-- ENDIF -->
						<tr>
						  <td width="50%" align="left">{L_923}: </td>
						  <td align="left">{COUNTRY}</td>
						</tr>
						<tr>
						  <td width="50%" align="left">{L_118}: </td>
						  <td align="left" valign="top">
<!-- IF B_COUNTDOWN -->
                          	<span id="ending_counter">{ENDS}</span>
<!-- ELSE -->
                          	{ENDS}<!-- IF B_SHOWENDTIME --><br><span class="smallspan">({ENDTIME})</span><!-- ENDIF -->
<!-- ENDIF -->
                          </td>
						</tr>
<!-- IF B_NOTBNONLY -->
						<tr>
						  <td width="50%" align="left">{L_119}: </td>
						  <td align="left">{NUMBIDS} {VIEW_HISTORY2}</td>
						</tr>
	<!-- IF ATYPE eq 2 -->
						<tr>
						  <td width="50%" align="left">
						  	{L_038}:
						  </td>
						  <td align="left">{MINBID}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
						  <td width="50%" align="left">{L_116}: </td>
						  <td align="left" valign="middle">{MAXBID}<!-- IF B_HASRESERVE -->&nbsp;<span class="smallspan">{L_514}</span><!-- ENDIF --></td>
						</tr>
<!-- ENDIF -->
						<tr>
						  <td width="50%" align="left">{L_023}: </td>
						  <td align="left">{SHIPPING_COST}</td>
						</tr>
<!-- IF B_ADDITIONAL_SHIPPING_COST or B_BUY_NOW_ONLY-->
						<tr>
						  <td width="50%" align="left">{L_350_1008}: </td>
						  <td align="left">{ADDITIONAL_SHIPPING_COST}</td>
						</tr>
<!-- ENDIF -->
<!-- IF B_BUY_NOW -->
						<tr>
						  <td width="50%" align="left">{L_496}:</td>
						  <td align="left">
						  	{BUYNOW2}
						  </td>
						</tr>
<!-- ENDIF -->
<!-- IF B_HASENDED -->
						<tr>
						  <td colspan="2" align="left"><b>{L_904}</b></td>
						</tr>
<!-- ENDIF -->
					  </table>
					
             </div>
             <div class="col-md-4 col-sm-12">
               <div class="panel panel-default">
                 <div class="panel-heading">
          	<b>{L_30_0209}</b>
                 </div>
		  <div class="panel-body">
                              <div>
				<a href='{SITEURL}profile.php?user_id={SELLER_ID}&auction_id={ID}'><b>{SELLER_NICK}</b></a>
				(<a href='{SITEURL}feedback.php?id={SELLER_ID}&faction=show'>{SELLER_TOTALFB}</A>)
				{SELLER_FBICON}
                              </div>
                        <div>
			  <ul class="list-unstyled">
				<li>{L_5509}{SELLER_NUMFB}{L__0151}
				<li><b>{L_5506}{SELLER_FBPOS}</b>
<!-- IF SELLER_FBNEG ne 0 -->
				<li>{SELLER_FBNEG}</li>
<!-- ENDIF -->
				<li>{L_5508}{SELLER_REG}</li>
			 </ul>
				<a href="{SITEURL}active_auctions.php?user_id={SELLER_ID}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" style="padding-right: 5px;"></span>{L_213}</a>
				<br><br>
			</div> 
		  <div class="titTable1">
<!-- IF B_HASENDED eq false and B_CAN_BUY -->
	<!-- IF B_NOTBNONLY -->
				<div class="well">
				<form name="bid" action="{BIDURL}bid.php" method="post">
				
					 
						
		<!-- IF QTY gt 1 -->
							{L_284}: <input type="text" name="qty" size=15 /> {QTY} {L_5408}<br>
		<!-- ENDIF -->
							{L_121} <input type="text" name="bid" size="15">
		<!-- IF ATYPE eq 1 -->
						{L_124}: {NEXTBID}
						 <br>
		<!-- ENDIF -->
						
				   
					 <input type="hidden" name="seller_id" value="{SELLER_ID}">
					 <input type="hidden" name="title" value="{TITLE}" >
					 <input type="hidden" name="category" value="{CAT_ID}" >
					 <input type="hidden" name="id" value="{ID}">
                     <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					 <input type="submit" name="" value="{L_30_0208}" class="btn btn-primary">
					
				</form>
				</div>
	<!-- ELSE -->
				{BUYNOW} <a href="{BIDURL}buy_now.php?id={ID}"><img border="0" align="absbottom" alt="{L_496}" src="{BNIMG}"></a>
	<!-- ENDIF -->
<!-- ENDIF -->
                 </div>
                 </div>
		  </div>
                </div>
             </div>
<div class="row">
     <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                 <h3 class="panel-title"><a name="description"></a>{L_018}</h3>
              </div>
                <div class="panel-body">
                {AUCTION_DESCRIPTION}
                </div>
          </div>

        <!-- IF B_HAS_QUESTIONS -->
	<div class="panel panel-default">
             <div class="panel-heading">
             <h3 class="panel-title"><a name="questions"></a>{L_552}</h3>
             </div>
                 <div class="panel-body">
        <!-- BEGIN questions -->
      	        <span class="glyphicon glyphicon-comment" aria-hidden="true" style="padding-right: 10px;"></span>{L_5239}
                 <div class="well">
		<!-- BEGIN conv -->
        	<p><span class="text-muted"><small>{questions.conv.BY_WHO}:</small></span> {questions.conv.MESSAGE}</p>
                <!-- END conv -->
                </div>
        <!-- END questions -->
                </div>
        </div>
        <!-- ENDIF -->
      
         <!-- IF B_HASGALELRY -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><a name="gallery"></a>{L_663}</h3>
  </div>
  <div class="panel-body">
    <div class="table2" style="text-align:center; overflow-y:auto;" id="gallery">
		<table>
			<tr>
		<!-- BEGIN gallery -->
				<td>
				<a href="{SITEURL}{UPLOADEDPATH}{ID}/{gallery.V}" title="">
					<img src="{SITEURL}getthumb.php?w={THUMBWIDTH}&fromfile={UPLOADEDPATH}{ID}/{gallery.V}" border="0" width="150px" hspace="10">
				</a>
				</td>
		<!-- END gallery -->
			</tr>
		</table>
		</div>
  </div>
</div>
        <!-- ENDIF -->

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{L_724}</h3>
  </div>
  <div class="panel-body">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <div class="tableContent2">
			<div class="table2">
<!-- IF COUNTRY ne '' or ZIP ne '' -->
			  <b>{L_014}:</b> {COUNTRY} ({ZIP})<br>
<!-- ENDIF -->
			  <b>{L_025}:</b> {SHIPPING}, {INTERNATIONAL}<br>
<!-- IF SHIPPINGTERMS ne '' -->
			  <table border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td valign="top"><b>{L_25_0215}:</b>&nbsp;</td>
				  <td valign="top">{SHIPPINGTERMS}</td>
				</tr>
			  </table>
<!-- ENDIF -->
			  <br>
			  <b>{L_026}:</b> {PAYMENTS}<br>
<!-- IF ! B_BUY_NOW_ONLY -->
			  <b><!-- IF ATYPE eq 1 -->{L_127}<!-- ELSE -->{L_038}<!-- ENDIF -->:</b> {MINBID}<br>
<!-- ENDIF -->
			  <br>
			  <b>{L_111}:</b> {STARTTIME}<br>
			  <b>{L_112}:</b> {ENDTIME}<br>
			  <b>{L_113}:</b> {ID}<br>
			  <br>
			  <b>{L_041}:</b> {CATSPATH}<br>
              <!-- IF SECCATSPATH ne '' --><b>{L_814}:</b> {SECCATSPATH}<!-- ENDIF -->
			</div>
		  </div>
		</td>
	  </tr>
	</table>
  </div>
</div>

        <!-- IF B_SHOWHISTORY -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><a name="history"></a>{L_26_0001}</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered table-striped table-condensed">
			<tr>
				<th width="33%" align="center">{L_176}</th>
				<th width="33%" align="center">{L_130}</th>
				<th width="33%" align="center">{L_175}</th>
	<!-- IF ATYPE eq 2 -->
				<th width="33%" align="center">{L_284}</th>
	<!-- ENDIF -->
			</tr>
	<!-- BEGIN bidhistory -->
			<tr valign="top" {bidhistory.BGCOLOUR}>
				<td>
		<!-- IF B_BIDDERPRIV -->
					{bidhistory.NAME}
		<!-- ELSE -->
					<a href="{SITEURL}profile.php?user_id={bidhistory.ID}">{bidhistory.NAME}</a>
		<!-- ENDIF -->
				</td>
				<td align="center">
					{bidhistory.BID}
				</td>
				<td align="center">
					{bidhistory.WHEN}
				</td>
		<!-- IF ATYPE eq 2 -->
				<td align="center">
					{bidhistory.QTY}
				</td>
		<!-- ENDIF -->
			</tr>
	<!-- END bidhistory -->
		</table>
  </div>
</div>
<!-- ENDIF -->

</div>
</div>
</div>
</div>