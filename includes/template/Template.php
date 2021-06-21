<?php
/**
*
* @package phpBB3 Modified for use with WeBid
* @version $Id: template.php 8943 2008-09-26 13:09:56Z acydburn $
* @copyright (c) 2005 phpBB Group, sections (c) 2001 ispi of Lincoln Inc
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('InWeBid'))
{
	exit;
}

/**
* Base Template class.
* @package phpBB3
*/
class Template
{
	/** variable that holds all the data we'll be substituting into
	* the compiled templates. Takes form:
	* --> $this->_tpldata[block][iteration#][child][iteration#][child2][iteration#][variablename] == value
	* if it's a root-level variable, it'll be like this:
	* --> $this->_tpldata[.][0][varname] == value
	*/
	var $_tpldata = array('.' => array(0 => array()));
	var $_rootref;

	// Root dir and hash of filenames for each template handle.
	var $root = '';
	var $cachepath = '';
	var $files = array();
	var $filename = array();
	var $files_inherit = array();
	var $files_template = array();
	var $inherit_root = '';
	var $InAdmin = false;

	// this will hash handle names to the compiled/uncompiled code for that handle.
	var $compiled_code = array();

	/**
	* Set template location
	* @access public
	*/
	function set_template()
	{
		global $system;

		$theme = (!defined('InAdmin')) ? $system->SETTINGS['theme'] : $system->SETTINGS['admin_theme'];

		if (file_exists(MAIN_PATH . 'themes/' . $theme))
		{
			$this->root = MAIN_PATH . 'themes/' . $theme;
			$this->cachepath = MAIN_PATH . 'cache/tpl_' . str_replace('_', '-', $theme) . '_';
			$this->default_root = MAIN_PATH . 'themes/default';
			$this->default_cachepath = MAIN_PATH . 'cache/tpl_default' . '_';
		}
		else
		{
			trigger_error('Template path could not be found: themes/' . $theme, E_USER_ERROR);
		}

		$this->_rootref = &$this->_tpldata['.'][0];

		return true;
	}

	/**
	* Set custom template location (able to use directory outside of phpBB)
	* @access public
	*/
	function set_custom_template($template_path, $template_name)
	{
		$this->root = $template_path;
		$this->cachepath = MAIN_PATH . 'cache/ctpl_' . str_replace('_', '-', $template_name) . '_';

		return true;
	}

	/**
	* Sets the template filenames for handles. $filename_array
	* should be a hash of handle => filename pairs.
	* @access public
	*/
	function set_filenames($filename_array)
	{
		if (!is_array($filename_array))
		{
			return false;
		}
		foreach ($filename_array as $handle => $filename)
		{
			if (empty($filename))
			{
				trigger_error("template->set_filenames: Empty filename specified for $handle", E_USER_ERROR);
			}

			$this->filename[$handle] = $filename;
			$this->files[$handle] = $this->root . '/' . $filename;
		}

		return true;
	}

	/**
	* Destroy template data set
	* @access public
	*/
	function destroy()
	{
		$this->_tpldata = array('.' => array(0 => array()));
	}

	/**
	* Reset/empty complete block
	* @access public
	*/
	function destroy_block_vars($blockname)
	{
		if (strpos($blockname, '.') !== false)
		{
			// Nested block.
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;

			$str = &$this->_tpldata;
			for ($i = 0; $i < $blockcount; $i++)
			{
				$str = &$str[$blocks[$i]];
				$str = &$str[sizeof($str) - 1];
			}

			unset($str[$blocks[$blockcount]]);
		}
		else
		{
			// Top-level block.
			unset($this->_tpldata[$blockname]);
		}

		return true;
	}

	/**
	* Display handle
	* @access public
	*/
	function display($handle, $include_once = true)
	{
		global $MSG;
		if ($filename = $this->_tpl_load($handle))
		{
			($include_once) ? include_once($filename) : include($filename);
		}
		else
		{
			eval(' ?>' . $this->compiled_code[$handle] . '<?php ');
		}

		//return true;
	}

	/**
	* Display the handle and assign the output to a template variable or return the compiled result.
	* @access public
	*/
	function assign_display($handle, $template_var = '', $return_content = true, $include_once = false)
	{
		ob_start();
		$this->display($handle, $include_once);
		$contents = ob_get_clean();

		if ($return_content)
		{
			return $contents;
		}

		$this->assign_var($template_var, $contents);

		return true;
	}

	/**
	* Load a compiled template if possible, if not, recompile it
	* @access private
	*/
	function _tpl_load(&$handle)
	{
		global $system;

		$filename = $this->cachepath . str_replace('/', '.', $this->filename[$handle]) . '.php';
		$this->files_template[$handle] = $system->SETTINGS['theme'];

		$recompile = false;
		if (!file_exists($filename) || @filesize($filename) === 0 || $system->SETTINGS['cache_theme'] == 'n')
		{
			$recompile = true;
		}

		// Recompile page if the original template is newer, otherwise load the compiled version
		if (!$recompile)
		{
			return $filename;
		}

		if (!class_exists('TemplateCompile'))
		{
			include(INCLUDE_PATH . 'template/TemplateCompile.php');
		}
		$compile = new TemplateCompile($this);

		// If we don't have a file assigned to this handle, die.
		if (!isset($this->files[$handle]))
		{
			trigger_error("template->_tpl_load(): No file specified for handle $handle", E_USER_ERROR);
		}

		$compile->_tpl_load_file($handle);
		return false;
	}

	/**
	* Assign key variable pairs from an array
	* @access public
	*/
	function assign_vars($vararray)
	{
		foreach ($vararray as $key => $val)
		{
			$this->_rootref[$key] = $val;
		}
		global $_SESSION;
		if(isset($_SESSION['csrftoken']))
		{
			$this->_rootref['_CSRFTOKEN'] = $_SESSION['csrftoken'];
			$this->_rootref['_CSRFFORM'] = '<input type="hidden" name="csrftoken" value="' . $_SESSION['csrftoken'] . '">';
		}

		return true;
	}

	/**
	* Assign a single variable to a single key
	* @access public
	*/
	function assign_var($varname, $varval)
	{
		$this->_rootref[$varname] = $varval;

		return true;
	}

	/**
	* Assign key variable pairs from an array to a specified block
	* @access public
	*/
	function assign_block_vars($blockname, $vararray)
	{
		if (strpos($blockname, '.') !== false)
		{
			// Nested block.
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;

			$str = &$this->_tpldata;
			for ($i = 0; $i < $blockcount; $i++)
			{
				$str = &$str[$blocks[$i]];
				$str = &$str[sizeof($str) - 1];
			}

			$s_row_count = isset($str[$blocks[$blockcount]]) ? sizeof($str[$blocks[$blockcount]]) : 0;
			$vararray['S_ROW_COUNT'] = $s_row_count;

			// Assign S_FIRST_ROW
			if (!$s_row_count)
			{
				$vararray['S_FIRST_ROW'] = true;
			}

			// Now the tricky part, we always assign S_LAST_ROW and remove the entry before
			// This is much more clever than going through the complete template data on display (phew)
			$vararray['S_LAST_ROW'] = true;
			if ($s_row_count > 0)
			{
				unset($str[$blocks[$blockcount]][($s_row_count - 1)]['S_LAST_ROW']);
			}

			// Now we add the block that we're actually assigning to.
			// We're adding a new iteration to this block with the given
			// variable assignments.
			$str[$blocks[$blockcount]][] = $vararray;
		}
		else
		{
			// Top-level block.
			$s_row_count = (isset($this->_tpldata[$blockname])) ? sizeof($this->_tpldata[$blockname]) : 0;
			$vararray['S_ROW_COUNT'] = $s_row_count;

			// Assign S_FIRST_ROW
			if (!$s_row_count)
			{
				$vararray['S_FIRST_ROW'] = true;
			}

			// We always assign S_LAST_ROW and remove the entry before
			$vararray['S_LAST_ROW'] = true;
			if ($s_row_count > 0)
			{
				unset($this->_tpldata[$blockname][($s_row_count - 1)]['S_LAST_ROW']);
			}

			// Add a new iteration to this block with the variable assignments we were given.
			$this->_tpldata[$blockname][] = $vararray;
		}

		return true;
	}

	/**
	* Change already assigned key variable pair (one-dimensional - single loop entry)
	*
	* An example of how to use this function:
	* {@example alter_block_array.php}
	*
	* @param	string	$blockname	the blockname, for example 'loop'
	* @param	array	$vararray	the var array to insert/add or merge
	* @param	mixed	$key		Key to search for
	*
	* array: KEY => VALUE [the key/value pair to search for within the loop to determine the correct position]
	*
	* int: Position [the position to change or insert at directly given]
	*
	* If key is false the position is set to 0
	* If key is true the position is set to the last entry
	*
	* @param	string	$mode		Mode to execute (valid modes are 'insert' and 'change')
	*
	*	If insert, the vararray is inserted at the given position (position counting from zero).
	*	If change, the current block gets merged with the vararray (resulting in new key/value pairs be added and existing keys be replaced by the new value).
	*
	* Since counting begins by zero, inserting at the last position will result in this array: array(vararray, last positioned array)
	* and inserting at position 1 will result in this array: array(first positioned array, vararray, following vars)
	*
	* @return bool false on error, true on success
	* @access public
	*/
	function alter_block_array($blockname, $vararray, $key = false, $mode = 'insert')
	{
		if (strpos($blockname, '.') !== false)
		{
			// Nested blocks are not supported
			return false;
		}

		// Change key to zero (change first position) if false and to last position if true
		if ($key === false || $key === true)
		{
			$key = ($key === false) ? 0 : sizeof($this->_tpldata[$blockname]);
		}

		// Get correct position if array given
		if (is_array($key))
		{
			// Search array to get correct position
			list($search_key, $search_value) = @each($key);

			$key = NULL;
			foreach ($this->_tpldata[$blockname] as $i => $val_ary)
			{
				if ($val_ary[$search_key] === $search_value)
				{
					$key = $i;
					break;
				}
			}

			// key/value pair not found
			if ($key === NULL)
			{
				return false;
			}
		}

		// Insert Block
		if ($mode == 'insert')
		{
			// Make sure we are not exceeding the last iteration
			if ($key >= sizeof($this->_tpldata[$blockname]))
			{
				$key = sizeof($this->_tpldata[$blockname]);
				unset($this->_tpldata[$blockname][($key - 1)]['S_LAST_ROW']);
				$vararray['S_LAST_ROW'] = true;
			}
			else if ($key === 0)
			{
				unset($this->_tpldata[$blockname][0]['S_FIRST_ROW']);
				$vararray['S_FIRST_ROW'] = true;
			}

			// Re-position template blocks
			for ($i = sizeof($this->_tpldata[$blockname]); $i > $key; $i--)
			{
				$this->_tpldata[$blockname][$i] = $this->_tpldata[$blockname][$i-1];
				$this->_tpldata[$blockname][$i]['S_ROW_COUNT'] = $i;
			}

			// Insert vararray at given position
			$vararray['S_ROW_COUNT'] = $key;
			$this->_tpldata[$blockname][$key] = $vararray;

			return true;
		}

		// Which block to change?
		if ($mode == 'change')
		{
			if ($key == sizeof($this->_tpldata[$blockname]))
			{
				$key--;
			}

			$this->_tpldata[$blockname][$key] = array_merge($this->_tpldata[$blockname][$key], $vararray);
			return true;
		}

		return false;
	}

	/**
	* Include a separate template
	* @access private
	*/
	function _tpl_include($filename, $include = true)
	{
		global $MSG;
		$handle = $filename;
		$this->filename[$handle] = $filename;
		$this->files[$handle] = $this->root . '/' . $filename;

		$filename = $this->_tpl_load($handle);

		if ($include)
		{
			if ($filename)
			{
				include($filename);
				return;
			}
			eval(' ?>' . $this->compiled_code[$handle] . '<?php ');
		}
	}
}
