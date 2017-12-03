<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (isset($_SESSION['csrftoken'])) {
    # Token should exist as soon as a user is logged in
    if (1 < count($_POST)) {        # More than 2 parameters in a POST (csrftoken + 1 more) => check
        $valid_req = ($_POST['csrftoken'] == $_SESSION['csrftoken']);
    } else {
        $valid_req = true;
    }        # Neither GET nor POST params exist => permit
    if (!$valid_req) {
        global $MSG, $ERR_077;

        $_SESSION['msg_title'] = $MSG['936'];
        $_SESSION['msg_body'] = $ERR_077;
        header('location: ../message.php');
        exit; // kill the page
    }
} else {
    header("location: login.php");
    exit;
}

if (checklogin()) {
    header("location: login.php");
    exit;
} else {
    // update admin notes
    if (isset($_POST['anotes'])) {
        $query = "UPDATE " . $DBPrefix . "adminusers SET notes = :admin_note WHERE id = :admin_id";
        $params = array();
        $params[] = array(':admin_note', $_POST['anotes'], 'str');
        $params[] = array(':admin_id', $_SESSION['WEBID_ADMIN_IN'], 'int');
        $db->query($query, $params);
    }

    $mth = 'MON_0' . date('m', $_SESSION['WEBID_ADMIN_TIME']);
    $return = date('d', $_SESSION['WEBID_ADMIN_TIME']) . ' ' . $MSG[$mth] . ', ' . date('Y - H:i', $_SESSION['WEBID_ADMIN_TIME']);
    $template->assign_vars(array(
            'DOCDIR' => $DOCDIR,
            'THEME' => $system->SETTINGS['theme'],
            'SITEURL' => $system->SETTINGS['siteurl'],
            'CHARSET' => $CHARSET,
            'ADMIN_USER' => $_SESSION['WEBID_ADMIN_USER'],
            'ADMIN_ID' => $_SESSION['WEBID_ADMIN_IN'],
            'CURRENT_PAGE' => $current_page,
            'LAST_LOGIN' => $return,
            'ADMIN_NOTES' => getAdminNotes(),
            'L_COPY_YEAR' => date("Y")
            ));
    foreach ($LANGUAGES as $lang => $value) {
        $template->assign_block_vars('langs', array(
                'LANG' => $value,
                'B_DEFAULT' => ($lang == $language)
                ));
    }
}
