<!-- INCLUDE header.tpl -->
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<div class="box">
                	<h4 class="rounded-top">{L_5436}</h4>
                    <div class="rounded-bottom">
                    	<ul class="menu">
                        	<li><a href="{SITEURL}admin/maintainance.php">{L__0001}</a></li>
                        	<li><a href="{SITEURL}admin/wordsfilter.php">{L_5068}</a></li>
                        	<li><a href="{SITEURL}admin/errorlog.php">{L_891}</a></li>
                        </ul>
                    </div>
                </div>
            	<div class="box">
                	<h4 class="rounded-top">Something</h4>
                    <div class="rounded-bottom">
                    	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tincidunt varius elit non dapibus. Donec nec mauris quis metus volutpat pellentesque. Mauris justo lacus, porttitor non commodo non, tincidunt et velit. Suspendisse nulla elit, laoreet sit amet gravida vitae, iaculis interdum massa. Aliquam pretium turpis quis odio posuere id molestie risus adipiscing. Suspendisse nisi purus, feugiat quis pellentesque non, ultricies sed metus. Sed mollis leo et leo auctor gravida. Aenean accumsan lacus ut erat viverra bibendum. Nulla eu gravida quam. Phasellus sit amet est massa. Nulla pellentesque facilisis velit dignissim euismod. Sed tincidunt quam eget lorem placerat commodo. Proin ultrices, lectus rutrum posuere tincidunt, ante urna vulputate nulla, id malesuada risus nulla ut odio.
                    </div>
                </div>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom">{L_239}&nbsp;&gt;&gt;&nbsp;{L_30_0176}</h4>
                <p><b>{L_113}: </b> {ID}</p>
                <p><b>{L_197}: </b> {TITLE}</p>
                <p><b>{L_125}: </b> {S_NICK} ({S_NAME})</p>
                <p><b>{L_127}: </b> {MIN_BID}</p>
                <p><b>{L_111}: </b> {STARTS}</p>
                <p><b>{L_30_0177}: </b> {ENDS}</p>
                <p><b>{L_257}: </b> {AUCTION_TYPE}</p>
                <h4 class="rounded-top rounded-bottom" style="width: 98%;">{L_453}</h4>
<!-- IF B_WINNERS -->
                <table width="98%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <th><b>{L_176}</b></td>
                    <th><b>{L_30_0179}</b></td>
                    <th><b>{L_284}</b></td>
                </tr>
    <!-- BEGIN winners -->
                <tr>
                    <td>{winners.W_NICK} ({winners.W_NAME})</td>
                    <td>{winners.BID}</td>
                    <td align="center">{winners.QTY}</td>
                </tr>
    <!-- END winners -->
                </table>
<!-- ELSE -->
                {L_30_0178}
<!-- ENDIF -->
                <h4 class="rounded-top rounded-bottom" style="width: 98%;">{L_30_0180}</h4>
<!-- IF B_BIDS -->
                <table width="98%" cellpadding="0" cellspacing="0">
                <tr>
                    <th><b>{L_176}</b></td>
                    <th><b>{L_30_0179}</b></td>
                    <th><b>{L_284}</b></td>
                </tr>
    <!-- BEGIN bids -->
                <tr>
                    <td>{bids.W_NICK} ({bids.W_NAME})</td>
                    <td>{bids.BID}</td>
                    <td align="center">{bids.QTY}</td>
                </tr>
    <!-- END bids -->
                </table>
<!-- ELSE -->
                {L_30_0178}
<!-- ENDIF -->
            </div>
        </div>
<!-- INCLUDE footer.tpl -->