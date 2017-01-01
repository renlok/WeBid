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

if (!function_exists('view')) {
    function view()
    {
        global $system, $DBPrefix, $db;

        $return = '';
        $joinings = '';
        $extra = '';
        $BANNERSARRAY = array();
        $params = array();

        if (strstr($_SERVER['SCRIPT_FILENAME'], 'browse.php')) { // check categories
            global $id;
            $joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerscategories c ON (c.banner = b.id)';
            $extra .=  ' AND c.category = :cat_id';
            $params[] = array(':cat_id', $id, 'int');
        } elseif (strstr($_SERVER['SCRIPT_FILENAME'], 'item.php')) { // check categories & item title
            global $auction_data;
            $joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerskeywords k ON (k.banner = b.id)';
            $joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerscategories c ON (c.banner = b.id)';
            $extra_cat = '';
            if (!empty($auction_data['secondcat'])) {
                $extra_cat = " OR c.category = :second_cat_id";
                $params[] = array(':second_cat_id', $auction_data['secondcat'], 'int');
            }
            $extra .=  " AND (k.keyword LIKE :title
						OR c.category = :cat_id" . $extra_cat . ")";
            $params[] = array(':cat_id', $auction_data['category'], 'int');
            $params[] = array(':title', '%' . $auction_data['title'] . '%', 'str');
        } elseif (strstr($_SERVER['SCRIPT_FILENAME'], 'adsearch.php')) { // check search terms
            global $_SESSION;
            // check title search
            if (isset($_SESSION['advs']['title']) && !empty($_SESSION['advs']['title'])) {
                $joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerskeywords k ON (k.banner = b.id)';
                $tmp = explode(' ', $_SESSION['advs']['title']);
                $extra .= build_keyword_sql($tmp);
            }
            // check category search
            if (isset($_SESSION['advs']['category']) && !empty($_SESSION['advs']['category'])) {
                $joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerscategories c ON (c.banner = b.id)';
                $extra .=  " OR c.category = :cat_id";
                $params[] = array(':cat_id', $_SESSION['advs']['category'], 'int');
            }
            if ($extra != '') {
                $extra = ' AND (' . $extra . ')';
            }
        } elseif (strstr($_SERVER['SCRIPT_FILENAME'], 'search.php')) { // check search terms
            global $term;
            $joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerskeywords k ON (k.banner = b.id)';
            $tmp = explode(' ', $term);
            $extra .= ' AND ' . build_keyword_sql($tmp);
        }

        $query = "SELECT b.id FROM " . $DBPrefix . "banners b " . $joinings . "
				WHERE (b.views < b.purchased OR b.purchased = 0)" . $extra;
        $db->query($query, $params);
        $CKcount = false;

        if ($db->numrows() == 0) {
            /*$query = "SELECT b.id FROM " . $DBPrefix . "banners b " . $joinings . "
                    WHERE b.views < b.purchased OR b.purchased = 0";*/
            $query = "SELECT b.id, COUNT(k.banner) as Kcount, COUNT(c.banner) as Ccount FROM " . $DBPrefix . "banners b
					LEFT JOIN " . $DBPrefix . "bannerscategories c ON (c.banner = b.id)
					LEFT JOIN " . $DBPrefix . "bannerskeywords k ON (k.banner = b.id)
					WHERE (b.views < b.purchased OR b.purchased = 0)
					AND k.keyword IS NULL AND c.category IS NULL
					GROUP BY k.banner, c.banner";
            $db->direct_query($query);
            $CKcount = false;
        }

        // We have at least one banners to show
        while ($row = $db->fetch()) {
            if ($CKcount && $row['Kcount'] == 0 && $row['Ccount'] == 0) {
                $BANNERSARRAY[] = $row;
            } elseif (!$CKcount) {
                $BANNERSARRAY[] = $row;
            }
        }

        // Display banner
        if (count($BANNERSARRAY) > 0) {
            $RAND_IDX = array_rand($BANNERSARRAY);
            $BANNERTOSHOW = $BANNERSARRAY[$RAND_IDX]['id'];

            $query = "SELECT * FROM " . $DBPrefix . "banners WHERE id = :banner_id";
            $params = array();
            $params[] = array(':banner_id', $BANNERTOSHOW, 'int');
            $db->query($query, $params);
            $THISBANNER = $db->result();
            if ($THISBANNER['type'] == 'swf') {
                $return .= '
				<object width="' . $THISBANNER['width'] . '" height="' . $THISBANNER['height'] . '">
					<param name="movie" value="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '">
					<param name="quality" value="high">
					<embed src="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" width="' . $THISBANNER['width'] . '" height="' . $THISBANNER['height'] . '"></embed>
				</object>';
            } else {
                $return .= '
				<a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '" target="_blank"> <img border=0 alt="' . $THISBANNER['alt'] . '" src="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" /></a>';
            }
            if (!empty($THISBANNER['sponsortext'])) {
                $return .= '<br><a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '" target="_blank">' . $THISBANNER['sponsortext'] . '</a>';
            }
            // Update views
            $query = "UPDATE " . $DBPrefix . "banners set views = views + 1 WHERE id = :banner_id";
            $params = array();
            $params[] = array(':banner_id', $THISBANNER['id'], 'int');
            $db->query($query, $params);
        }
        return $return;
    }
}

function build_keyword_sql($array)
{
    $query = '(';
    if (is_array($array)) {
        $i = 0;
        foreach ($array as $val) {
            if ($i > 0) {
                $query .= ' OR ';
            }
            $query .= "k.keyword LIKE '%" . $val . "%'";
            $i++;
        }
    } else {
        $query .= "k.keyword LIKE '%" . $array . "%'";
    }
    $query .= ')';
    return $query;
}
