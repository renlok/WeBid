#
# --Send Auction to a Friend e-mail file
# 
# 			This file contains the message your customers
# 			will receive when someone sends them an auction.
#			Lines starting with # will be skipped.
#			Blank lines will be maintained.
#
#			Change the message below as needed considering the 
#			following tags to reflect your customer's personal data:
#
#        --------------------------------------------------------
#			TAG SYNTAX				EFFECT
#        --------------------------------------------------------
#
#			{S_NAME}				sendername 
#			{S_EMAIL}				sender email 
#			{S_COMMENT}				sender comment 
#			{F_NAME}				friend name
#			{TITLE}             	auction item title 
#			{URL}               	URL to view auction 
#           {SITENAME}          	Auction Site Name
#           {SITEURL}           	main URL of auction site
#           {ADMINEMAIL}        	email address of Auction site webmaster
#        --------------------------------------------------------
#
#			USAGE:
#			Insert the above tags in the text of your message			
#			where you want each value to appear.			
#			Modify the message to reflect your needs.
#			Change [...] with to your correct data.
#
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
		<td colspan="2" height="35"><div style="font-size: 14px; font-weight: bold;">Someone wants you to view an auction at {SITENAME}!</div></td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 12px;">Hello <b>{F_NAME}</b>,</td>
	</tr>
	<tr>
		<td colspan="2" height="50" style="font-size: 12px; padding-right: 6px;">
		 You have been forwarded an auction from {S_NAME} (<a href="mailto:{S_EMAIL}">{S_EMAIL}</a>) at {SITENAME}
		</td>
	</tr>
	<tr>
		<td width="55%" rowspan="2" valign="top" style="font-size: 12px; line-height: 0.6cm;">
            <b>Auction Title:</b> 	{TITLE} <br />
            <b>Comments:</b> {S_COMMENT}<br />
		</td>
		<td width="34%" style="font-size: 12px;">Check Out The Auction!</td>
	</tr>
	<tr>
		<td width="34%" height="176" valign="top">
		<a href="{URL}"><img src="{SITEURL}images/email_alerts/Take_Me_There.jpg" border="0"></a>
		</td>
	</tr>
 </table>
</body>
</html>