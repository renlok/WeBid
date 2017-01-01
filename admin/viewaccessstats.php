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
$current_page = 'stats';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$TOTAL_PAGEVIEWS = 0;
$TOTAL_UNIQUEVISITORS = 0;
$TOTAL_USERSESSIONS = 0;
$params = array();

$listby = 'd';
if (isset($_GET['type']) && in_array($_GET['type'], array('d', 'w', 'm'))) {
    $listby = $_GET['type'];
}

// Retrieve data
if ($listby == 'm') {
    $query = "SELECT SUM(pageviews) as pageviews, SUM(uniquevisitors) as uniquevisitors, SUM(usersessions) as usersessions, month, year
              FROM " . $DBPrefix . "currentaccesses GROUP BY month ORDER BY LENGTH(month), month ASC";
    $statsview = $MSG['monthly_report'];
    $statstext = $MSG['years_months'];
} elseif ($listby == 'w') {
    $year = date('Y');
    $query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE year = :year ORDER BY LENGTH(day), day ASC";
    $params[] = array(':year', $year, 'int');
    $statsview = $MSG['weekly_report'];
    $statstext = $MSG['week'];
} else {
    $month = date('m');
    $year = date('Y');
    $query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE month = :month AND year = :year ORDER BY LENGTH(day), day ASC";
    $params[] = array(':month', $month, 'int');
    $params[] = array(':year', $year, 'int');
    $statsview = date('F Y');
    $statstext = $MSG['day'];
}
$db->query($query, $params);

// set the arrays up
$data_line = array();
$data_max = array();
while ($row = $db->fetch()) {
    if ($listby == 'w') {
        $date = $row['year'] . '/' . $row['month'] . '/' . $row['day'];
        $weekno = date('W', strtotime($date) + $system->tdiff);
        if (!isset($data_line[$weekno])) {
            $data_line[$weekno] = array();
            $data_line[$weekno]['pageviews'] = 0;
            $data_line[$weekno]['uniquevisitors'] = 0;
            $data_line[$weekno]['usersessions'] = 0;
        }
        if (!isset($data_max[$weekno])) {
            $data_max[$weekno] = 0;
        }
        $data_line[$weekno]['pageviews'] += $row['pageviews'];
        $data_line[$weekno]['uniquevisitors'] += $row['uniquevisitors'];
        $data_line[$weekno]['usersessions'] += $row['usersessions'];
        $data_max[$weekno] += $row['pageviews'];
    } elseif ($listby == 'm') {
        $monthno = $row['month'] . $row['year'];
        if (!isset($data_line[$monthno])) {
            $data_line[$monthno] = array();
            $data_line[$monthno]['month'] = $row['month'];
            $data_line[$monthno]['year'] = $row['year'];
            $data_line[$monthno]['pageviews'] = 0;
            $data_line[$monthno]['uniquevisitors'] = 0;
            $data_line[$monthno]['usersessions'] = 0;
        }
        if (!isset($data_max[$monthno])) {
            $data_max[$monthno] = 0;
        }
        $data_line[$monthno]['pageviews'] += $row['pageviews'];
        $data_line[$monthno]['uniquevisitors'] += $row['uniquevisitors'];
        $data_line[$monthno]['usersessions'] += $row['usersessions'];
        $data_max[$monthno] += $row['pageviews'];
    } else {
        $data_line[] = $row;
        $data_max[] = $row['pageviews'];
    }
    $TOTAL_PAGEVIEWS += $row['pageviews'];
    $TOTAL_UNIQUEVISITORS += $row['uniquevisitors'];
    $TOTAL_USERSESSIONS += $row['usersessions'];
}

ksort($data_line);
$MAX = (count($data_max) > 0) ? max($data_max) : 0;
foreach ($data_line as $k => $v) {
    if ($listby == 'w') {
        $date = $k;
    } elseif ($listby == 'm') {
        $date = $v['month'] . '/' . $v['year'];
    } else {
        $date = $v['day'] . '/' . $v['month'] . '/' . $v['year'];
    }
    $template->assign_block_vars('sitestats', array(
            'DATE' => $date,
            'PAGEVIEWS' => $v['pageviews'],
            'PAGEVIEWS_WIDTH' => ($v['pageviews'] * 100) / $MAX,
            'UNIQUEVISITORS' => $v['uniquevisitors'],
            'UNIQUEVISITORS_WIDTH' => ($v['uniquevisitors'] * 100) / $MAX,
            'USERSESSIONS' => $v['usersessions'],
            'USERSESSIONS_WIDTH' => ($v['usersessions'] * 100) / $MAX
            ));
}

$template->assign_vars(array(
        'SITENAME' => $system->SETTINGS['sitename'],
        'TOTAL_PAGEVIEWS' => $TOTAL_PAGEVIEWS,
        'TOTAL_UNIQUEVISITORS' => $TOTAL_UNIQUEVISITORS,
        'TOTAL_USERSESSIONS' => $TOTAL_USERSESSIONS,
        'STATSMONTH' => $statsview,
        'STATSTEXT' => $statstext
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'viewaccessstats.tpl'
        ));
$template->display('body');
include 'footer.php';
