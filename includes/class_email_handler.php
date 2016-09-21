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

if (!defined('InWeBid')) exit('Access denied');

class email_handler
{
	var $from, $message, $subject, $headers, $email_uid, $userlang, $errors;

	public function __construct()
	{
		include_once PACKAGE_PATH . 'PHPMailer/PHPMailerAutoload.php';
	}

	function build_header()
	{
		global $system, $CHARSET;

		$headers = array();

		if (!isset($this->from) || empty($this->from))
		{
			$this->from = $system->SETTINGS['adminmail'];
		}

		$headers[] = 'From: ' . $this->from;
		$headers[] = 'Reply-To: ' . $this->from;
		$headers[] = 'Return-Path: <' . $this->from . '>';
		$headers[] = 'Sender: <' . $system->SETTINGS['adminmail'] . '>';
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Date: ' . date('r');
		//$headers[] = 'Content-Type: text/plain; charset=' . $CHARSET;
		$headers[] = 'Content-Type: text/html; charset=' . $CHARSET;
		$headers[] = 'Content-Transfer-Encoding: 8bit';

		$this->headers = implode("\n", $headers);
	}

	function buildmessage($file)
	{
		$buffer = file(MAIN_PATH . 'language/' . $this->getuserlang() . '/emails/' . $this->getusermailtype() . '/' . $file);
		$i = 0;
		$j = 0;
		while ($i < count($buffer))
		{
			if (!preg_match('/^#(.)*$/', $buffer[$i]))
			{
				$skipped_buffer[$j] = $buffer[$i];
				$j++;
			}
			$i++;
		}
		$this->message = implode($skipped_buffer, '');
		$this->message = str_replace("'", "\'", $this->message);

		$this->message = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . ((isset(\$this->vars['\\1'])) ? \$this->vars['\\1'] : '') . '", $this->message);

		preg_match_all('#<!-- ([^<].*?) (.*?)? ?-->#', $this->message, $blocks, PREG_SET_ORDER);

		$text_blocks = preg_split('#<!-- [^<].*? (?:.*?)? ?-->#', $this->message);

		$compile_blocks = array();
		for ($curr_tb = 0, $tb_size = sizeof($blocks); $curr_tb < $tb_size; $curr_tb++)
		{
			$block_val = &$blocks[$curr_tb];

			switch ($block_val[1])
			{
				case 'IF':
					$compile_blocks[] = "'; " . $this->compile_tag_if (str_replace("\'", "'", $block_val[2]), false) . " \$this->message .= '";
				break;

				case 'ELSE':
					$compile_blocks[] = "'; } else { \$this->message .= '";
				break;

				case 'ELSEIF':
					$compile_blocks[] = "'; " . $this->compile_tag_if (str_replace("\'", "'", $block_val[2]), true) . " \$this->message .= '";
				break;

				case 'ENDIF':
					$compile_blocks[] = "'; } \$this->message .= '";
				break;
			}
		}

		$template_php = '';
		for ($i = 0, $size = sizeof($text_blocks); $i < $size; $i++)
		{
			$trim_check_text = trim($text_blocks[$i]);
			$template_php .= (($trim_check_text != '') ? $text_blocks[$i] : '') . ((isset($compile_blocks[$i])) ? $compile_blocks[$i] : '');
		}

		eval("\$this->message = '$template_php';");
	}

	function compile_tag_if ($tag_args, $elseif)
	{
		// Tokenize args for 'if' tag.
		preg_match_all('/(?:
			"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"		 |
			\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'	 |
			[(),]								  |
			[^\s(),]+)/x', $tag_args, $match);

		$tokens = $match[0];
		$is_arg_stack = array();

		for ($i = 0, $size = sizeof($tokens); $i < $size; $i++)
		{
			$token = &$tokens[$i];

			switch ($token)
			{
				case '!==':
				case '===':
				case '<<':
				case '>>':
				case '|':
				case '^':
				case '&':
				case '~':
				case ')':
				case ',':
				case '+':
				case '-':
				case '*':
				case '/':
				case '@':
				break;

				case '==':
				case 'eq':
					$token = '==';
				break;

				case '!=':
				case '<>':
				case 'ne':
				case 'neq':
					$token = '!=';
				break;

				case '<':
				case 'lt':
					$token = '<';
				break;

				case '<=':
				case 'le':
				case 'lte':
					$token = '<=';
				break;

				case '>':
				case 'gt':
					$token = '>';
				break;

				case '>=':
				case 'ge':
				case 'gte':
					$token = '>=';
				break;

				case '&&':
				case 'and':
					$token = '&&';
				break;

				case '||':
				case 'or':
					$token = '||';
				break;

				case '!':
				case 'not':
					$token = '!';
				break;

				case '%':
				case 'mod':
					$token = '%';
				break;

				case '(':
					array_push($is_arg_stack, $i);
				break;

				case 'is':
					$is_arg_start = ($tokens[$i-1] == ')') ? array_pop($is_arg_stack) : $i-1;
					$is_arg	= implode('	', array_slice($tokens,	$is_arg_start, $i -	$is_arg_start));

					$new_tokens	= $this->_parse_is_expr($is_arg, array_slice($tokens, $i+1));

					array_splice($tokens, $is_arg_start, sizeof($tokens), $new_tokens);

					$i = $is_arg_start;

				// no break

				default:
					if (preg_match('#^((?:[a-z0-9\-_]+\.)+)?(\$)?(?=[A-Z])([A-Z0-9\-_]+)#s', $token, $varrefs))
					{
						$token = (!empty($varrefs[1])) ? $this->generate_block_data_ref(substr($varrefs[1], 0, -1), true, $varrefs[2]) . '[\'' . $varrefs[3] . '\']' : (($varrefs[2]) ? '$this->vars[\'DEFINE\'][\'.\'][\'' . $varrefs[3] . '\']' : '$this->vars[\'' . $varrefs[3] . '\']');
					}
					elseif (preg_match('#^\.((?:[a-z0-9\-_]+\.?)+)$#s', $token, $varrefs))
					{
						// Allow checking if loops are set with .loopname
						// It is also possible to check the loop count by doing <!-- IF .loopname > 1 --> for example
						$blocks = explode('.', $varrefs[1]);

						// If the block is nested, we have a reference that we can grab.
						// If the block is not nested, we just go and grab the block from _tpldata
						if (sizeof($blocks) > 1)
						{
							$block = array_pop($blocks);
							$namespace = implode('.', $blocks);
							$varref = $this->generate_block_data_ref($namespace, true);

							// Add the block reference for the last child.
							$varref .= "['" . $block . "']";
						}
						else
						{
							$varref = '$this->_tpldata';

							// Add the block reference for the last child.
							$varref .= "['" . $blocks[0] . "']";
						}
						$token = "sizeof($varref)";
					}
					elseif (!empty($token))
					{
						$token = '(' . $token . ')';
					}

				break;
			}
		}

		// If there are no valid tokens left or only control/compare characters left, we do skip this statement
		if (!sizeof($tokens) || str_replace(array(' ', '=', '!', '<', '>', '&', '|', '%', '(', ')'), '', implode('', $tokens)) == '')
		{
			$tokens = array('false');
		}
		return (($elseif) ? '} else if (' : 'if (') . (implode(' ', $tokens) . ') { ');
	}

	function generate_block_data_ref($blockname, $include_last_iterator, $defop = false)
	{
		// Get an array of the blocks involved.
		$blocks = explode('.', $blockname);
		$blockcount = sizeof($blocks) - 1;

		// DEFINE is not an element of any referenced variable, we must use _tpldata to access it
		if ($defop)
		{
			$varref = '$this->_tpldata[\'DEFINE\']';
			// Build up the string with everything but the last child.
			for ($i = 0; $i < $blockcount; $i++)
			{
				$varref .= "['" . $blocks[$i] . "'][\$_" . $blocks[$i] . '_i]';
			}
			// Add the block reference for the last child.
			$varref .= "['" . $blocks[$blockcount] . "']";
			// Add the iterator for the last child if requried.
			if ($include_last_iterator)
			{
				$varref .= '[$_' . $blocks[$blockcount] . '_i]';
			}
			return $varref;
		}
		else if ($include_last_iterator)
		{
			return '$_'. $blocks[$blockcount] . '_val';
		}
		else
		{
			return '$_'. $blocks[$blockcount - 1] . '_val[\''. $blocks[$blockcount]. '\']';
		}
	}

	function assign_vars($vars)
	{
		$this->vars = (empty($this->vars)) ? $vars : $this->vars + $vars;
	}

	function getuserlang()
	{
		global $system, $DBPrefix, $language, $db;

		if (isset($this->email_uid) && $this->email_uid > 0)
		{
			// Retrieve user's prefered language
			$query = "SELECT language FROM " . $DBPrefix . "users WHERE id = :user_id";
			$params = array();
			$params[] = array(':user_id', $this->email_uid, 'int');
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$USERLANG = $db->result('language');
				if (isset($USERLANG) && !empty($USERLANG)) return $USERLANG;
			}
		}
		elseif(isset($this->userlang))
		{
			$language = $this->userlang;
		}

		return $language;
	}

	function getusermailtype()
	{
		global $system, $DBPrefix, $db;

		if (isset($this->email_uid) && $this->email_uid > 0)
		{
			// Retrieve user's prefered language
			$query = "SELECT emailtype FROM " . $DBPrefix . "users WHERE id = :user_id";
			$params = array();
			$params[] = array(':user_id', $this->email_uid, 'int');
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$emailtype = $db->result('emailtype');
				if (isset($emailtype) && !empty($emailtype)) return $emailtype;
			}
		}

		return 'html';
	}

	function add_error($error)
	{
		array_push($this->errors, $error);
	}

	function sendmail()
	{
		global $CHARSET, $system;
		$this->errors = array();
		// from has not been set send email via admin
		if (!isset($this->from) || empty($this->from))
		{
			$this->from = $system->SETTINGS['adminmail'];
		}

		// if sending to admin, send to all linked admin emails
		if ($system->SETTINGS['adminmail'] == $this->to)
		{
			$emails = array_filter(explode(',', $system->SETTINGS['alert_emails']));

			if (!empty($emails))
			{
				if (!is_array($this->to))
				{
					$to_start = $this->to;
					$this->to = array();
					$this->to[] = $to_start;
				}
				foreach ($emails as $email)
				{
					if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email))
					{
						$this->to[] = $email;
					}
				}
			}
		}

		// deal with sending the emails
		switch ($system->SETTINGS['mail_protocol'])
		{
			case '5':
				$mail = new PHPMailer(true);
				$mail->isQmail();
			break;
			case '4':
				$mail = new PHPMailer(true);
				$mail->isSendmail();
			break;
			case '3':
				// do not send email
				return 'No email sent. You have selected to disable all emails';
			break;
			case '2':
				$mail = new PHPMailer(true);
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = $system->SETTINGS['smtp_host'];
				$mail->Port = (integer)$system->SETTINGS['smtp_port'];
				if ($system->SETTINGS['smtp_security'] != 'none')
				{
					$mail->SMTPSecure = strtolower($system->SETTINGS['smtp_security']);
				}
				if ($system->SETTINGS['smtp_authentication'] == 'y')
				{
					$mail->SMTPAuth = true;
					$mail->Username = $system->SETTINGS['smtp_username'];
					$mail->Password = $system->SETTINGS['smtp_password'];
				}
				else
				{
					$mail->SMTPAuth = false;
				}
			break;
			case '1':
				$mail = new PHPMailer(true);
				$mail->isMail();
			break;
			default: // just use php mail function
				if (is_array($this->to))
				{
					for ($i = 0; $i < count($this->to); $i++)
					{
						if (!empty($system->SETTINGS['mail_parameter']))
							$sent = mail($this->to[$i], $this->subject, $this->message, $this->headers, $system->SETTINGS['mail_parameter']);
						else
							$sent = mail($this->to[$i], $this->subject, $this->message, $this->headers);
					}
				}
				else
				{
					if (!empty($system->SETTINGS['mail_parameter']))
						$sent = mail($this->to, $this->subject, $this->message, $this->headers, $system->SETTINGS['mail_parameter']);
					else
						$sent = mail($this->to, $this->subject, $this->message, $this->headers);
				}
				if ($sent)
					return false;
				else
					return true;
			break;
		}

		if (is_array($this->to))
		{
			for ($i = 0; $i < count($this->to); $i++)
			{
				try {
					$mail->setFrom($this->from, $system->SETTINGS['adminmail']);
					$mail->addAddress($this->to[$i]);
					$mail->addReplyTo($this->from, $system->SETTINGS['adminmail']);
					$mail->Subject = $this->subject;
					$mail->msgHTML($this->message);
					//$mail->addAttachment('images/phpmailer_mini.png');
					$mail->CharSet = $CHARSET;
					$mail->Send();
				}
				catch (phpmailerException $e)
				{
					trigger_error('---->PHPMailer error: ' . $e->errorMessage());
					$this->add_error($e->errorMessage());
				}
				catch (Exception $e)
				{
					trigger_error('---->PHPMailer error2: ' . $e->getMessage());
					$this->add_error($e->getMessage());
				}
				$mail->clearAddresses();
			}
		}
		else
		{
			try {
				$mail->setFrom($this->from, $system->SETTINGS['adminmail']);
				if (is_array($this->to))
				{
					for ($i = 0; $i < count($this->to); $i++)
					{
						$mail->addAddress($this->to[$i]);
					}
				}
				else
				{
					$mail->addAddress($this->to);
				}
				$mail->addReplyTo($this->from, $system->SETTINGS['adminmail']);
				$mail->Subject = $this->subject;
				$mail->msgHTML($this->message);
				$mail->CharSet = $CHARSET;
				$mail->Send();
			}
			catch (phpmailerException $e)
			{
				trigger_error('---->PHPMailer error: ' . $e->errorMessage());
				$this->add_error($e->errorMessage());
			}
			catch (Exception $e)
			{
				trigger_error('---->PHPMailer error: ' . $e->getMessage());
				$this->add_error($e->getMessage());
			}
		}
		return implode('<br/>', $this->errors);
	}

	function email_basic($subject, $to, $message, $from = '')
	{
		$this->to = $to;
		$this->subject = $subject;
		$this->from = $from;
		$this->message = $message;
		$this->build_header();
		$this->sendmail();
	}

	function email_sender($to, $file, $subject)
	{
		$this->to = $to;
		$this->subject = $subject;
		$this->build_header();
		$this->buildmessage($file);
		$this->sendmail();
	}
}
