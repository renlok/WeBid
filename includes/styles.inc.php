<?php
$thisstyle = '<style type="text/css">';
$sty= 'font-family:' . $FONTS[$system->SETTINGS['err_font']] . ';font-size:' . $FONTSIZE[$system->SETTINGS['err_font_size']] . ';color:' . $system->SETTINGS['err_font_color'] . ';';
if ($system->SETTINGS['err_font_bold'] == 'y')
{
	$sty  .= 'font-weight: bold;';
}
if ($system->SETTINGS['err_font_italic'] == 'y')
{
	$sty .= 'font-style: italic;';
}
$thisstyle .= '.errfont {' . $sty . '}' . "\r\n";

$sty= 'font-family:' . $FONTS[$system->SETTINGS['sml_font']] . ';font-size:' . $FONTSIZE[$system->SETTINGS['sml_font_size']] . ';color:' . $system->SETTINGS['sml_font_color'] . ';';
if ($system->SETTINGS['sml_font_bold'] == 'y')
{
	$sty .= 'font-weight: bold;';
}
if ($system->SETTINGS['sml_font_italic'] == 'y')
{
	$sty .= 'font-style: italic;';
}
$thisstyle .= '.smlfont {' . $sty . '}' . "\r\n";

$sty= 'font-family:' . $FONTS[$system->SETTINGS['std_font']] . ';font-size:' . $FONTSIZE[$system->SETTINGS['std_font_size']] . ';color:' . $system->SETTINGS['std_font_color'];
if ($system->SETTINGS['std_font_bold'] == 'y')
{
	$sty .= 'font-weight: bold;';
}
if ($system->SETTINGS['std_font_italic'] == 'y')
{
	$sty .= 'font-style: italic;';
}
$thisstyle .= '.stdfont {' . $sty . '}' . "\r\n";

$thisstyle .= 'body {' . (($system->SETTINGS['background'] && $system->SETTINGS['brepeat']!='no') ? ' background:url(' . $system->SETTINGS['logo'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['background'] . ');background-repeat:' . $system->SETTINGS['brepeat'] . ';':'') . $sty . '}' . "\r\n";

$thisstyle .= '#container{ width:' . $system->SETTINGS['pagewidth'] . ($system->SETTINGS['pagewidthtype']=='perc' ? '%':'px') . ';background-color:' . $system->SETTINGS['bordercolor'] . '}' . "\r\n";

$sty= 'font-family:' . $FONTS[$system->SETTINGS['footer_font']] . ';font-size:' . $FONTSIZE[$system->SETTINGS['footer_font_size']] . ';color:' . $system->SETTINGS['footer_font_color'] . ';';
if ($system->SETTINGS['footer_font_bold'] == 'y')
{
	$sty .= 'font-weight: bold;';
}
if ($system->SETTINGS['footer_font_italic'] == 'y')
{
	$sty .= 'font-style: italic;';
}
$thisstyle .= '.footerfont {' . $sty . '}' . "\r\n";

$thisstyle .= '#footer	{ padding: 5px 5px 5px 5px; text-align: center;' . $sty . ' }' . "\r\n";

$sty = 'font-family:' . $FONTS[$system->SETTINGS['tlt_font']] . ';font-size:' . $FONTSIZE[$system->SETTINGS['tlt_font_size']] . ';color:' . $system->SETTINGS['tlt_font_color'] . ';';
if ($system->SETTINGS['tlt_font_bold'] == 'y')
{
	$sty .= 'font-weight: bold;';
}
if ($system->SETTINGS['tlt_font_italic'] == 'y')
{
	$sty .= 'font-style: italic;';
}
$thisstyle .= '.tltfont {' . $sty . '}' . "\r\n";	

$thisstyle .= '.titTable2 {' . $sty . ';border-color:' . $system->SETTINGS['tlt_font_color'] . ' }' . "\r\n";

$sty= 'font-family:' . $FONTS[$system->SETTINGS['nav_font']] . ';font-size:' . $FONTSIZE[$system->SETTINGS['nav_font_size']] . ';color:' . $system->SETTINGS['nav_font_color'] . ';';
if ($system->SETTINGS['nav_font_bold'] == 'y')
{
	$sty .= 'font-weight: bold;';
}
if ($system->SETTINGS['nav_font_italic'] == 'y')
{
	$sty .= 'font-style: italic;';
}
$thisstyle .= '.navfont {' . $sty . '}' . "\r\n";	

$thisstyle .= 'th {background-color : ' . $system->SETTINGS['tableheadercolor'] . ';}' . "\r\n";

$thisstyle .= '#barSec {background-color : ' . $system->SETTINGS['tableheadercolor'] . ';}' . "\r\n";

$thisstyle .= '.titTable1 {background-color : ' . $system->SETTINGS['tableheadercolor'] . ';}' . "\r\n";

$thisstyle .= 'a:link,a:visited {color : ' . $system->SETTINGS['linkscolor'] . ';}
</style>';
?>