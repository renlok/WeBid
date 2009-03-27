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

require('includes/common.inc.php');
include $main_path . "language/" . $language . "/categories.inc.php";
include $include_path . 'dates.inc.php';

$NOW = time();

if (!ini_get('register_globals')) {
    $superglobales = array($_POST, $_GET);
    foreach ($superglobales as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
}

$q = trim($_GET['q']);
$query = $q;
$qquery = ereg_replace("%", "\\%", $query);
$qquery = ereg_replace("_", "\\_", $qquery);

if (strlen($query) == 0) {
    $template->assign_vars(array(
            'ERROR' => $ERR_037,
            'NUM_AUCTIONS' => 0,
            'TOP_HTML' => ''
            ));
} else {
    /* generate query syntax for searching in auction */
    $search_words = explode (" ", $qquery);

    $qp1 = " (title LIKE '%" . addslashes($qquery) . "%' OR id = " . intval($q) . ")  ";
    $qp = " (cat_name LIKE '%" . addslashes($qquery) . "%') ";

    $addOR = true;
    while (list(, $val) = each($search_words)) {
        $val = ereg_replace("%", "\\%", $val);
        $val = ereg_replace("_", "\\_", $val);
        if ($addOR) {
            $qp1 .= " OR ";
            $qp .= " OR ";
        }
        $addOR = true;

        $qp1 .= " (title LIKE '%" . addslashes($val) . "%') ";
        $qp .= "(cat_name LIKE '%" . addslashes($qquery) . "%') ";
    }

    $sql_count = "SELECT count(*) FROM " . $DBPrefix . "auctions WHERE ($qp1) AND (closed='0') AND (suspended='0') AND private='n' AND starts <= " . $NOW . " ORDER BY ends";
    $sql = "SELECT * FROM " . $DBPrefix . "auctions WHERE ($qp1) AND (closed='0') AND (suspended ='0') AND private='n' AND starts <= " . $NOW . " ORDER BY ends";
    $sql_cat = "SELECT * FROM " . $DBPrefix . "categories WHERE " . $qp . " ORDER BY cat_name ASC";
    /* get categories whose names fit the search criteria */

    $result = mysql_query($sql_cat);
    $system->check_mysql($result, $sql_cat, __LINE__, __FILE__);

    $subcat_count = 0;

    /* query succeeded - display list of categories */
    $need_to_continue = 1;
    $cycle = 1;

    $TPL_main_value = "";
    while ($row = mysql_fetch_array($result)) {
        ++$subcat_count;
        if ($cycle == 1) {
            $TPL_main_value .= "<TR ALIGN=LEFT>\n";
        }
        $sub_counter = (int)$row['sub_counter'];
        $cat_counter = (int)$row['counter'];
        if ($sub_counter != 0) {
            $count_string = "(" . $sub_counter . ")";
        } else {
            if ($cat_counter != 0) {
                $count_string = "(" . $cat_counter . ")";
            } else {
                $count_string = "";
            }
        }
        if ($row['cat_colour'] != "") {
            $BG = "bgcolor=" . $row['cat_colour'];
        } else {
            $BG = "";
        }
        // //  Select the translated category name
        $row['cat_name'] = $category_names[$row['cat_id']];

        $catimage = (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '';
        $TPL_main_value .= "	<TD $BG WIDTH=\"33%\">$catimage<a href=\"" . $system->SETTINGS['siteurl'] . "browse.php?id=" . $row['cat_id'] . "\">" . $row['cat_name'] . "</a>" . $count_string . "</FONT></TD>\n";

        ++$cycle;
        if ($cycle == 4) {
            $cycle = 1;
            $TPL_main_value .= "</TR>\n";
        }
    }

    if ($cycle >= 2 && $cycle <= 3) {
        while ($cycle < 4) {
            $TPL_main_value .= "	<TD WIDTH=\"33%\">&nbsp;</TD>\n";
            ++$cycle;
        }
        $TPL_main_value .= "</TR>\n";
    }

    /* get list of auctions of this category */
    $auctions_count = 0;

    /* retrieve records corresponding to passed page number */
    $PAGE = (int)$_GET['page'];
    if ($PAGE == 0) $PAGE = 1;
    $lines = (int)$lines;
    if ($lines == 0) $lines = 50;

    /* determine limits for SQL query */
    $left_limit = ($PAGE - 1) * $lines;

    /* get total number of records */
    $rsl = mysql_query ($sql_count);
    $system->check_mysql($rsl, $sql_count, __LINE__, __FILE__);

    $hash = mysql_fetch_array($rsl);
    $total = (int)$hash[0];

    /* get number of pages */
    $PAGES = (int)($total / $lines);
    if (($total % $lines) > 0)
        ++$PAGES;

    $result = mysql_query ($sql . " LIMIT $left_limit,$lines");
    $system->check_mysql($result, $sql, __LINE__, __FILE__);
    // to be sure about items format, I've unified the call
    include $include_path . "browseitems.inc.php";
    browseItems($result, 'search.php');
}

include "header.php";
$template->set_filenames(array(
        'body' => 'search.html'
        ));
$template->display('body');

include "footer.php";

?>