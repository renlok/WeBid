<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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

unset($ERR);

$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);
$DISPLAYED_FIELDS = unserialize($system->SETTINGS['displayed_feilds']);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$MANDATORY_FIELDS = array(
			'birthdate' => $_POST['birthdate'],
			'address' => $_POST['address'],
			'city' => $_POST['city'],
			'prov' => $_POST['prov'],
			'country' => $_POST['country'],
			'zip' => $_POST['zip'],
			'tel' => $_POST['tel']
			);
			
	$DISPLAYED_FIELDS = array(
			'birthdate_regshow' => $_POST['birthdate_regshow'],
			'address_regshow' => $_POST['address_regshow'],
			'city_regshow' => $_POST['city_regshow'],
			'prov_regshow' => $_POST['prov_regshow'],
			'country_regshow' => $_POST['country_regshow'],
			'zip_regshow' => $_POST['zip_regshow'],
			'tel_regshow' => $_POST['tel_regshow']
			);

	$mdata = serialize($MANDATORY_FIELDS);
	$sdata = serialize($DISPLAYED_FIELDS);
	$query = "UPDATE ".$DBPrefix."settings SET mandatory_fields = '" . $mdata . "', displayed_feilds = '" . $sdata . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

	$ERR = "User Registration Fields Updated!";
}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td background="images/bac_barint.gif">
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="30"><img src="images/i_use.gif" width="19" height="19"></td>
					<td class=white>Users&nbsp;&gt;&gt;&nbsp;User Registration Fields</td>
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
					<td align="center">
						<form name=conf action="" method="POST"  enctype="multipart/form-data">
							<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
								<tr>
									<td align=CENTER class=title>User Registration Fields</td>
								</tr>
								<tr>
									<td>
										<table width=100% border=0 cellpadding=2 align="CENTER" bgcolor="#FFFFFF">
											<?php
											if ($ERR != "") {
											?>
											<tr>
												<td colspan="2" align=CENTER bgcolor="yellow"><b><?php print $ERR; ?> </b></td>
											</tr>
											<?php
											}
											?>
											<tr valign="TOP">
												<td colspan="2"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
												<td width=25%>Birthday Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
												<td width=75%>
													 
												  					 Yes<input type="radio" name="birthdate" value="y"
					 																			<?php if ($MANDATORY_FIELDS['birthdate'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="birthdate" value="n"
					 																			<?php if ($MANDATORY_FIELDS['birthdate'] == 'n') print " CHECKED";?>><br /><br />
					 																			
													  					 Yes<input type="radio" name="birthdate_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['birthdate_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="birthdate_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['birthdate_regshow'] == 2) print " CHECKED";?>>				 															
												</td>
											</tr>
											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
												<td width=25%>Address Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
												<td width=75%>
														
												  					 Yes<input type="radio" name="address" value="y"
					 																			<?php if ($MANDATORY_FIELDS['address'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="address" value="n"
					 																			<?php if ($MANDATORY_FIELDS['address'] == 'n') print " CHECKED";?>><br /><br />

													  					 Yes<input type="radio" name="address_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['address_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="address_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['address_regshow'] == 2) print " CHECKED";?>>																										
												</td>
											</tr>
											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
												<td width=25%>City Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
												 <td width=75%>
												 
											   Yes<input type="radio" name="city" value="y"
					 																			<?php if ($MANDATORY_FIELDS['city'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="city" value="n"
					 																			<?php if ($MANDATORY_FIELDS['city'] == 'n') print " CHECKED";?>><br /><br />
					 	
					 													   Yes<input type="radio" name="city_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['city_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="city_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['city_regshow'] == 2) print " CHECKED";?>>																			
												</td>
											</tr>
											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
											  <td width=25%>State Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
											  <td width=75%>
													
											   Yes<input type="radio" name="prov" value="y"
					 																			<?php if ($MANDATORY_FIELDS['prov'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="prov" value="n"
					 																			<?php if ($MANDATORY_FIELDS['prov'] == 'n') print " CHECKED";?>><br /><br />
																									  
		 													   Yes<input type="radio" name="prov_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['prov_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="prov_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['prov_regshow'] == 2) print " CHECKED";?>>										  
												</td>
											</tr>
											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
											  <td width=25%>Country Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
											  <td width=75%>
													
											   Yes<input type="radio" name="country" value="y"
					 																			<?php if ($MANDATORY_FIELDS['country'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="country" value="n"
					 																			<?php if ($MANDATORY_FIELDS['country'] == 'n') print " CHECKED";?>><br /><br />
																									  
		 													   Yes<input type="radio" name="country_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['country_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="country_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['country_regshow'] == 2) print " CHECKED";?>>										  
												</td>
											</tr>
											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
												<td width=25%>Zip Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
												 <td width=75%>

											   Yes<input type="radio" name="zip" value="y"
					 																			<?php if ($MANDATORY_FIELDS['zip'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="zip" value="n"
					 																			<?php if ($MANDATORY_FIELDS['zip'] == 'n') print " CHECKED";?>><br /><br />

		 													   Yes<input type="radio" name="zip_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['zip_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="zip_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['zip_regshow'] == 2) print " CHECKED";?>>	 
					 																			
												</td>
											</tr>
											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>
											<tr valign="TOP">
												<td width=25%>Telephone Field <b>Required</b><br /><br /><br />Show On Registration Page</td>
												 <td width=75%>

											   Yes<input type="radio" name="tel" value="y"
					 																			<?php if ($MANDATORY_FIELDS['tel'] == 'y') print " CHECKED";?>>				 
						  										 No <input type="radio" name="tel" value="n"
					 																			<?php if ($MANDATORY_FIELDS['tel'] == 'n') print " CHECKED";?>><br /><br />

		 													   Yes<input type="radio" name="tel_regshow" value="1"
					 																			<?php if ($DISPLAYED_FIELDS['tel_regshow'] == 1) print " CHECKED";?>>				 
						  										 No <input type="radio" name="tel_regshow" value="2"
					 																			<?php if ($DISPLAYED_FIELDS['tel_regshow'] == 2) print " CHECKED";?>>	 				 																			
												</td>
											</tr>

											<tr valign="TOP">
												<td colspan="2" bgcolor="eeeeee"><img src="../images/transparent.gif" width="1" height="5"></td>
											</tr>

											<tr>
												<td width=25%>
													<input type="hidden" name="action" value="update">
												</td>
												<td width=75%><br />
													<input type="submit" name="act" value="<?php print $MSG['530']; ?>">
												</td>
											</tr>
											<tr>
												<td width=25%></td>
												<td width=75%> </td>
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