<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

function getmainpath()
{
	$path = getcwd();
	$path = str_replace('install', '', $path);
	return $path;
}

function getdomainpath()
{
	$path = 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	if (strlen($path) < 12)
	{
		$path = 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	}
	$path = str_replace('install', '', $path);
	return $path;
}

function makeconfigfile($contents, $path)
{
	$filename = $path . 'includes/config.inc.php';
	$altfilename = $path . 'includes/config.inc.php.new';

	if (!file_exists($filename))
	{
		if (file_exists($altfilename))
		{
			rename($altfilename, $filename);
		}
		else
		{
			touch($filename);
		}
	}

	@chmod($filename, 0777);

	if (is_writable($filename))
	{
		if (!$handle = fopen($filename, 'w'))
		{
			$return = false;
		}
		else
		{
			if (fwrite($handle, $contents) === false)
			{
				$return = false;
			}
			else
			{
				$return = true;
			}
		}
		fclose($handle);
	}
	else
	{
		$return = false;
	}

	return $return;
}

function print_header($update)
{
	global $package_version;
	if ($update)
	{
		global $_SESSION, $installed_version;
		if (!isset($_SESSION['oldversion']))
		{
			$_SESSION['oldversion'] = $installed_version;
		}

		return '<h1>WeBid Updater, v' . $_SESSION['oldversion'] . ' to v' . $package_version . '</h1>';
	}
	else
	{
		return '<h1>WeBid Installer v' . $package_version . '</h1>';
	}
}

function check_version()
{
	global $DBPrefix, $settings_version, $db;

	// check if using an old version
	if (!isset($settings_version) || empty($settings_version))
	{
		if (is_file('../includes/version.txt'))
		{
			// using a very, very old version
			$version = file_get_contents('../includes/version.txt') or die('error');
			$query = "ALTER TABLE `" . $DBPrefix . "settings` ADD `version` varchar(10) NOT NULL default '" . $version . "'";
			@$db->direct_query($query);
			return $version;
		}
	}

	return $settings_version;
}

function check_installation()
{
	global $DBPrefix, $settings_version, $db;

	if (is_file ('../includes/config.inc.php'))
	{
		include '../includes/config.inc.php';
		$DBPrefix = (isset($DBPrefix)) ? $DBPrefix : '';
		$db->error_supress(true); // we dont want errors returned for now
		if($db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix))
		{
			// old method
			$query = "SHOW COLUMNS FROM `" . $DBPrefix . "settings` WHERE `Field` = 'fieldname' OR `Field` = 'version'";
			$db->query($query);
			$settingkeys = $db->fetchall();
			if(count($settingkeys) > 0)
			{
				if ($settingkeys[0]['Field'] == 'fieldname')
				{
					$query = "SELECT value FROM `" . $DBPrefix . "settings` WHERE fieldname = 'version'";
					$db->direct_query($query);
					$settings_version = $db->result('value');
				}
				else
				{
					$query = "SELECT version FROM `" . $DBPrefix . "settings` LIMIT 1";
					$db->direct_query($query);
					$settings_version = $db->result('version');
				}
				return true;
			}
		}
	}
	return false;
}

function package_version()
{
	$string = file_get_contents('thisversion.txt') or die('error');
	return trim($string);
}

function show_config_table($fresh = true)
{
	$data = '<form name="form1" method="post" action="?step=1">';
	$data .= '<table cellspacing="1" border="1" style="border-collapse:collapse;" cellpadding="6">';
	$data .= '<tr>';
	$data .= '	<td width="140">URL</td>';
	$data .= '	<td width="108">';
	$data .= '	  <input type="text" name="URL" id="textfield" value="' . getdomainpath() . '">';
	$data .= '	</td>';
	$data .= '	<td rowspan="2">';
	$data .= '	  The url &amp; location of the webid installation on your server. It\'s usually best to leave these as they are.<br>';
	$data .= '	  Also if your running on windows at the end of the <b>Doument Root</b> there should be a \\\\ (double backslash)';
	$data .= '	</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Doument Root</td>';
	$data .= '	<td>';
	$data .= '	  <input type="text" name="mainpath" id="textfield" value="' . MAIN_PATH . '">';
	$data .= '	</td>';
	$data .= '</tr>';
	if ($fresh)
	{
		$data .= '<tr>';
		$data .= '	<td>Email Address</td>';
		$data .= '	<td>';
		$data .= '	  <input type="text" name="EMail" id="textfield">';
		$data .= '	</td>';
		$data .= '	<td>The admin email address</td>';
		$data .= '</tr>';
	}
	$data .= '<tr>';
	$data .= '	<td>Database Host</td>';
	$data .= '	<td>';
	$data .= '	  <input type="text" name="DBHost" id="textfield" value="localhost">';
	$data .= '	</td>';
	$data .= '	<td>The location of your MySQL database in most cases its just localhost</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Username</td>';
	$data .= '	<td>';
	$data .= '	  <input type="text" name="DBUser" id="textfield">';
	$data .= '	</td>';
	$data .= '	<td rowspan="3">The username, password and database name of the database your installing webid on</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Password</td>';
	$data .= '	<td>';
	$data .= '	  <input type="text" name="DBPass" id="textfield">';
	$data .= '	</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Name</td>';
	$data .= '	<td>';
	$data .= '	  <input type="text" name="DBName" id="textfield">';
	$data .= '	</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Prefix</td>';
	$data .= '	<td>';
	$data .= '	  <input type="text" name="DBPrefix" id="textfield" value="webid_">';
	$data .= '	</td>';
	$data .= '	<td>the prefix of the webid tables in the database, used so you can install multiple scripts in the same database without issues.</td>';
	$data .= '</tr>';
	if ($fresh)
	{
		$data .= '<tr>';
		$data .= '	<td>Import Default Categories</td>';
		$data .= '	<td>';
		$data .= '	  <input type="checkbox" name="importcats" id="checkbox" checked="checked">';
		$data .= '	</td>';
		$data .= '	<td>Leaving this checked is recommened. But you make want to uncheck it if your auction site is a specalist niche and will need custom catergories.</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';

	if ($fresh)
	{
		$data .= '<br>';
		$data .= '<table cellspacing="1" border="1" style="border-collapse:collapse;" cellpadding="6" width="400px">';
		$data .= '<tr>';
		$data .= '	<td colspan="2"><b>File Checks:</b></td>';
		$data .= '</tr>';
		$directories = array(
			'cache/',
			'uploaded/',
			'uploaded/banners/',
			'uploaded/cache/'
			);

		umask(0);

		$passed = true;
		foreach ($directories as $dir)
		{
			$exists = $write = false;

			// Try to create the directory if it does not exist
			if (!file_exists(MAIN_PATH . $dir))
			{
				@mkdir(MAIN_PATH . $dir, 0755);
				@chmod(MAIN_PATH . $dir, 0755);
			}

			// Now really check
			if (file_exists(MAIN_PATH . $dir) && is_dir(MAIN_PATH . $dir))
			{
				$exists = true;
			}

			// Now check if it is writable by storing a simple file
			$fp = @fopen(MAIN_PATH . $dir . 'test_lock', 'wb');
			if ($fp !== false)
			{
				$write = true;
			}
			@fclose($fp);

			@unlink(MAIN_PATH . $dir . 'test_lock');

			if (!$exists || !$write)
			{
				$passed = false;
			}

			$data .= '<tr><td>' . $dir . ':</td><td>';
			$data .= ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
			$data .= ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
			$data .= '</tr>';
		}

		//check config file exists and is writable
		$write = $exists = true;
		if (file_exists(MAIN_PATH . 'includes/config.inc.php'))
		{
			if (!@is_writable(MAIN_PATH . 'includes/config.inc.php'))
			{
				$write = false;
			}
		}
		elseif (file_exists(MAIN_PATH . 'includes/config.inc.php.new'))
		{
			if (!@is_writable(MAIN_PATH . 'includes/config.inc.php.new'))
			{
				$write = false;
			}
		}
		else
		{
			$write = $exists = false;
		}

		if (!$exists || !$write)
		{
			$passed = false;
		}

		$data .= '<tr><td>includes/config.inc.php.new:</td><td>';
		$data .= ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
		$data .= '</tr>';

		$directories = array(
			'includes/membertypes.inc.php',
			'language/EN/categories.inc.php',
			'language/EN/categories_select_box.inc.php'
			);

		foreach ($directories as $dir)
		{
			$write = $exists = true;
			if (file_exists(MAIN_PATH . $dir))
			{
				if (!@is_writable(MAIN_PATH . $dir))
				{
					$write = false;
				}
			}
			else
			{
				$write = $exists = false;
			}

			if (!$exists || !$write)
			{
				$passed = false;
			}

			$data .= '<tr><td>' . $dir . ':</td><td>';
			$data .= ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
			$data .= ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
			$data .= '</tr>';
		}

		$data .= '<tr><td>GD Support:</td><td>';
		$data .= (extension_loaded('gd') && function_exists('gd_info')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td>BC Math Support:</td><td>';
		$data .= (extension_loaded('bcmath')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td>PHP Data Objects Support:</td><td colspan="2">';
		$data .= (extension_loaded('pdo')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td colspan="2">File Info:</td><td>';
		$data .= (function_exists('finfo_open')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td>PHP Version: (' . phpversion() . ')</td><td colspan="2">';
		$data .= ((version_compare(phpversion(), '5.4', '>'))) ? '<strong style="color:green">OK</strong>' : '<strong style="color:red">Too low</strong>';
		$data .= '</tr>';

		$data .= '</table>';
	}

	$data .= '<br>';
	if ($fresh && $passed || !$fresh)
	{
		$data .= '<input type="submit" value="install">';
	}
	$data .= '</form>';

	return $data;
}

function search_cats($parent_id, $level)
{
	global $catscontrol;

	$catstr = '';
	$root = $catscontrol->get_virtual_root();
	$tree = $catscontrol->display_tree($root['left_id'], $root['right_id'], '|___');
	foreach ($tree as $k => $v)
	{
		$catstr .= ",\n" . $k . " => '" . $v . "'";
	}
	return $catstr;
}

function rebuild_cat_file()
{
	global $system, $DBPrefix, $db;
	$query = "SELECT cat_id, cat_name, parent_id FROM " . $DBPrefix . "categories ORDER BY cat_name";
	$db->direct_query($query);
	$cats = array();
	while ($catarr = $db->fetch())
	{
		$cats[$catarr['cat_id']] = $catarr['cat_name'];
		$allcats[] = $catarr;
	}

	$output = "<?php\n";
	$output.= "$" . "category_names = array(\n";

	$num_rows = count($cats);

	$i = 0;
	foreach ($cats as $k => $v)
	{
		$output .= "$k => '$v'";
		$i++;
		if ($i < $num_rows)
			$output .= ",\n";
		else
			$output .= "\n";
	}

	$output .= ");\n\n";

	$output .= "$" . "category_plain = array(\n0 => ''";

	$output .= search_cats(0, 0);

	$output .= ");\n?>";

	$handle = fopen (MAIN_PATH . 'language/' . $system->SETTINGS['defaultlanguage'] . '/categories.inc.php', 'w');
	fputs($handle, $output);
}

function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dir."/".$object))
           rrmdir($dir."/".$object);
         else
           unlink($dir."/".$object); 
       } 
     }
     rmdir($dir); 
   } 
 }

 function rmf($f) { 
   if(file_exists($f)) {
   	unlink($f);
   }
 }