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

require "includes/config.inc.php";
// -- Get auction_id from sessions variables
if (!isset($_POST['auction_id']) && !isset($_GET['auction_id'])) {
    $auction_id = $_SESSION['CURRENT_ITEM'];
} else {
    $auction_id = $_SESSION['CURRENT_ITEM'] = intval($_GET['auction_id']);
}

if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("location: user_login.php");
    exit;
}

$query = "SELECT id, email, nick FROM " . $DBPrefix . "users WHERE id = " . intval($_REQUEST['user_id']);
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$user_id = mysql_result($result, 0, "id");
$email = mysql_result($result, 0, "email");
$username = mysql_result($result, 0, "nick");

$sent = false;
if (isset($_POST['action']) && $_POST['action'] == "proceed") {
    if (empty($_POST['TPL_sender_name']) || empty($_POST['TPL_sender_mail']) || empty($_POST['TPL_text'])) {
        $TPL_error_text = $ERR_031;
    } elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['TPL_sender_mail']) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['TPL_sender_mail'])) {
        $TPL_error_text = $ERR_008;
    } else {
		$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = " . $auction_id;
		$result = mysql_query($query);
		$system->check_mysql($result, $query, __LINE__, __FILE__);
		$item_title = mysql_result($result, 0, "title");
		$item_title = $system->uncleanvars($item_title);
        // -- Send e-mail message
        $subject = $MSG['335'] . ' ' . $system->SETTINGS['sitename'] . ' ' . $MSG['336'] . ' ' . $item_title;
        $message = $MSG['084'] . ' ' . $MSG['240'] . ': ' . $_POST['TPL_sender_mail'] . "\n\n" . $_POST['TPL_text'];
		$emailer = new email_class();
		$emailer->email_uid = $user_id;
		$emailer->email_basic($subject, $email, nl2br($message), $_POST['TPL_sender_name']); //sent the email :D
        // send a copy to their mesasge box
        $nowmessage = nl2br($system->cleanvars($message));
        $sql = "INSERT INTO " . $DBPrefix . "messages (`sentto`, `from`, `when`, `message`, `subject`)
				VALUES ($user_id, " . $_SESSION['WEBID_LOGGED_IN'] . ", '" . time() . "', '$nowmessage', '" . $system->cleanvars(sprintf($MSG['651'], $item_title)) . "')";
        $system->check_mysql(mysql_query($sql), $sql, __LINE__, __FILE__);
        $sent = true;
    }
}

$template->assign_vars(array(
        'B_SENT' => $sent,
        'ERROR' => (isset($TPL_error_text)) ? $TPL_error_text : '',
        'USERID' => $user_id,
        'USERNAME' => $username,
        'AUCTION_ID' => $auction_id,
        'MSG_YNAME' => (isset($_POST['TPL_sender_name'])) ? $_POST['TPL_sender_name'] : '',
        'MSG_YEMAIL' => (isset($_POST['TPL_sender_mail'])) ? $_POST['TPL_sender_mail'] : '',
        'MSG_TEXT' => (isset($_POST['TPL_text'])) ? $_POST['TPL_text'] : ''
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'email_request_form.html'
        ));
$template->display('body');
include "footer.php";

?>