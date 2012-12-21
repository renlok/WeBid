<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="ltr" lang="{LANGUAGE}"><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<title>{L_1042} {SALE_ID}</title>

<style type="text/css">
.pageHeading { font-family: Verdana, Arial, sans-serif; font-size: 18px; color: #727272; font-weight: bold; }
.pageHeading-invoice { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; font-weight: normal; padding: 3px; }
.main { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
.main-payment { font-family: Verdana, Arial, sans-serif; font-size: 12px; background-color: #F0F1F1; border: 1px ridge #000000; }
.dataTableHeadingRow { background-color: #C9C9C9; }
.dataTableHeadingContent-invoice { font-family: Verdana, Arial, sans-serif;	font-size: 10px; color: #000000; font-weight: bold; border: 1px ridge #000000;}
.dataTableRow { background-color: #F0F1F1; }
.dataTableContent { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #000000; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.main-payment2 { font-family: Verdana, Arial, sans-serif; font-size: 12px; background-color: #FFFF99; border: 1px ridge #000000; }
</style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#ffffff" marginheight="0" marginwidth="0">
<!-- IF ORDERS ne '' --> 

<table width="830px" border="0">
  <tbody><tr>
    <td><table width="100%" border="0">
        <tbody><tr>
          <td width="350">
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
              <tbody><tr>
                <td valign="top" align="center"><img src="{LOGO}" alt="" border="0"></td>
              </tr>
              <tr>
                <td class="pageHeading-invoice" valign="top" align="left">
          <b>Seller:</b> {SENDER} <span>({RATE_SUM}) <img src="{RATE_RATIO}" class="fbstar" valign="-30%"></span>
           </td>
		  
              </tr>
            </tbody></table></td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            <table class="pageHeading-invoice2" width="200" border="0">
              <tbody><tr>
                <td><b>{L_1041}&nbsp;{SALE_ID}</b></td>
              </tr>
              <tr>
                <td><b>{L_1043}</b>&nbsp;{INVOICE_DATE}</td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td><hr></td>
          <td class="pageHeading" valign="middle" width="120" align="center"><em><b>{L_1035}</b></em></td>
          <td width="10%"> <hr></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
        <tbody><tr>
          <td valign="top" width="350" align="left">
            <table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                      <td valign="top" align="left"><b>{L_1037}</b></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>{WINNER}</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table>
			</td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            <table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                      <td valign="top" align="left"><b>{L_1038}</b></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">{WINNER}</td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                   </tbody>
				   </table>
          </td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment"><b>{L_1042}</b><br>Auction ID: {AUCTION_ID}/ {L_1041}&nbsp;{SALE_ID}</td>
          <td class="main-payment"><b>{L_1036}</b><br>{INVOICE_DATE}</td>
          <td class="main-payment"><b>{L_1055}</b><br>{PAYMENT_METHOD}</td>
          <td class="main-payment"><b>{L_1054}</b><br>{SHIPPING_METHOD}</td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tbody><tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent-invoice" colspan="2">{L_1044}</td>
        <td class="dataTableHeadingContent-invoice" align="right">{L_1045}</td>
        <td class="dataTableHeadingContent-invoice" align="right">{L_1046}</td>
        <td class="dataTableHeadingContent-invoice" align="right">{L_1047}</td>
        <td class="dataTableHeadingContent-invoice" align="right">{L_1048}</td>
        <td class="dataTableHeadingContent-invoice" align="right">{L_1049}</td>
      </tr>
      
      <tr class="dataTableRow">
        <td class="dataTableContent" valign="top" align="right">{ITEM_QUANTITY}&nbsp;x</td>
        <td class="dataTableContent" valign="top">{AUCTION_TITLE}
        
        <br><nobr>&nbsp;<i> - {SUBTITLE}</i></nobr>
       </td>
        <td class="dataTableContent" valign="top" align="right">{TAX}</td>
        <td class="dataTableContent" valign="top" align="right"><b>{UNIT_PRICE}</b></td>
        <td class="dataTableContent" valign="top" align="right"><b>{UNIT_PRICE_WITH_TAX}</b></td>
        <td class="dataTableContent" valign="top" align="right"><b>{TOTAL}</b></td>
        <td class="dataTableContent" valign="top" align="right"><b>{TOTAL_WITH_TAX}</b></td>
      </tr>
     <tr>
        <td colspan="8" align="right"><br> <table border="0" cellpadding="2" cellspacing="0">
          <tbody>
          <tr>
		    <td class="smallText" align="right">{L_1050}</td>
			<td class="smallText" align="right">{TOTAL}</td>
			</tr>
			<tr>
            <td class="smallText" align="right">{L_1051}</td>
			<td class="smallText" align="right">{SHIPPING_COST}</td>
			</tr>
			<tr>
            <td class="smallText" align="right">{L_1052}</td>
			<td class="smallText" align="right">{VAT_TOTAL}</td>
			</tr>
			<tr>
            <td class="smallText" align="right">{L_1053}</td>
			<td class="smallText" align="right">{TOTAL_SUM}</td>
			
          </tr>
</tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment2">{L_entry_yellow_line}</td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="main" align="center"><b>{L_entry_thankyou}</b></td>
  </tr>
</tbody>
</table>

<!-- ELSE -->
<div style="position: absolute; top: 15%; left: 40%;">
<h4>{L_1056}</h4>
</div>
<!-- ENDIF -->

</body>
</html>