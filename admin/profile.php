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

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);
$DISPLAYED_FIELDS = unserialize($system->SETTINGS['displayed_feilds']);

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $MANDATORY_FIELDS = array(
            'birthdate' => $_POST['birthdate'],
            'address' => $_POST['address'],
            'city' => $_POST['city'],
            'prov' => $_POST['prov'],
            'country' => $_POST['country'],
            'zip' => $_POST['zip'],
            'tel' => $_POST['tel']
            );

    $DISPLAYED_FIELDS = array(
            'birthdate_regshow' => $_POST['birthdate_regshow'],
            'address_regshow' => $_POST['address_regshow'],
            'city_regshow' => $_POST['city_regshow'],
            'prov_regshow' => $_POST['prov_regshow'],
            'country_regshow' => $_POST['country_regshow'],
            'zip_regshow' => $_POST['zip_regshow'],
            'tel_regshow' => $_POST['tel_regshow']
            );

    // common sense check field cant be required if its not visible
    $required = array_keys($MANDATORY_FIELDS);
    $display = array_keys($DISPLAYED_FIELDS);
    for ($i = 0; $i < 7; $i++) {
        if ($MANDATORY_FIELDS[$required[$i]] == 'y' && $DISPLAYED_FIELDS[$display[$i]] == 'n') {
            $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_required_field_cannot_be_hidden']));
        }
    }
    if (!isset($ERR)) {
        $mdata = serialize($MANDATORY_FIELDS);
        $sdata = serialize($DISPLAYED_FIELDS);
        $system->writesetting("mandatory_fields", $mdata, "str");
        $system->writesetting("displayed_feilds", $sdata, "str");

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['registration_fields_updated']));
    }
}

$template->assign_vars(array(
        'REQUIRED_0' => ($MANDATORY_FIELDS['birthdate'] == 'y'),
        'REQUIRED_1' => ($MANDATORY_FIELDS['address'] == 'y'),
        'REQUIRED_2' => ($MANDATORY_FIELDS['city'] == 'y'),
        'REQUIRED_3' => ($MANDATORY_FIELDS['prov'] == 'y'),
        'REQUIRED_4' => ($MANDATORY_FIELDS['country'] == 'y'),
        'REQUIRED_5' => ($MANDATORY_FIELDS['zip'] == 'y'),
        'REQUIRED_6' => ($MANDATORY_FIELDS['tel'] == 'y'),
        'DISPLAYED_0' => ($DISPLAYED_FIELDS['birthdate_regshow'] == 'y'),
        'DISPLAYED_1' => ($DISPLAYED_FIELDS['address_regshow'] == 'y'),
        'DISPLAYED_2' => ($DISPLAYED_FIELDS['city_regshow'] == 'y'),
        'DISPLAYED_3' => ($DISPLAYED_FIELDS['prov_regshow'] == 'y'),
        'DISPLAYED_4' => ($DISPLAYED_FIELDS['country_regshow'] == 'y'),
        'DISPLAYED_5' => ($DISPLAYED_FIELDS['zip_regshow'] == 'y'),
        'DISPLAYED_6' => ($DISPLAYED_FIELDS['tel_regshow'] == 'y')
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'profile.tpl'
        ));
$template->display('body');
include 'footer.php';
