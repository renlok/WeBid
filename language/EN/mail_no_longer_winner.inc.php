#
# --Youve been outbid email language file
#
#			Change the message below as needed considering the 
#			following tags to reflect your customer's personal data:
#
#		--------------------------------------------------------
#			TAG SYNTAX				EFFECT
#		--------------------------------------------------------
#
#			<#o_name#>			  Old Winner Name (email goes to this person) 
#			<#o_nick#>			  Old Winner Nickname
#			<#o_email#>			 Old Winner email
#			<#o_bid#>			   Old Winner bid
#			<#n_bid#>			   New Winning Bid
#			<#i_title#>			 auction item title 
#			<#i_description#>	   auction item description 
#			<#i_url#>			   URL to view auction 
#			<#i_ends#>			  Auction End date/time
#		   <#c_sitename#>		  Auction Site Name
#		   <#c_siteurl#>		   main URL of auction site
#		   <#c_adminemail#>		email address of Auction site webmaster
#		--------------------------------------------------------
#
#			USAGE:
#			Insert the above tags in the text of your message			
#			where you want each value to appear.			
#			Modify the message to reflect your needs.
#			Change [...] with to your correct data.
#
#

<html>
 <head>
 	<style type="text/css">
 		body {
 		font-family: Verdana;
 		}
 	</style>
 </head>
 <body>
<table border="0" width="100%">
	<tr>
		<td colspan="3" height="35"><div style="font-size: 14px; font-weight: bold;">You have been outbid! Bid again now!</div></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 12px;">Hello <b><#o_name#></b>,</td>
	</tr>
	<tr>
		<td colspan="3" height="50" style="font-size: 12px; padding-right: 6px;">
			Your bid of <#o_bid#> is no longer the leading bid on the following:  
	  </td>
	</tr>
	<tr>
		<td width="9%" rowspan="2"><img border="0" src="<#a_picturl#>"></td>
		<td width="55%" rowspan="2">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" style="font-size: 12px;"><a href="<#c_siteurl#><#i_url#>"><#i_title#></a></td>

			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Current price:</td>
				<td align="left" style="font-size: 12px;"><#n_bid#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Old price:</td>
				<td align="left" style="font-size: 12px;"><#o_bid#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">End date:</td>
				<td align="left" style="font-size: 12px;"><#i_ends#></td>
			</tr>
			
			<tr>
				<td width="22%" style="font-size: 12px;"></td>
				<td align="left" style="font-size: 12px;"><a href="<#c_siteurl#>user_menu.php?">Goto My <#c_sitename#></a></td>
			</tr>
		</table>
		</td>
		<td width="34%" style="font-size: 12px;">&nbsp;</td>
	</tr>
	<tr>
		<td width="34%" height="110" valign="top"></td>
	</tr>
 </table>
 
  <table border="0" width="100%">
	<tr>
		<td style="font-size: 12px;" colspan="2"><b>Additional details for item: <#i_id#></b></td>
	</tr>
	<tr>
		<td style="font-size: 12px;" width="9%">Auction URL:</td>
		<td style="font-size: 12px;" width="91%"><a href="<#i_url#>"><#i_url#></a></td>
	</tr>
	<tr>
		<td style="font-size: 12px;" width="9%">Seller:</td>
		<td style="font-size: 12px;" width="91%"><#s_name#> - <a href="mailto:<#s_email#>"><#s_email#></a></td>
	</tr>
</table>
</body>
</html>
