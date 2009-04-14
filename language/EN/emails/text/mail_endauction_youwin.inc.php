#
# --Send winner notification
# 
# 			This file contains the message your customers
# 			will receive when someone sends them an auction.
#			Lines starting with # will be skipped.
#			Blank lines will be maintained.
#
#			Change the message below as needed considering the 
#			following tags to reflect your customer's personal data:
#
#		--------------------------------------------------------
#			TAG SYNTAX				EFFECT
#		--------------------------------------------------------
#
#			<#w_name#>			  Winner Name
#			<#w_nick#>			  Winner Nickname
#			<#s_name#>			  Seller Name
#			<#s_nick#>			  Seller Nickname
#			<#s_email#>			 Seller email
#			<#s_address#>		   Seller Address
#			<#s_city#>			  Seller City
#			<#s_prov#>			  Seller State/Province
#			<#s_country#>		   Seller Country
#			<#s_zip#>			   Seller Zip Code
#			<#s_phone#>			 Seller Phone
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
#

Dear <#w_name#>,<br>
<br>
You have won the following auction on <a href="<#c_sitename#>"><#c_sitename#></a> <br>
<br>
Auction data<br>
------------------------------------<br>
Title: <#i_title#><br>
Description: <#i_description#><br>
<br>
Your bid: <#i_currentbid#> (<#i_wanted> items)<br>
You got: <#i_got> items<br>
Auction End Date: <#i_ends#><br>
URL: <a href="<#c_siteurl#><#i_url#>"><#c_siteurl#><#i_url#></a><br>
<br>
=============<br>
SELLER'S INFO<br>
=============<br>
<br>
<#s_nick#><br>
<a href="mailto:<#s_email#>"><#s_email#></a><br>
Seller's payment details:<br>
<#s_payment#><br>		 
<br>
<br>
If you have received this message in error, please reply to this email,<br>
write to <a href="mailto:<#c_adminemail#>"><#c_adminemail#></a>, or visit <a href="<#c_sitename#>"><#c_sitename#></a> at <a href="<#c_siteurl#>"><#c_siteurl#></a>.
