#
# --Confirmation e-mail file
# 
# 			This file contains the message your customers
# 			will receive as a confirmation for the posted
#			auction.
#			Lines starting with # will be skipped.
#			Blank lines will be maintained.
#
#			Change the message below as needed using the 
#			following tags to reflect your customer's personal data:
#
#        --------------------------------------------------------
#			TAG SYNTAX				EFFECT
#        --------------------------------------------------------
#
#			<#c_name#>				customer name
#			<#c_nick#>				nick
#			<#c_email#> 			e-mail address
#			<#c_address#> 			street address
#			<#c_city#>   			city
#			<#c_country#> 			country
#			<#c_zip#> 			    zip
#			<#a_title#>				auction title
#			<#a_id#>				auction ID
#			<#a_description#>		description
#			<#a_picturl#>			picture url
#			<#a_minbid#>   			minimum bid
#			<#a_resprice#>			reserve price (if set)
#			<#a_duration#>			duration (in days)
#			<#a_location#>			item location
#			<#a_zip#>				item location zip
#			<#a_shipping#>			shipping terms
#			<#c_type#>   			auction type
#			<#c_qty#>   			auction type
#			<#a_intern#>			international shipping terms
#										. will ship internationally
#										. will NOT ship internationally
#			<#a_payment#>			selected payment methods (one per line)
#			<#a_ends#>				closing date and time
#			<#a_url#>				the URL of the page
#           <#c_sitename#>          site name
#           <#c_siteurl#>           site URL
#           <#c_adminemail#>        site administrator email address
#        --------------------------------------------------------
#
#			USAGE:
#			Insert the above tags in the text of your message			
#			where you want each value to appear.			
#			Modify the message to reflect your needs.
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
		<td colspan="3" height="35"><div style="font-size: 14px; font-weight: bold;">Your item has been listed on <#c_sitename#>!</div></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 12px;">Hello <b><#c_name#></b>,</td>
	</tr>
	<tr>
		<td colspan="3" height="50" style="font-size: 12px; padding-right: 6px;">Your item has been successfully listed on <#c_sitename#>. The item will display instantly in search results.<br>Here are the listing details:</td>
	</tr>
	<tr>
		<td width="9%" rowspan="2"><img border="0" src="<#a_picturl#>"></td>
		<td width="55%" rowspan="2">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" style="font-size: 12px;"><a href="<#a_url#>"><#a_title#></a></td>

			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Auction type:</td>
				<td align="left" style="font-size: 12px;"><#a_type#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Item #:</td>
				<td align="left" style="font-size: 12px;"><#a_id#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Starting bid:</td>
				<td align="left" style="font-size: 12px;"><#a_minbid#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Reserve price:</td>
				<td align="left" style="font-size: 12px;"><#a_resprice#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">Buy Now price:</td>
				<td align="left" style="font-size: 12px;"><#a_buynowprice#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;">End time:</td>
				<td align="left" style="font-size: 12px;"><#a_ends#></td>
			</tr>
			<tr>
				<td width="22%" style="font-size: 12px;"></td>
				<td align="left" style="font-size: 12px;"><a href="<#c_siteurl#>user_menu.php?">Goto My <#c_sitename#></a></td>
			</tr>
		</table>
		</td>
		<td width="34%" style="font-size: 12px;">Have another item to list?</td>
	</tr>
	<tr>
		<td width="34%" height="176" valign="top">
		<a href="<#c_siteurl#>select_category.php?">
		<img border="0" src="<#c_siteurl#>images/email_alerts/Sell_More_Btn.jpg" width="120" height="32"></a></td>
	</tr>
 </table>
</body>
</html>