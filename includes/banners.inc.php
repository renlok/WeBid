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

if (!defined('InWeBid')) exit();

if (!function_exists('view'))
{
	function view()
	{
		global $system, $DBPrefix, $uploaded_path;

		$return = '';
		$BANNERSARRAY = array();

		// First try to retrieve banners according the filters
		// Categories filter
		if (strstr($_SERVER['SCRIPT_FILENAME'], 'browse.php'))
		{
			$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE category = " . intval($GLOBALS['id']);
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				// We have at least one banners to show
				while ($row = mysql_fetch_array($res))
				{
					$BANNERSARRAY[] = $row;
				}

				// Pick a random element
				if (count($BANNERSARRAY) > 0)
				{
					$RAND_IDX = array_rand($BANNERSARRAY);
					$BANNERTOSHOW = $BANNERSARRAY[$RAND_IDX]['banner'];
				}
			}
		}
		// Keywords filter
		elseif (strstr($_SERVER['SCRIPT_FILENAME'], 'item.php'))
		{
			global $title, $description, $category;
			$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords
					 WHERE keyword LIKE '%" . $title . "%' OR keyword LIKE '%" . $description . "%'";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				// We have at least one banners to show
				while ($row = mysql_fetch_array($res))
				{
					$BANNERSARRAY[] = $row;
				}
			}
			$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE category = " . $category;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				// We have at least one banners to show
				while ($row = mysql_fetch_array($res))
				{
					$BANNERSARRAY[] = $row;
				}
			}
			// Pick a random element
			if (count($BANNERSARRAY) > 0)
			{
				$RAND_IDX = array_rand($BANNERSARRAY);
				$BANNERTOSHOW = $BANNERSARRAY[$RAND_IDX]['banner'];
			}
		}

		// We cannot apply filters in this page - let's retrieve a random banner
		if (empty($BANNERTOSHOW))
		{
			$query = "SELECT * FROM " . $DBPrefix . "banners WHERE (views < purchased AND purchased > 0) OR purchased = 0";
			if ($system->SETTINGS['banner_sizetype'] == 'fix')
			{
				$query .= " AND width = " . $system->SETTINGS['banner_width'] . " AND height = " . $system->SETTINGS['banner_height'];
			}

			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				$CC = $C = 0;

				while ($row = mysql_fetch_array($res))
				{
					$query = "SELECT banner FROM " . $DBPrefix . "bannerscategories WHERE banner = " . $row['id'];
					$res = mysql_query($query);
					$system->check_mysql($res, $query, __LINE__, __FILE__);
					$C = mysql_num_rows($res);
					$query = "SELECT banner FROM " . $DBPrefix . "bannerskeywords WHERE banner = " . $row['id'];
					$res = mysql_query($query);
					$system->check_mysql($res, $query, __LINE__, __FILE__);
					$CC = mysql_num_rows($res);

					if ($C == 0 && $CC == 0)
					{
						$BANNERSARRAY[] = $row;
					}
				}
			}

			// Pick a random element
			if (count($BANNERSARRAY) > 0)
			{
				$RAND_IDX = array_rand($BANNERSARRAY);
				$BANNERTOSHOW = $BANNERSARRAY[$RAND_IDX]['id'];
			}
		}

		// Display banner
		if (isset($BANNERTOSHOW))
		{
			$query = "SELECT * FROM " . $DBPrefix . "banners WHERE id = " . $BANNERTOSHOW;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$THISBANNER = mysql_fetch_array($res);
			if ($THISBANNER['type'] == 'swf')
			{
				$return .= '
				<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="468" height="60">
				<param name=movie value="' . $system->SETTINGS['siteurl'] . $uploaded_path . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" />
				<param name=quality value=high />
				<embed src="' . $system->SETTINGS['siteurl'] . $uploaded_path . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="' . $THISBANNER['width'] . '" height="' . $THISBANNER['height'] . '"> </embed>
				</object>';
			}
			else
			{
				$return .= '
				<a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '&url=' . $THISBANNER['url'] . '" target="_blank"> <img border=0 alt="' . $THISBANNER['alt'] . '" src="' . $system->SETTINGS['siteurl'] . $uploaded_path . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" /></a>';
			}
			if (!empty($THISBANNER['sponsortext']))
			{
				$return .= '<br><a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '&url=' . $THISBANNER['url'] . '" target="_blank">' . $THISBANNER['sponsortext'] . '</a>';
			}
			// Update views
			$query = "UPDATE " . $DBPrefix . "banners set views = views + 1 WHERE id = " . $THISBANNER['id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		return $return;
	}
}
?>