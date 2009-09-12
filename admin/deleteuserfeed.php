<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
$id = $_GET['id'];
if ($id > 0){
	$sql = "DELETE FROM " . $DBPrefix . "feedbacks WHERE id='".$id."'";
	$res = mysql_query($sql);
	if (!$res){
?>
	<table width="100%" bgcolor="#FFFFFF" border=0 cellpadding="0" cellspacing="0">
	<tr>
	<td>
	<BR>
	<CENTER>
	<BR>
	<?php print $tlt_font; ?>
	<B><?php print $MSG['207']; ?></B>
	</FONT>
	<BR>
	
	<?php
		echo $err_font.$ERR_066;
	?>
	</FONT>
<?php
	} else {
		#// Update user's record
		$query = "SELECT SUM(rate) as FSUM,count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks
				  WHERE rated_user_id='$id'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$SUM = mysql_result($res,0,"FSUM");
		$NUM = mysql_result($res,0,"FNUM");
		
		@mysql_query("UPDATE " . $DBPrefix . "users SET rate_sum=$SUM, rate_num=$NUM,reg_date=reg_date WHERE id='$id'");
	}			
}
?>
<script type="text/javascript">
window.location="userfeedback.php?id=<?php echo $id; ?>";
</script>
