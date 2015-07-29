<script type="text/javascript">
function SubmitFriendForm(){
	document.friend.submit();
}
function ResetFriendForm(){
	document.friend.reset();
}
</script>
<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_645}
		</div>
		<div class="titTable3">
			<a href="item.php?id={AUCT_ID}">{L_138}</a>
		</div>
<!-- IF MESSAGE ne '' -->
		<div align="center" class="padding">{MESSAGE}</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<TABLE WIDTH="100%" >
		<TR>
		<TD>
		<form name="sendemail" action="send_email.php" method="post">
		<TABLE WIDTH="90%" border="0" cellpadding="4" cellspacing="0" class="content">
		<TR> 
		<TD width="40%" ALIGN=right> <B>{L_125}</B> 
		</TD>
		<TD width="60%"><INPUT TYPE="HIDDEN" NAME="seller_nick" SIZE="25" VALUE="{SELLER_NICK}"> 
		{SELLER_NICK}</TD>
		</TR>
	<!-- IF B_LOGGED_IN eq false -->
		<TR> 
		<TD ALIGN=right> <B>{L_006}</B> 
		</TD>
		<TD><INPUT TYPE="text" NAME="sender_email" SIZE="25" VALUE=""></TD>
		</TR>
	<!-- ENDIF -->
		<TR> 
		<TD ALIGN=right> <B>{L_017}</B> 
		</TD>
		<TD><INPUT TYPE="HIDDEN" NAME="item_title" SIZE="25" VALUE="{ITEM_TITLE}"> 
		{ITEM_TITLE}</TD>
		</TR>
		<!-- your email -->
		<TR> 
		<TD ALIGN=right> <B>{L_002}</B> 
		</TD>
		<TD ><INPUT TYPE="TEXT" NAME="sender_name" SIZE="25" VALUE="{YOURUSERNAME}"> 
		</TD>
		</TR>
		<!-- comment -->
		<TR> 
		<TD ALIGN=right VALIGN=TOP> <B>{L_650}</B> 
		</TD>
		<TD ><TEXTAREA NAME="sender_question" COLS="35" ROWS="6">{SELLER_QUESTION}</TEXTAREA> 
		<BR> <BR> <INPUT TYPE="hidden" NAME="seller_email" VALUE="{SELLER_EMAIL}"> 
        <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<INPUT TYPE="hidden" NAME="id" VALUE="{AUCT_ID}"> 
		<INPUT TYPE="hidden" NAME="action" VALUE="{L_106}"> <INPUT TYPE=submit NAME="" VALUE="{L_5201}"  class=button /> 
	<!-- IF B_LOGGED_IN -->
		<INPUT TYPE="hidden" NAME="sender_email" SIZE="25" VALUE="{EMAIL}">
	<!-- ENDIF -->
		<INPUT TYPE=reset NAME="" VALUE="{L_035}" class=button> <p> </TD>
		</TR>
		</TABLE>
		</FORM></TD>
		</TR>
		</TABLE>
<!-- ENDIF -->
	</div>
</div>
