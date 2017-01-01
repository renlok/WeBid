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
$current_page = 'banners';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';

$banner = (isset($_GET['banner']) && !empty($_GET['banner'])) ? $_GET['banner'] : '';
$banner = (isset($_POST['banner']) && !empty($_POST['banner'])) ? $_POST['banner'] : $banner;
$id = intval($_REQUEST['id']);

if (isset($_POST['action']) && $_POST['action'] == 'insert') {
    // Data integrity
    if (empty($_FILES['bannerfile']) || empty($_POST['url'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
    } else {
        if ($_FILES['bannerfile']['tmp_name'] != '' && $_FILES['bannerfile']['tmp_name'] != 'none') {
            // Handle upload
            if (!file_exists(UPLOAD_PATH . 'banners')) {
                umask();
                mkdir(UPLOAD_PATH . 'banners', 0777);
            }
            if (!file_exists(UPLOAD_PATH . 'banners/' . $id)) {
                umask();
                mkdir(UPLOAD_PATH . 'banners/' . $id, 0777);
            }

            $TARGET = UPLOAD_PATH . 'banners/' . $id . '/' . $_FILES['bannerfile']['name'];
            list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
            $filename = basename($_FILES['bannerfile']['name']);
            $file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $file_types = array('gif', 'jpg', 'jpeg', 'png', 'swf');
            if (!in_array($file_ext, $file_types)) {
                $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_wrong_file_type']));
            } else {
                $imageType = image_type_to_mime_type($imageType);
                switch ($imageType) {
                    case 'image/gif':
                        $FILETYPE = 'gif';
                        break;
                    case 'image/pjpeg':
                    case 'image/jpeg':
                    case 'image/jpg':
                        $FILETYPE = 'jpg';
                        break;
                    case 'image/png':
                    case 'image/x-png':
                        $FILETYPE = 'png';
                        break;
                    case 'application/x-shockwave-flash':
                        $FILETYPE = 'swf';
                        break;
                }
                if (!empty($_FILES['bannerfile']['tmp_name']) && $_FILES['bannerfile']['tmp_name'] != 'none') {
                    move_uploaded_file($_FILES['bannerfile']['tmp_name'], $TARGET);
                    chmod($TARGET, 0666);
                }
            }
        }

        // Update database
        $extrasql = '';
        $params = array();
        if ($_FILES['bannerfile']['tmp_name'] != '' && $_FILES['bannerfile']['tmp_name'] != 'none') {
            $extrasql = "name = :bannerfile,
                        type = :type,
                        width = :imagewidth,
                        height = :imageheight,";
            $params[] = array(':bannerfile', $_FILES['bannerfile']['name'], 'str');
            $params[] = array(':type', $FILETYPE, 'str');
            $params[] = array(':imagewidth', $imagewidth, 'int');
            $params[] = array(':imageheight', $imageheight, 'int');
        }

        $query = "UPDATE " . $DBPrefix . "banners
                  SET " . $extrasql . "
                  url = :url,
                  sponsortext = :sponsortext,
                  alt = :alt,
                  purchased = :purchased
                  WHERE id = :id";
        $params[] = array(':url', $_POST['url'], 'str');
        $params[] = array(':sponsortext', $_POST['sponsortext'], 'str');
        $params[] = array(':alt', $_POST['alt'], 'str');
        $params[] = array(':purchased', $_POST['purchased'], 'int');
        $params[] = array(':id', $banner, 'int');
        $db->query($query, $params);

        $query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = :banner_id";
        $params = array();
        $params[] = array(':banner_id', $banner, 'int');
        $db->query($query, $params);

        $query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner_id";
        $params = array();
        $params[] = array(':banner_id', $banner, 'int');
        $db->query($query, $params);

        // Handle filters
        if (isset($_POST['category']) && is_array($_POST['category'])) {
            foreach ($_POST['category'] as $k => $v) {
                $query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES (:banner_id, :cat)";
                $params = array();
                $params[] = array(':banner_id', $banner, 'int');
                $params[] = array(':cat', $v, 'int');
                $db->query($query, $params);
            }
        }
        if (!empty($_POST['keywords'])) {
            $KEYWORDS = explode("\n", $_POST['keywords']);
            foreach ($KEYWORDS as $k => $v) {
                if (!empty($v)) {
                    $query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES (:banner_id, :keyword)";
                    $params = array();
                    $params[] = array(':banner_id', $banner, 'int');
                    $params[] = array(':keyword', $system->cleanvars(trim($v)), 'str');
                    $db->query($query, $params);
                }
            }
        }
    }
}

// Retrieve user's banner
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);

while ($row = $db->fetch()) {
    $BANNER = $row;
    $template->assign_block_vars('banners', array(
            'ID' => $row['id'],
            'TYPE' => $row['type'],
            'NAME' => $row['name'],
            'BANNER' => UPLOAD_FOLDER . 'banners/' . $id . '/' . $row['name'],
            'WIDTH' => $row['width'],
            'HEIGHT' => $row['height'],
            'URL' => $row['url'],
            'ALT' => $row['alt'],
            'SPONSERTEXT' => $row['sponsortext'],
            'VIEWS' => $row['views'],
            'CLICKS' => $row['clicks'],
            'PURCHASED' => $row['purchased']
            ));
}

// Retrieve user's information
$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $id, 'int');
$db->query($query, $params);
if ($db->numrows() > 0) {
    $USER = $db->result();
}

// Retrieve filters
$CATEGORIES = array();
$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE banner = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);

if ($db->numrows() > 0) {
    while ($row = $db->fetch()) {
        $CATEGORIES[] = $row['category'];
    }
}
$KEYWORDS = '';
$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);
if ($db->numrows() > 0) {
    while ($row = $db->fetch()) {
        $KEYWORDS .= $row['keyword'] . "\n";
    }
}

// -------------------------------------- category
if (isset($category_plain) && count($category_plain) > 0) {
    foreach ($category_plain as $cat_id => $cat_name) {
        $template->assign_block_vars('categories', array(
            'CAT_ID' => $cat_id,
            'CAT_NAME' => $cat_name,
            'B_SELECTED' => (in_array($cat_id, $CATEGORIES))
            ));
    }
}

$template->assign_vars(array(
        'ID' => $id,
        'NAME' => $USER['name'],
        'COMPANY' => $USER['company'],
        'EMAIL' => $USER['email'],
        // form values
        'BANNERID' => $banner,
        'URL' => $BANNER['url'],
        'SPONSORTEXT' => $BANNER['sponsortext'],
        'ALT' => $BANNER['alt'],
        'PURCHASED' => $BANNER['purchased'],
        'KEYWORDS' => $KEYWORDS,
        'NOTEDIT' => false
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'userbanners.tpl'
        ));
$template->display('body');
include 'footer.php';
