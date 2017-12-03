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
$current_page = 'interface';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$theme_root = MAIN_PATH . 'themes/'; //theres no point repeatedly defining this
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if (is_dir($theme_root . '/' . $_POST['dtheme']) && !empty($_POST['dtheme']) && strstr($_POST['dtheme'], 'admin') === false) {
        // Update database
        $system->writesetting("theme", $_POST['dtheme'], 'str');
        $system->writesetting("admin_theme", $_POST['admin_theme'], 'str');

        $template->set_template();

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['default_theme_updated']));
    } else {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_theme_missing']));
    }
} elseif (isset($_POST['action']) && ($_POST['action'] == 'add' || $_POST['action'] == 'edit')) {
    $filename = ($_POST['action'] == 'add') ? $_POST['new_filename'] : $_POST['filename'];
    $fh = fopen($theme_root . $_POST['theme'] . '/' . $filename, 'w') or die("can't open file " . $theme_root . $_POST['theme'] . '/' . $filename);
    fwrite($fh, $_POST['content']);
    fclose($fh);
}

if (is_dir($theme_root)) {
    if ($dir = opendir($theme_root)) {
        while (($atheme = readdir($dir)) !== false) {
            $theme_path = $theme_root . '/' . $atheme;
            $list_files = (isset($_GET['do']) && isset($_GET['theme']) && $_GET['do'] == 'listfiles' && $_GET['theme'] == $atheme);
            if ($atheme != 'CVS' && is_dir($theme_path) && substr($atheme, 0, 1) != '.') {
                $THEMES[$atheme] = $atheme;
                if (strstr($atheme, 'admin') === false) {
                    $template->assign_block_vars('themes', array(
                            'NAME' => $atheme,
                            'B_CHECKED' => ($system->SETTINGS['theme'] == $atheme),
                            'B_LISTFILES' => $list_files
                        ));
                } else {
                    $template->assign_block_vars('admin_themes', array(
                            'NAME' => $atheme,
                            'B_CHECKED' => ($system->SETTINGS['admin_theme'] == $atheme),
                            'B_LISTFILES' => $list_files
                        ));
                }

                if ($list_files) {
                    // list files
                    $handler = opendir($theme_path);

                    // keep going until all files in directory have been read
                    $files = array();
                    while ($file = readdir($handler)) {
                        $extension = substr($file, strrpos($file, '.') + 1);
                        if (in_array($extension, array('tpl', 'html', 'css'))) {
                            $files[] = $file;
                        }
                    }
                    sort($files);
                    for ($i = 0; $i < count($files); $i++) {
                        if (strstr($atheme, 'admin') === false) {
                            $template->assign_block_vars('themes.files', array(
                                    'FILE' => $files[$i]
                                    ));
                        } else {
                            $template->assign_block_vars('admin_themes.files', array(
                                    'FILE' => $files[$i]
                                    ));
                        }
                    }
                }
            }
        }
        closedir($dir);
    }
}

$edit_file = false;
if (isset($_POST['file']) && !empty($_POST['theme'])) {
    $theme_path = $theme_root . '/' . $_POST['theme'];
    if ($_POST['theme'] != 'CVS' && is_dir($theme_path) && substr($_POST['theme'], 0, 1) != '.') {
        $edit_file = true;
        $filename = $_POST['file'];
        $theme = $_POST['theme'];
        $filecontents = htmlentities(file_get_contents($theme_path . '/' . $filename));
    }
} elseif (isset($_GET['do']) && $_GET['do'] == 'addfile') {
    $edit_file = true;
    $theme = $_GET['theme'];
}

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],

        'FILENAME' => isset($filename) ? $filename : '',
        'EDIT_THEME' => isset($theme) ? $theme : '',
        'FILECONTENTS' => isset($filecontents) ? $filecontents : '',

        'B_EDIT_FILE' => $edit_file
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'theme.tpl'
        ));
$template->display('body');
include 'footer.php';
