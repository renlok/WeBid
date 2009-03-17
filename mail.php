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
// If user is not logged in redirect to login page
if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("Location: user_login.php");
    exit;
}

$x = (isset($_GET['x']))? $_GET['x'] : '';
$u = (isset($_GET['u']))? (int)$_GET['u'] : 0;
$replymessage = (isset($_GET['message']))? $_GET['message'] : '';
$order = (isset($_GET['order']))? $_GET['order'] : '';
$action = (isset($_GET['action']))? $_GET['action'] : '';
$messageid = (isset($_GET['id']))? $_GET['id'] : '';
$delete = (isset($_POST['delete']))? $_POST['delete'] : null;
$userid = $_SESSION['WEBID_LOGGED_IN'];
$TPL_error = '';

if (isset($_POST['sendto']) && isset($_POST['subject']) && isset($_POST['message'])) {
    // get message info + set cookies for if an error occours
    $sendto = $system->cleanvars($_POST['sendto']);
    $_SESSION['sendto'] = $sendto;
    $subject = $system->cleanvars($_POST['subject']);
    $_SESSION['subject'] = $subject;
    $message = $system->cleanvars($_POST['message']);
    $_SESSION['messagecont'] = $message;
    // check user exists
    $sql = "SELECT * FROM " . $DBPrefix . "users WHERE nick='$sendto'";
    $run = mysql_query($sql);
    $system->check_mysql($run, $sql, __LINE__, __FILE__);
    $usercheck = mysql_num_rows($run);
    if ($usercheck == '0') {
        $_SESSION['message'] = $ERR_609;
        header('location: mail.php?x=1');
        exit;
    }
    $userarray = mysql_fetch_array($run);
    $sendtoid = $userarray['id'];
    // check use mailbox insnt full
    $sql = mysql_query("SELECT * FROM " . $DBPrefix . "messages WHERE sentto='$sendtoid'");
    $mailboxsize = mysql_num_rows($sql);
    if ($mailboxsize >= '30') {
        $_SESSION['message'] = $sendto . ' currently has a full inbox at the moment please try again later';
        header('location: mail.php');
        exit;
    }
    // send message
    $nowmessage = nl2br($message);
    $userid = $_SESSION['WEBID_LOGGED_IN'];
    $sql = "INSERT INTO " . $DBPrefix . "messages( `sentto` , `from` , `when` , `message` , `subject` )  VALUES ('$sendtoid', '$userid', '" . time() . "', '$nowmessage', '$subject')";
    $run = mysql_query($sql);
    $system->check_mysql($run, $sql, __LINE__, __FILE__);

    if (isset($_SESSION['reply'])) {
        $reply = $_SESSION['reply'];
        $sql = "UPDATE " . $DBPrefix . "messages SET replied = 1 WHERE id = '$reply'";
        $run = mysql_query($sql);
        $system->check_mysql($run, $sql, __LINE__, __FILE__);
        unset($_SESSION['reply']);
    }
    // delete session of sent message
    unset($_SESSION['messagecont']);
    unset($_SESSION['subject']);
    unset($_SESSION['sendto']);
}

if (isset($_REQUEST['deleteid']) && is_array($_REQUEST['deleteid'])) {
    $temparr = $_REQUEST['deleteid'];
    $message_id = 0;
    for($i = 0; $i < count($temparr); $i++) {
        $message_id .= ',' . intval($temparr[$i]);
    }
    $sql = "DELETE FROM " . $DBPrefix . "messages WHERE id IN ($message_id)";
    $run = mysql_query($sql);
    $system->check_mysql($run, $sql, __LINE__, __FILE__);
    $TPL_error = "Messages removed";
}
// if sending a message
if ($x == 1) {
    if (!empty($_SESSION['msg' . $replymessage])) {
        $messagecont = str_replace(array('<br />', '<br>'), '', $_SESSION['msg' . $replymessage]); //clean message
    }
    $subject = $_SESSION['subject' . $replymessage];
    $sendto = $_SESSION['sendto' . $replymessage];
    // if sent from userpage
    if ($u > 0) {
        $sql = "SELECT * FROM " . $DBPrefix . "users WHERE id='$u'";
        $run = mysql_query($sql);
        $system->check_mysql($run, $sql, __LINE__, __FILE__);
        $array = mysql_fetch_array($run);
        $sendto = $array['nick'];
    }
    // get variables
    $TPL_sendto = $sendto;
    $TPL_subject = $subject;
    $TPL_message_cont = $messagecont;
}
// table headers
$sentfrom = '<a href="mail.php?order=3">' . $MSG['240'] . '</a>';
$whensent = '<a href="mail.php?order=1">' . $MSG['242'] . '</a>';
$title = '<a href="mail.php?order=5">' . $MSG['519'] . '</a>';
// order messages
if ($order == '1') {
    $orderby = "ORDER BY `id` DESC";
    $whensent = '<a href="mail.php?order=2">' . $MSG['242'] . ' <img src="images/arrow_down.gif"></a>';
}else if ($order == '2') {
    $orderby = "ORDER BY `id` ASC";
    $whensent = '<a href="mail.php?order=1">' . $MSG['242'] . ' <img src="images/arrow_up.gif"></a>';
}else if ($order == '3') {
    $orderby = "ORDER BY `from` DESC";
    $sentfrom = '<a href="mail.php?order=4">' . $MSG['240'] . ' <img src="images/arrow_down.gif"></a>';
}else if ($order == '4') {
    $orderby = "ORDER BY `from` ASC";
    $sentfrom = '<a href="mail.php?order=3">' . $MSG['240'] . ' <img src="images/arrow_up.gif"></a>';
}else if ($order == '5') {
    $orderby = "ORDER BY `subject` DESC";
    $title = '<a href="mail.php?order=6">' . $MSG['519'] . ' <img src="images/arrow_down.gif"></a>';
}else if ($order == '6') {
    $orderby = "ORDER BY `subject` ASC";
    $title = '<a href="mail.php?order=5">' . $MSG['519'] . ' <img src="images/arrow_up.gif"></a>';
}else {
    $orderby = "ORDER BY `id` DESC";
}

$sql = "SELECT m.*, u.nick FROM " . $DBPrefix . "messages m
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = m.from)
		WHERE sentto = '$userid' $orderby";
// get users messages
$run = mysql_query($sql);
$system->check_mysql($run, $sql, __LINE__, __FILE__);
$messages = mysql_num_rows($run);
// display number of messages
$messagespaceused = ($messages * 4) + 1;
$messagespaceleft = (30 - $messages) * 4;
$messagesleft = 30 - $messages;

$TPL_error = (isset($_SESSION['message'])) ? $_SESSION['message'] : $TPL_error;
unset($_SESSION['message']);

$template->assign_vars(array(
        'ERROR' => $TPL_error,
        'WHENSENT' => $whensent,
        'TITLE' => $title,
        'SENTFROM' => $sentfrom,
        'MSGCOUNT' => $messages,
        'REPLY_X' => $x,
        'REPLY_TO' => (isset($TPL_sendto)) ? $TPL_sendto : '',
        'REPLY_SUBJECT' => (isset($TPL_subject)) ? $TPL_subject : '',
        'REPLY_MSG' => (isset($TPL_message_cont)) ? $TPL_message_cont : ''
        ));

while ($array = mysql_fetch_array($run)) {
    $template->assign_block_vars('msgs', array(
            'SENT' => gmdate('M d, Y H:ia', $array['when'] + $system->tdiff),
            'ID' => $array['id'],
            'SENDER' => ($array['from'] == 0) ? 'Admin' : '<a href="profile.php?user_id=' . $array['from'] . '">' . $array['nick'] . '</a>',
            'SUBJECT' => ($array['read'] == 0) ? '<b>' . $array['subject'] . '</b>' : $array['subject']
            ));
}

include "header.php";
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'mail.html'
        ));
$template->display('body');
include "footer.php";

?>