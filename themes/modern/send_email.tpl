<script type="text/javascript">
function SubmitFriendForm(){
	document.friend.submit();
}
function ResetFriendForm(){
	document.friend.reset();
}
</script>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
		<div class="grid-margin-btm-md">
			<a class="btn btn-default btn-xs" href="item.php?id={AUCT_ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> {L_138}</a>
		</div>
<!-- IF MESSAGE ne '' -->
		<div class="alert alert-success" role="alert">{MESSAGE}</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
	<!-- ENDIF -->
                <div class="well">
                   <legend>
			{L_645}
		</legend>
		    <form name="sendemail" action="send_email.php" method="post">
		         <div class="form-group">
                            <label>{L_125}</label> 
		             <INPUT TYPE="HIDDEN" NAME="seller_nick" class="form-control" VALUE="{SELLER_NICK}"> 
		             {SELLER_NICK}
		         </div>
	<!-- IF B_LOGGED_IN eq false -->
		         <div class="form-group">
		             <label>{L_006}</label> 
		             <INPUT TYPE="text" NAME="sender_email" class="form-control" VALUE=""></TD>
		         </div>
	<!-- ENDIF -->
		         <div class="form-group"> 
		             <label>{L_017}</label> 
		             <INPUT TYPE="HIDDEN" NAME="item_title" class="form-control" VALUE="{ITEM_TITLE}"> 
		             {ITEM_TITLE}
		         </div>
		<!-- your email -->
		         <div class="form-group"> 
		             <label>{L_002}</label> 
		             <INPUT TYPE="TEXT" NAME="sender_name" class="form-control" VALUE="{YOURUSERNAME}"> 
		         </div>
		<!-- comment -->
		         <div class="form-group"> 
		             <label>{L_650}</label> 
		             <TEXTAREA NAME="sender_question" class="form-control" ROWS="6">{SELLER_QUESTION}</TEXTAREA>
                         </div> 
		         <br> 
                             <INPUT TYPE="hidden" NAME="seller_email" VALUE="{SELLER_EMAIL}"> 
                             <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		             <INPUT TYPE="hidden" NAME="id" VALUE="{AUCT_ID}"> 
		             <INPUT TYPE="hidden" NAME="action" VALUE="{L_106}"> 
                             <INPUT TYPE=submit NAME="" VALUE="{L_5201}"  class="btn btn-primary"> 
	<!-- IF B_LOGGED_IN -->
		<INPUT TYPE="hidden" NAME="sender_email" SIZE="25" VALUE="{EMAIL}">
	<!-- ENDIF -->
		<INPUT TYPE=reset NAME="" VALUE="{L_035}" class="btn btn-default"> 
		
		
		    </form>
                </div>
<!-- ENDIF -->
	</div>
</div>
