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

if(empty($_SESSION['WEBID_ADMIN_LOGIN'])) {
	header("location: login.php");
	exit;
}

if(!function_exists('loadblock')) {
	function loadblock($title = '', $description = '', $type = '', $name = '', $default = '', $tagline1 = '', $tagline2 = '', $tagline3 = '') {
		global $template;
		
		$template->assign_block_vars('block', array(
				'TITLE' => $title,
				'DESCRIPTION' => (!empty($description)) ? $description . '<br>' : '',
				'TYPE' => $type,
				'NAME' => $name,
				'DEFAULT' => $default,
				'TAGLINE1' => $tagline1,
				'TAGLINE2' => $tagline2,
				'TAGLINE3' => $tagline3
				));
	}
}

if(!function_exists('generateSelect')) {
	function generateSelect($name = '', $options = array()) {
		global $selectsetting;
		$html = '<select name="' . $name . '">';
		foreach ($options as $option => $value ) {
			if($selectsetting == $option){
				$html .= '<option value=' . $option . ' selected>' . $value . '</option>';
			} else {
				$html .= '<option value=' . $option . '>' . $value . '</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
}
?>