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

include "includes/config.inc.php";
// // If user is not logged in redirect to login page
if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("Location: user_login.php");
    exit;
}

$sql = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $_SESSION['WEBID_LOGGED_IN'];
$res = mysql_query($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
$uid = mysql_fetch_assoc($res);
$userid = $uid['id'];
$messageid = $_GET['id'];
// check message is to user
$sql = "SELECT * FROM " . $DBPrefix . "messages WHERE sentto = '$userid' AND id = '$messageid'";
$res = mysql_query($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
$check = mysql_num_rows($res);
if ($check == 0) {
    $_SESSION['message'] = "This message doesn't exist";
    header('location: mail.php');
}
// get message details
$sql = "SELECT * FROM `" . $DBPrefix . "messages` WHERE `id`='$messageid'";
$res = mysql_query($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
$array = mysql_fetch_array($res);
$sent = gmdate('M d, Y H:ia', $array['when'] + $system->tdiff);
$from = $array['from'];
$subject = $array['subject'];
$replied = $array['replied'];
$message = $array['message'];
$hash = md5(rand(1, 9999));
$array['message'] = str_replace("<br>", "", $array['message']);
$_SESSION['msg' . $hash] = "\n\n-+-+-+-+-+-+-+-+-+\n\n" . $array['message'];
// get username
$usql = "SELECT * FROM `" . $DBPrefix . "users` WHERE `id`='$from'";
$urun = mysql_query($usql);
$system->check_mysql($urun, $sql, __LINE__, __FILE__);
$uarray = mysql_fetch_array($urun);
$sendusername = $uarray['nick'];

$senderusername = '<a href="profile.php?user_id=1&auction_id=' . $from . '">' . $sendusername . '</a>';
// if admin message
if ($from == '0') {
    $senderusername = "Admin";
}
// update message
$sql = "UPDATE `" . $DBPrefix . "messages` SET `read` = 1 WHERE `id` = '$messageid'";
$run = mysql_query($sql);
$system->check_mysql($run, $sql, __LINE__, __FILE__);
// set session for reply
$_SESSION['subject' . $hash] = (substr($subject, 0, 3) == 'Re:') ? $subject : "Re: $subject";
$_SESSION['sendto' . $hash] = $sendusername;
$_SESSION['reply' . $hash] = $messageid;

$template->assign_vars(array(
        'SUBJECT' => $subject,
        'SENDERNAME' => $senderusername,
        'SENT' => $sent,
        'MESSAGE' => $message,
        'ID' => $messageid,
        'HASH' => $hash
        ));

include "header.php";
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'yourmessages.html'
        ));
$template->display('body');
include "footer.php";

?>