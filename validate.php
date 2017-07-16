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

include 'common.php';

if (isset($_GET['fail']) || isset($_GET['completed'])) {
    $template->assign_vars(array(
            'TITLE_MESSAGE' => (isset($_GET['fail'])) ? $MSG['425'] :  $MSG['423'],
            'BODY_MESSAGE' => (isset($_GET['fail'])) ? $MSG['426'] :  $MSG['424']
            ));
    include 'header.php';
    $template->set_filenames(array(
            'body' => 'message.tpl'
            ));
    $template->display('body');
    include 'footer.php';
    exit;
}

$fees = new fees;
$fees->data = $_POST;

if (isset($_GET['paypal'])) {
    $fees->paypal_validate();
}
if (isset($_GET['authnet'])) {
    $fees->authnet_validate();
}
if (isset($_GET['worldpay'])) {
    $fees->worldpay_validate();
}
if (isset($_GET['skrill'])) {
    $fees->skrill_validate();
}
if (isset($_GET['toocheckout'])) {
    $fees->toocheckout_validate();
}
