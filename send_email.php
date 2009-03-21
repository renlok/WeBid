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

include 'includes/config.inc.php';

if (($system->SETTINGS['contactseller'] == 'logged' && !isset($_SESSION['WEBID_LOGGED_IN'])) || $system->SETTINGS['contactseller'] == 'never') {
    if (isset($_SESSION['REDIRECT_AFTER_LOGIN'])) {
        header('location: ' . $_SESSION['REDIRECT_AFTER_LOGIN']);
    } else {
        header('location: index.php');
    }
}

if (!isset($_POST['auction_id']) && !isset($_GET['auction_id'])) {
    $auction_id = $_SESSION['CURRENT_ITEM'];
} else {
    $auction_id = intval($_GET['auction_id']);
}
$_SESSION['CURRENT_ITEM'] = $auction_id;
// --Get item description
$query = "SELECT a.user, a.title, u.nick, u.email FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		WHERE a.id=" . intval($auction_id);
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);

if (mysql_num_rows($result) == 0) {
    $TPL_error_text = $ERR_605;
} else {
    $seller_id = stripslashes(mysql_result($result, 0, 'user'));
    $item_title = stripslashes(mysql_result($result, 0, 'title'));
    $seller_nick = stripslashes(mysql_result($result, 0, 'nick'));
    $seller_email = stripslashes(mysql_result($result, 0, 'email'));
}

$TPL_auction_id = $auction_id;
$userid = $_SESSION['WEBID_LOGGED_IN'];
$TPL_seller_nick_value = $seller_nick;
$TPL_seller_email_value = $seller_email;
$TPL_sender_name_value = $_POST['sender_name'];
$TPL_sender_email_value = $_POST['sender_email'];
$TPL_item_title = $item_title;
$TPL_sender_question = $_POST['sender_question'];
$cleaned_question = strip_tags($system->filter($_POST['sender_question']));
if ($system->SETTINGS['wordsfilter'] == 'y') {
    $cleaned_question = $system->filter($cleaned_question);
}
if (isset($_POST['action']) || !empty($_POST['action'])) {
    // --Check errors
    if (isset($_POST['action']) && (!isset($_POST['sender_name']) || !isset($_POST['sender_email']) || empty($seller_nick) || empty($seller_email))) {
        $TPL_error_text = $ERR_032;
    }

    if (empty($cleaned_question)) {
        $TPL_error_text = $ERR_031;
    }

    if (isset($_POST['action']) && (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['sender_email']) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $seller_email))) {
        $TPL_error_text = $ERR_008;
    }
    if (empty($TPL_error_text)) {
        $mes = $MSG['337'] . ': <i>' . $seller_nick . '</i><br><br>';
		$emailer = new email_class();
		$emailer->assign_vars(array(
				'SENDER_NAME' => $_POST['sender_name'],
				'SENDER_QUESTION' => $cleaned_question,
				'SENDER_EMAIL' => $_POST['sender_email'],
				'SITENAME' => $system->SETTINGS['sitename'],
				'SITEURL' => $system->SETTINGS['siteurl'],
				'AID' => $auction_id,
				'TITLE' => $item_title,
				'SELLER_NICK' => $seller_nick
				));
		$item_title = $system->uncleanvars($item_title);
		$subject = $MSG['335'] . ' ' . $system->SETTINGS['sitename'] . ' ' . $MSG['336'] . ' ' . $item_title;
		$emailer->email_sender($seller_email, 'mail_send_email.inc.php', $subject);
        $sql = "INSERT INTO " . $DBPrefix . "messages (`sentto`, `from`, `when`, `message`, `subject`) VALUES ('$seller_id', '$userid', '" . time() . "', '" . mysql_escape_string($cleaned_question) . "', '" . $system->cleanvars(sprintf($MSG['651'], $item_title)) . "')";
        $system->check_mysql(mysql_query($sql), $sql, __LINE__, __FILE__);
    }
}

$template->assign_vars(array(
        'MESSAGE' => (isset($mes)) ? $mes : '',
        'ERROR' => (isset($TPL_error_text)) ? $TPL_error_text : '',
        'AUCT_ID' => $TPL_auction_id,
        'SELLER_NICK' => $TPL_seller_nick_value,
        'SELLER_EMAIL' => $TPL_seller_email_value,
        'SELLER_QUESTION' => $TPL_sender_question,
        'ITEM_TITLE' => $TPL_item_title,
        'EMAIL' => (isset($_SESSION['WEBID_LOGGED_EMAIL'])) ? $_SESSION['WEBID_LOGGED_EMAIL'] : ''
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'send_email.html'
        ));
$template->display('body');
include "footer.php";

?>