<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
	<script type="text/javascript">
	function selectDelete(formObj, isInverse) 
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
                <td width="30"><img src="{SITEURL}admin/images/i_con.gif"></td>
                <td class="white">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5032}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
        <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{L_5032}</td>
		</tr>
		<tr>
			<td>
				<form name="conf" action="" method="post">
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td class="error" colspan="2" align="center">{ERROR}</td>
				</tr>
<!-- ENDIF -->
				<tr>
					<td colspan="5"><b>{L_5040}</b></td>
				</tr>
				<tr bgcolor="#FFCC00">
					<td width="6%">{L_129}</td>
					<td>{L_294}</td>
					<td width="10%" align="center">{L_5046}</td>
					<td width="12%" align="center">{L_5043}</td>
					<td width="16%" align="center"><a href="#" onClick="selectDelete(document.forms[0],1)">{L_30_0102}</a></td>
				</tr>
<!-- BEGIN boards -->
				<tr bgcolor="{boards.BGCOLOUR}">
					<td>{boards.ID}</td>
					<td>
						<a href="editboards.php?id={boards.ID}">{boards.NAME}</a>
	<!-- IF boards.ACTIVE eq 2 -->
						<b>[{L_5039}]</b>
	<!-- ENDIF -->
					</td>
					<td align="center">{boards.MSGTOSHOW}</td>
					<td align="center">{boards.MSGCOUNT}</td>
					<td align="center">
						<input type="checkbox" name="delete[]" value="{boards.ID}">
					</td>
				</tr>
<!-- END boards -->
				<tr>
					<td colspan="4">&nbsp;</td>
					<td align="center"><a href="#" onClick="selectDelete(document.forms[0],1)">{L_30_0102}</a></td>
				</tr>
				<tr>
					<td align="center" colspan="5">
						<input type="submit" name="Submit2" value="Delete">
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

<!-- INCLUDE footer.tpl -->