<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit('Access denied');

class MPTTcategories
{
	// Add an element to the tree as a child of $parent and as $child_num'th child. If $data is not supplied the insert id will be returned.
	function add($parent_id, $child_num = 0, $misc_data = false)
	{
		global $system, $DBPrefix;
		if(!is_numeric($parent_id) || $parent_id < 0)
		{
			return false;
		}
		if($parent_id != 0)
		{
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $parent_id;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if(mysql_num_rows($res) != 1)
			{ // Row must exist.
				return false;
			}
			$parent = mysql_fetch_assoc($res);
		}
		else
		{
			// Virtual root element as parent.
			$parent = $this->get_virtual_root();
		}
		$children = $this->get_children($parent['left_id'], $parent['right_id'], $parent['level']);

		if(count($children) == 0)
		{
			$child_num = 0;
		}
		if($child_num == 0 || (count($children) - $child_num) <= 0 || (count($children) + $child_num + 1) < 0)
		{
			$boundry = array('left_id', 'right_id', $parent['left_id']);
		}
		elseif($child_num != 0)
		{
			// Some other child.
			if($child_num < 0)
			{
				$child_num = count($children) + $child_num + 1;
			}
			if($child_num > count($children))
			{
				$child_num = count($children);
			}
			$boundry = array('right_id', 'left_id', $children[$child_num - 1]['right_id']);
		}
		else
		{
			return false;
		}

		// Make a hole for the new element.
		$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id + 2 WHERE " . $boundry[0] . " > " . $boundry[2] . " AND " . $boundry[1] . " > " . $boundry[2];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "UPDATE " . $DBPrefix . "categories SET right_id = right_id + 2 WHERE " . $boundry[1] . " > " . $boundry[2];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// Insert the new element.
		$data = array(
			'left_id' => $boundry[2] + 1,
			'right_id' => $boundry[2] + 2,
			'level' => $parent['level'] + 1,
			'parent_id' => $parent_id
		);
		if($misc_data && is_array($misc_data))
		{
			$data = array_merge($misc_data, $data);
		}
		$data = $this->build_sql($data);
		$query = "INSERT INTO " . $DBPrefix . "categories SET " . $data;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		if(!$misc_data)
		{
			return mysql_insert_id();
		}
		return true;
	}

	// Deletes element $id with or without children. If children should be kept they will become children of $id's parent.
	function delete($id, $keep_children = false)
	{
		global $system, $DBPrefix;
		if(!is_numeric($id) || $id <= 0 || !is_bool($keep_children))
		{
			return false;
		}
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if(mysql_num_rows($res) != 1)
		{ // Row must exist.
			return false;
		}
		$a = mysql_fetch_assoc($res);

		if(!$keep_children)
		{
			// Delete the element with children.
			$query = "DELETE FROM " . $DBPrefix . "categories WHERE left_id >= " . $a['left_id'] . " AND right_id <= " . $a['right_id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Remove the hole.
			$diff = $a['right_id'] - $a['left_id'] + 1;
			$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id - " . $diff . " WHERE right_id > " . $a['right_id'] . " AND left_id > " . $a['right_id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "UPDATE " . $DBPrefix . "categories SET right_id = right_id - " . $diff . " WHERE right_id > " . $a['right_id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// No level cahnges needed.
		}
		else
		{
			// Delete ONLY the element.
			$query = "DELETE FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Fix children.
			$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id - 1, right_id = right_id - 1, level = level - 1 WHERE left_id >= " . $a['left_id'] . " AND right_id <= " . $a['right_id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Remove hole.
			$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id - 2 WHERE right_id > " . ($a['right_id'] - 1) . " AND left_id > " . ($a['right_id'] - 1);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "UPDATE " . $DBPrefix . "categories SET right_id = right_id - 2 WHERE right_id > " . ($a['right_id'] - 1);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}

	// Move an element (with children) $id, under element $target_id as the $child_num'th child of that element
	function move($id, $target_id, $child_num = 0)
	{
		global $system, $DBPrefix;
		if(!is_numeric($id) || !is_numeric($target_id) || !is_numeric($child_num))
		{
			return false;
		}
		if($target_id != 0)
		{
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $id . " OR cat_id = " . $target_id;
			// I want the to be returned in order.
			$query .= ' ORDER BY cat_id ' . (($id < $target_id) ? 'ASC' : 'DESC');

			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if(mysql_num_rows($res) != 2)
			{ // Both rows must exist.
				return false;
			}
			$a = mysql_fetch_assoc($res); // This is being moved.
			$b = mysql_fetch_assoc($res); // This is the target.
		}
		else
		{
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;

			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if(mysql_num_rows($res) != 1)
			{ // Row must exist.
				return false;
			}
			$a = mysql_fetch_assoc($res); // This is being moved.

			// Virtual root element.
			$b = $this->get_virtual_root();
		}

		// We need to get the children.
		$children = $this->get_children($b['left_id'], $b['right_id'], $b['level']);

		if(count($children) == 0)
		{
			$child_num = 0;
		}
		if($child_num == 0 || (count($children) - $child_num) <= 0 || (count($children) + $child_num + 1) < 0)
		{
			// First child.
			$boundry = array('left_id', 'right_id', 'right_id', $b['left_id']);
		}
		elseif($child_num != 0)
		{
			// Some other child.
			if($child_num < 0)
			{
				$child_num = count($children) + $child_num + 1;
			}
			if($child_num > count($children))
			{
				$child_num = count($children);
			}
			$boundry =  array('right_id', 'left_id', 'right_id', $children[$child_num - 1]['right_id']);
		}
		else
		{
			return false;
		}

		// Math.
		$diff = $a['right_id'] - $a['left_id'] + 1; // The "size" of the tree.

		if($a['left_id'] < $boundry[3])
		{
			$size = $boundry[3] - $diff;
			$dist = $boundry[3] - $diff - $a['left_id'] + 1;
		}
		else
		{
			$size = $boundry[3];
			$dist = $boundry[3] - $a['left_id'] + 1;
		}
		// Level math.
		$ldiff = ($a['level'] - $b['level'] - 1) * -1;
		// We have all what we need.

		$query = array();

		// Give the needed rows negative id's.
		$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id * -1, right_id = right_id * -1 WHERE left_id >= " . $a['left_id'] . " AND right_id <= " . $a['right_id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		// Remove the hole.
		$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id - " . $diff . " WHERE right_id > " . $a['right_id'] . " AND left_id > " . $a['right_id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "UPDATE " . $DBPrefix . "categories SET right_id = right_id - " . $diff . " WHERE right_id > " . $a['right_id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		// Add hole
		$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id + " . $diff . " WHERE " . $boundry[0] . " > " . $size . " AND " . $boundry[1] . " > " . $size;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "UPDATE " . $DBPrefix . "categories SET right_id = right_id + " . $diff . " WHERE " . $boundry[2] . " > " . $size;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		// Fill hole & update rows & multiply by -1
		$query = "UPDATE " . $DBPrefix . "categories SET left_id = (left_id - (" . $dist . ")) * -1, right_id = (right_id - (" . $dist . ")) * -1, level = level + (" . $ldiff . ") WHERE left_id < 0";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		return true;
	}

	// Copies element $id (with children) to $parent as the $child_mun'th child.
	function copy($id, $parent, $child_num = 0)
	{
		global $system, $DBPrefix;
		if(!is_numeric($id) || $id < 0 ||!is_numeric($parent) || $parent < 0)
		{
			return false;
		}
		// Get branch left & right id's.
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if(mysql_num_rows($res) != 1)
		{ // Row must Exist.
			return false;
		}
		$a = mysql_fetch_assoc($res);
		// Get child data.
		$query = "SELECT * FROM " . $DBPrefix . "categories WHERE left_id >= " . $a['left_id'] . " AND right_id <= " . $a['right_id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		while($row = mysql_fetch_assoc($res))
		{
			$data[] = $row;
		}

		if($parent != 0)
		{
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $parent;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);

			if(mysql_num_rows($res) != 1)
			{ // Row must exist.
				return false;
			}
			$b = mysql_fetch_assoc($res);
		}
		else
		{
			$b = $this->get_virtual_root();
		}

		// Get target's children.
		$children = $this->get_children($b['left_id'], $b['right_id'], $b['level']);

		if(count($children) == 0)
		{
			$child_num = 0;
		}
		if($child_num == 0 || (count($children) - $child_num) <= 0 || (count($children) + $child_num + 1) < 0)
		{
			// First child.
			$boundry = array('left_id', 'right_id', 'right_id', $b['left_id']);
		}
		elseif($child_num != 0)
		{
			// Some other child.
			if($child_num < 0)
			{
				$child_num = count($children) + $child_num + 1;
			}
			if($child_num > count($children))
			{
				$child_num = count($children);
			}
			$boundry =  array('right_id', 'left_id', 'right_id', $children[$child_num - 1]['right_id']);
		}
		else
		{
			return false;
		}

		// Math.
		$diff = $a['right_id'] - $a['left_id'] + 1;
		$dist = $boundry[3] - $a['left_id'] + 1;
		// Level math.
		$ldiff = ($a['level'] - $b['level'] - 1);

		// Add hole.
		$query = "UPDATE " . $DBPrefix . "categories SET left_id = left_id + " . $diff . " WHERE " . $boundry[0] . " > " . $boundry[3] . " AND " . $boundry[1] . " > " . $boundry[3];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "UPDATE " . $DBPrefix . "categories SET right_id = right_id + " . $diff . " WHERE " . $boundry[2] . " > " . $boundry[3];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// Now we have to insert all the new elements.
		for($i = 0, $n = count($data); $i< $n; $i++)
		{
			// We need a new key.
			unset($data[$i][FIELD_KEY]);

			// This fields need new values.
			$data[$i]['left_id'] += $dist;
			$data[$i]['right_id'] += $dist;
			$data[$i]['level'] -= $ldiff;

			$data[$i] = $this->build_sql($data[$i]);
			$query = "INSERT INTO " . $DBPrefix . "categories SET " . $data[$i];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		return true;
	}

	// get a nodes children
	function get_children($left_id, $right_id, $level)
	{
		global $system, $DBPrefix;
		$query = "SELECT * FROM " . $DBPrefix . "categories WHERE left_id > " . $left_id . " AND right_id < " . $right_id . " AND level = " . ($level + 1) . " ORDER BY cat_name";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$children = array();
		while($child = mysql_fetch_assoc($res))
		{
			$children[] = $child;
		}

		return $children;
	}
	
	// return a list of every child node of a given parent node
	function get_children_list($left_id, $right_id, $return = 'cat_id')
	{
		global $system, $DBPrefix;

		if (empty($left_id) || empty($right_id))
		{
			return array();
		}
		$query = "SELECT " . $return . " FROM " . $DBPrefix . "categories WHERE left_id > " . $left_id . " AND right_id < " . $right_id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$children = array();
		while($child = mysql_fetch_assoc($res))
		{
			$children[] = $child;
		}

		return $children;
	}
	
	//returns an ordered list of categories
	function display_tree($left_id, $right_id, $indent = "\t")
	{
		global $system, $DBPrefix;
		// start with an empty $right stack
		$right = array();
		$return = array();

		// now, retrieve all descendants of the $root node
		$query = "SELECT * FROM " . $DBPrefix . "categories WHERE left_id > " . $left_id . " AND right_id < " . $right_id . " ORDER BY left_id ASC";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		// display each row
		while ($row = mysql_fetch_array($res))
		{
			// only check stack if there is one
			if (count($right) > 0)
			{
				// check if we should remove a node from the stack
				while (isset($right[count($right) - 1]) && $right[count($right) - 1] < $row['right_id'])
				{
					array_pop($right);
				}
			}
			// display indented node title
			$return[$row['cat_id']] = str_repeat($indent, count($right)) . $row['cat_name'];
			// add this node to the stack
			$right[] = $row['right_id'];
		}
		return $return;
	}

	// Return the left_id, right_id and level for the virtual root node.
	function get_virtual_root()
	{
		global $system, $DBPrefix;
		// Virtual root element as parent.
		$query = "SELECT right_id FROM " . $DBPrefix . "categories ORDER BY right_id DESC LIMIT 1";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$row = mysql_fetch_assoc($res);
		$root = array('left_id' => 1, 'right_id' => $row['right_id'], 'level' => -1);
		return $root;
	}
	
	function get_bread_crumbs($left_id, $right_id)
	{
		global $system, $DBPrefix;

		if (empty($left_id) || empty($right_id))
		{
			return array();
		}
		// return an array of all parent nodes
		$query = "SELECT cat_name, cat_id FROM " . $DBPrefix . "categories WHERE left_id <= " . $left_id . " AND right_id >= " . $right_id . " ORDER BY left_id ASC";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$array = array();
		while ($row = mysql_fetch_assoc($res))
		{
			$array[] = $row;
		}
		return $array;
	}

	// Build INSERT statement
	function build_sql($data)
	{
		foreach($data as $k => $v)
		{
			if(is_numeric($v))
			{
				$data[$k] = '`' . $k . '` = ' . $v . '';
			}
			else
			{
				$data[$k] = '`' . $k . '` = \'' . mysql_real_escape_string($v) . '\'';
			}
		}
		return implode(', ', $data);
	}

	function check_category($id)
	{
		global $system, $DBPrefix;

		$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE cat_id = " . $id . " LIMIT 1";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>