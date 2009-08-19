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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
function ChooseColor(val,what,T)
{
	what.value = val;
}
</script>
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td background="images/bac_barint.gif">
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="30"><img src="images/i_gra.gif"></td>
					<td class=white><?php echo $MSG['25_0009']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5002']; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
				<tr>
					<td align="center"> <br>
						<form name=conf action="" method=POST>
							<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
								<tr>
									<td align=CENTER class=title><?php print $MSG['5002']; ?></td>
								</tr>
								<tr>
									<td>
										<table width=100% cellspacing=1 cellpadding=2 align="CENTER" bgcolor="#ffffff">
											<tr>
											<td COLSPAN=2>
												<?php echo $MSG['30_0011']; ?><br>
												<b><?php echo $MSG['30_0010']; ?></b>(<CODE><?php echo "themes/".$system->SETTINGS['theme']."/style.css"; ?></CODE>)
											</td>
											</tr>
											<tr valign="TOP">
												<td bgcolor="#eeeeee">
													<h3><?php echo $MSG['586']; ?></h3>
													<?php echo $MSG['587']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.container&from=colors.php&color=border><?php echo $MSG['30_0012']; ?></A>
												</td>
												<td bgcolor="#eeeeee">
													<h3><?php echo $MSG['30_0013']; ?></h3>
													<?php echo $MSG['30_0014']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.titTable1&from=colors.php&color=tittable><?php echo $MSG['30_0015']; ?></A>
												</td>
											</tr>
											<tr valign="TOP">
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['30_0016']; ?></h3>
													<?php echo  $MSG['30_0017']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.hg&from=colors.php&color=hg><?php echo $MSG['30_0018']; ?></A>
												</td>
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['595']; ?></h3>
													<?php echo  $MSG['30_0019']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=a:link&from=colors.php&color=a:link><?php echo $MSG['30_0020']; ?></A>
												</td>
											</tr>
											<tr valign="TOP">
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['596']; ?></h3>
													<?php echo  $MSG['30_0021']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=a:visited&from=colors.php&color=a:visited><?php echo $MSG['30_0022']; ?></A>
												</td>
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['30_0023']; ?></h3>
													<?php echo  $MSG['30_0024']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=body&from=colors.php&color=body><?php echo $MSG['30_0025']; ?></A>
												</td>
											</tr>
											<tr valign="TOP">
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['30_0026']; ?></h3>
													<?php echo  $MSG['30_0027']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.container&from=colors.php&color=container><?php echo $MSG['30_0028']; ?></A>
												</td>
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['30_0187']; ?></h3>
													<?php echo  $MSG['30_0188']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.navbar&from=colors.php&color=container><?php echo $MSG['30_0189']; ?></A>
												</td>
											</tr>
											<tr valign="TOP">
												<td bgcolor="#eeeeee">
													<h3><?php echo  $MSG['30_0191']; ?></h3>
													<?php echo  $MSG['30_0192']; ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.titTable5&from=colors.php&color=tittable><?php echo $MSG['30_0193']; ?></A>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
