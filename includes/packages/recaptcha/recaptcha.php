<?php
/***************************************************************************
 *   copyright          : (C) 2008 - 2017 WeBid
 *   site               : http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include PACKAGE_PATH . 'recaptcha/autoload.php';

// Wrapper function for recaptcha HTML
function recaptcha_get_html($pubkey)
{
	if ($pubkey == null || $pubkey == '')
	{
		die ('To use reCAPTCHA you must get an API key from <a href="https://www.google.com/recaptcha/intro/index.html">https://www.google.com/recaptcha/intro/index.html</a>');
	}

	return '<div align="center"><script src="https://www.google.com/recaptcha/api.js" async defer></script><div class="g-recaptcha" data-sitekey="' . $pubkey . '"></div></div>';
}

// Wrapper function for recaptcha check
function recaptcha_check_answer($privkey, $challenge)
{
	if ($privkey == null || $privkey == '')
	{
		die ('To use reCAPTCHA you must get an API key from <a href="https://www.google.com/recaptcha/intro/index.html">https://www.google.com/recaptcha/intro/index.html</a>');
	}

	$recaptcha = new \ReCaptcha\ReCaptcha($privkey);
	$response = $recaptcha->verify($challenge);
	return $response->isSuccess();
}