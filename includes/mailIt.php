<?php
if(!defined('InWeBid')) exit();
/*
* Param $htmltosend: si mette dell'html completo di head e body
* Param $emailto: a chi si manda
* Param $emailfrom: mittente
* Param $emailsubj: subject
* Param $emailsubj: attachment: il contenuto dell'attachment da inviare
*/
function mailIt($htmltosend,$emailto='',$emailfrom='',$emailsubj='',$attachment='') {
	global $system;
	include_once('class.smtp.inc');
    include_once('class.html.mime.mail.inc');
    include_once('mimePart.php');
    define('CRLF', "\r\n", TRUE);
    $mail = new html_mime_mail(array('X-Mailer: Html Mime Mail Class'));
    if($attachment!='') {
       $mail->add_attachment($attachment, 'ordine.csv', 'application/csv'); //metti un nome e un mime type a piacimento, secondo quel che vuoi
    }
    $mail->add_html($htmltosend,$emailsubj);
    if(!$mail->build_message())
        exit('Failed to build email');
    $params = array(   								//qua i tuoi indirizzi
                    'host' => '65.125.231.122',    // Mail server address
                    'port' => 25,                // Mail server port
                    'helo' => 'localhost',    // Use your domain here.
                    'auth' => FALSE,            // Whether to use authentication or not.
                    'user' => '',                // Authentication username
                    'pass' => ''                // Authentication password
                   );
    $smtp =& smtp::connect($params);
    $send_params = array(
                       'from'          => $emailfrom,            
                       'recipients'    => array($emailto), 
                       'headers'       => array(   'From: '.$system->SETTINGS['sitename'].' <'.$emailfrom.'>',
                                                   'To: '.$emailto.'',
                                                   'Subject: '.$emailsubj
                                               )
                        );
    $mail->smtp_send($smtp, $send_params);
}
?>
