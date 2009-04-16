<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
if ($_POST && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))) {
	$sql="UPDATE " . $DBPrefix . "feedbacks SET 
		  rate='".$_POST['aTPL_rate']."', 
		  feedback='".$_POST['TPL_feedback']."',
		  feedbackdate=feedbackdate
		  WHERE id=".$_GET['id'];
	$res=mysql_query($sql);
	$system->check_mysql($res, $sql, __LINE__, __FILE__);
	if ($res){
		// Update user's record
		$query = "SELECT SUM(rate) as FSUM,count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks
				  WHERE rated_user_id='".$_POST['user']."'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$SUM = mysql_result($res,0,"FSUM");
		$NUM = mysql_result($res,0,"FNUM");
		
		@mysql_query("UPDATE " . $DBPrefix . "users SET rate_sum=$SUM, rate_num=$NUM,reg_date=reg_date WHERE id='".$_POST['user']."'");
		$TPL_errmsg=$MSG['183'];
	}
	else{
		$TPL_errmsg=$ERR_065;
	}
}

$sql="SELECT * FROM " . $DBPrefix . "feedbacks WHERE id='".$_GET['id']."' ORDER by feedbackdate DESC";
$res=mysql_query($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
$i=0;
while ($arrfeed=mysql_fetch_array($res)) {
	$rater=$arrfeed[rater_user_nick];
	$feedback=substr($arrfeed[feedback], 0, 50);
	$feed_text=strip_tags($arrfeed[feedback]);
	$rate=$arrfeed[rate];
	$user_id=$arrfeed[rated_user_id];
}
$sel="selected";
for ($i = 1 ; $i <= 5 ; $i++){
	if ($i == $rate){
		$selected=$sel.$i;
		$$selected="checked";
	}
}
$sql="SELECT nick FROM " . $DBPrefix . "users WHERE id='$user_id'";
$res=mysql_query($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
while ($usr=mysql_fetch_array($res)) {
	$rated=$usr['nick'];
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">

function SubmitForm(){
	document.addfeedback.submit();
}

function ResetForm(){
	document.addfeedback.reset();
}
//-->
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5032']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle"> 
<table width="100%" bgcolor="#FFFFFF" border=0 cellpadding="0" cellspacing="0">
  <tr>
	<td class=title align=center><BR>
		<BR>
		<?php print $MSG['222']; ?><BR>
		<?php
			echo $TPL_errmsg;
		?>
		 <BR>
		<form name=addfeedback action="edituserfeed.php?id=<?php echo $_GET['id']; ?>" method="POST">
		  <table width="80%" cellspacing="0" cellpadding="4" border="0">
			<tr>
			  <td COLSPAN=2>
			  <?php echo "<B>$rater ".$MSG['_0167']." $rated</B>"; ?>
			  </td>
			</tr>
			<tr>
			  <td ALIGN=RIGHT> <B><?php print $MSG['503']; ?>:</B> </td>
			  <td><INPUT type=radio name=aTPL_rate value=1 <?php echo $selected1; ?>>
				<IMG SRC="../images/positive.gif" border=0 ALT="Positive">
				<INPUT type=radio name=aTPL_rate value=0 <?php echo $selected2; ?>>
				<IMG SRC="../images/neutral.gif" border=0 ALT="Neutral">
				<INPUT type=radio name=aTPL_rate value=-1 <?php echo $selected3; ?>>
				<IMG SRC="../images/negative.gif" ALT="Negative">
			  </td>
			</tr>
			<tr>
			  <td ALIGN=RIGHT valign="top"> <B>Comment:</B> </td>
			  <td><TEXTAREA name="TPL_feedback" ROWS="10" COLS="50"><?php echo $feed_text; ?></TEXTAREA></td>
			</tr>
			<tr>
			  <td COLSPAN=2 align="center">
				<input type="hidden" name="user" VALUE=<?php echo $user_id; ?>>
				<input type="submit" name="" value="<?php echo $MSG['530']; ?>">
				<input type="reset" name="">
			  </td>
			</tr>
			<tr>
			  <td colspan=2 align="center"> <A HREF="userfeedback.php?id=<?php echo $user_id; ?>">
				<?php echo $MSG['222']; ?>
				</A>  </td>
			</tr>
		  </table>
		  <INPUT type="hidden" name="send" value="1">
		</form>
	</td>
  </tr>
</table>
</body>
</html>