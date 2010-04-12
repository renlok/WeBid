<html>
<head>
    <link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
	<script type="text/javascript">
	function selectAll(formObj, isInverse) 
	{
	   for (var i=0;i < formObj.length;i++) 
	   {
		  fldObj = formObj.elements[i];
		  if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete')
		  { 
			 if (isInverse)
				fldObj.checked = (fldObj.checked) ? false : true;
			 else fldObj.checked = true; 
		   }
	   }
	}
	</script>
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
    <td background="{SITEURL}admin/images/bac_barint.gif">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr> 
                <td width="30"><img src="{SITEURL}admin/images/i_set.gif" ></td>
                <td class="white">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_075}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td align="center" valign="middle">
        <table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title">{L_075}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
            	<form name="addnew" action="" method="post">
                <table width="100%" cellpadding="2" border="0">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="3" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
					<tr>
						<td width="50">&nbsp;</td>
						<td colspan="2">{L_092}</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td bgcolor="#EEEEEE"><b>{L_087}</b></td>
						<td bgcolor="#EEEEEE"><b>{L_008}</b></td>
					</tr>
<!-- BEGIN payments -->
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="new_payments[]" value="{payments.PAYMENT}" size="25">
						</td>
						<td align="center">
							<input type="checkbox" name="delete[]" value="{payments.S_ROW_COUNT}">
						</td>
					</tr>
<!-- END payments -->
					<tr>
						<td>{L_394}</td>
						<td>
							<input type="text" name="new_payments[]" size="25">
						</td>
						<td align=center>
							<a href="javascript: void(0)" onClick="selectAll(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2">
							<input type="hidden" name="action" value="update">
							<input type="submit" name="act" value="{L_089}">
						</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->