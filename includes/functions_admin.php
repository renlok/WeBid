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

if (!defined('InWeBid')) {
    exit();
}

if (!defined('AdminFuncCall')) {
    function checklogin()
    {
        global $_SESSION, $DBPrefix, $db;

        if (isset($_SESSION['WEBID_ADMIN_NUMBER']) && isset($_SESSION['WEBID_ADMIN_IN']) && isset($_SESSION['WEBID_ADMIN_PASS'])) {
            $query = "SELECT hash, password FROM " . $DBPrefix . "adminusers WHERE password = '" . $_SESSION['WEBID_ADMIN_PASS'] . "' AND id = " . $_SESSION['WEBID_ADMIN_IN'];
            $params = array();
            $params[] = array(':admin_pass', $_SESSION['WEBID_ADMIN_PASS'], 'str');
            $params[] = array(':admin_id', $_SESSION['WEBID_ADMIN_IN'], 'int');
            $db->query($query, $params);

            if ($db->numrows() > 0) {
                $user_data = $db->result();

                if (strspn($user_data['password'], $user_data['hash']) == $_SESSION['WEBID_ADMIN_NUMBER']) {
                    return false;
                }
            }
        }
        return true;
    }

    function getAdminNotes()
    {
        global $_SESSION, $DBPrefix, $db;

        if (isset($_SESSION['WEBID_ADMIN_NUMBER']) && isset($_SESSION['WEBID_ADMIN_IN']) && isset($_SESSION['WEBID_ADMIN_PASS'])) {
            $query = "SELECT notes FROM " . $DBPrefix . "adminusers WHERE password = '" . $_SESSION['WEBID_ADMIN_PASS'] . "' AND id = " . $_SESSION['WEBID_ADMIN_IN'] . " LIMIT 1";
            $params = array();
            $params[] = array(':admin_pass', $_SESSION['WEBID_ADMIN_PASS'], 'str');
            $params[] = array(':admin_id', $_SESSION['WEBID_ADMIN_IN'], 'int');
            $db->query($query, $params);

            if ($db->numrows() > 0) {
                return $db->result('notes');
            }
        }
        return '';
    }

    function loadblock($title = '', $description = '', $type = '', $name = '', $default = '', $tagline = array(), $header = false)
    {
        global $template;

        $template->assign_block_vars('block', array(
                'TITLE' => $title,
                'DESCRIPTION' => (!empty($description)) ? $description . '<br>' : '',
                'TYPE' => $type,
                'NAME' => $name,
                'DEFAULT' => $default,
                'TAGLINE1' => (isset($tagline[0])) ? $tagline[0] : '',
                'TAGLINE2' => (isset($tagline[1])) ? $tagline[1] : '',
                'TAGLINE3' => (isset($tagline[2])) ? $tagline[2] : '',

                'B_HEADER' => $header
                ));
    }

    function generateSelect($name = '', $options = array(), $usekey = true)
    {
        global $selectsetting;

        $html = '<select name="' . $name . '">';
        foreach ($options as $option => $value) {
            if (!$usekey) {
                $option = $value;
            }
            if ($selectsetting == $option) {
                $html .= '<option value="' . $option . '" selected>' . $value . '</option>';
            } else {
                $html .= '<option value="' . $option . '">' . $value . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    function get_hash()
    {
        $string = '0123456789abcdefghijklmnopqrstuvyxz';
        $hash = '';
        for ($i = 0; $i < 5; $i++) {
            $rand = rand(0, 34 - $i);
            $hash .= $string[$rand];
            $string = str_replace($string[$rand], '', $string);
        }
        return $hash;
    }

    function load_file_from_url($url)
    {
        if (false !== ($str = @file_get_contents($url))) {
            return $str;
        } elseif (($handle = @fopen($url, 'r')) !== false) {
            $str = fread($handle, 5);
            if (false !== $str) {
                fclose($handle);
                return $str;
            }
        } elseif (function_exists('curl_init') && function_exists('curl_setopt')
        && function_exists('curl_exec') && function_exists('curl_close')) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_REFERER, $system->SETTINGS['siteurl']);
            $str = curl_exec($curl);
            curl_close($curl);
            return $str;
        }
        return false;
    }

    function resync_category_counters()
    {
        global $db, $system, $DBPrefix;
        // update categories
        $catscontrol = new MPTTcategories();
        $query = "UPDATE " . $DBPrefix . "categories set counter = 0, sub_counter = 0";
        $db->direct_query($query);

        $query = "SELECT COUNT(*) AS COUNT, category FROM " . $DBPrefix . "auctions
				WHERE closed = 0 AND starts <= CURRENT_TIMESTAMP AND suspended = 0 GROUP BY category";
        $db->direct_query($query);

        $cat_data = $db->fetchall();
        foreach ($cat_data as $row) {
            $row['COUNT'] = $row['COUNT'] * 1; // force it to be a number
            if ($row['COUNT'] > 0 && !empty($row['category'])) { // avoid some errors
                $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $row['category'], 'int');
                $db->query($query, $params);
                $parent_node = $db->result();

                $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
                for ($i = 0; $i < count($crumbs); $i++) {
                    $query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :COUNT WHERE cat_id = :cat_id";
                    $params = array();
                    $params[] = array(':COUNT', $row['COUNT'], 'int');
                    $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
                    $db->query($query, $params);
                }
                $query = "UPDATE " . $DBPrefix . "categories SET counter = counter + :COUNT WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':COUNT', $row['COUNT'], 'int');
                $params[] = array(':cat_id', $row['category'], 'int');
                $db->query($query, $params);
            }
        }

        if ($system->SETTINGS['extra_cat'] == 'y') {
            $query = "SELECT COUNT(*) AS COUNT, secondcat FROM " . $DBPrefix . "auctions
					WHERE closed = 0 AND starts <= CURRENT_TIMESTAMP AND suspended = 0 AND secondcat != 0 GROUP BY secondcat";
            $db->direct_query($query);

            $cat_data = $db->fetchall();
            foreach ($cat_data as $row) {
                $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $row['secondcat'], 'int');
                $db->query($query, $params);
                $parent_node = $db->result();

                $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
                for ($i = 0; $i < count($crumbs); $i++) {
                    $query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :COUNT WHERE cat_id = :cat_id";
                    $params = array();
                    $params[] = array(':COUNT', $row['COUNT'], 'int');
                    $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
                    $db->query($query, $params);
                }
                $query = "UPDATE " . $DBPrefix . "categories SET counter = counter + :COUNT WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':COUNT', $row['COUNT'], 'int');
                $params[] = array(':cat_id', $row['secondcat'], 'int');
                $db->query($query, $params);
            }
        }
    }

    define('AdminFuncCall', 1);
}
