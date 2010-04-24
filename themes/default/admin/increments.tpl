<html>
<head>
    <link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
    <script type="text/javascript">
	function window_open(pagina,titulo,ancho,largo,x,y)
	{	
		var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
		open(pagina,titulo,Ventana);
	}
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
                <td class="white">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_128}</td>
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
            <td align="center" class="title">{L_128}</td>
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
						<td colspan="4">
                        	{L_135}
							<p>[&nbsp;<a href="javascript:window_open('{SITEURL}converter.php','incre',650,250,30,30);">{L_5010}</a>&nbsp;]</p>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td bgcolor="#EEEEEE"><b>{L_240}</b></td>
						<td bgcolor="#EEEEEE"><b>{L_241}</b></td>
						<td bgcolor="#EEEEEE"><b>{L_137}</b></td>
						<td bgcolor="#EEEEEE"><b>{L_008}</b></td>
					</tr>
<!-- BEGIN increments -->
					<tr bgcolor="{increments.BGCOLOUR}">
                         <td>&nbsp;</td>
                         <td>
                         	<input type="hidden" name="id[]" value="{increments.ID}">
                         	<input type="text" name="lows[]" value="{increments.LOW}" size="10">
                         </td>
                         <td><input type="text" name="highs[]" value="{increments.HIGH}" size="10"></td>
                         <td><input type="text" name="increments[]" value="{increments.INCREMENT}" size="10"></td>
                         <td align="center"><input type="checkbox" name="delete[]" value="{increments.ID}"></td>
					</tr>
<!-- END increments -->
					<tr>
                        <td>{L_518}</td>
                        <td>
                        	<input type="hidden" name="id[]" value="">
                            <input type="text" name="lows[]" size="10">
                        </td>
                        <td><input type="text" name="highs[]" size="10"></td>
                        <td><input type="text" name="increments[]" size="10"></td>
                        <td align="center">
                        <a href="javascript: void(0)" onclick="selectAll(document.forms[0],1)">{L_30_0102}</a>
                        </td>
					</tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
					<tr>
                        <td>&nbsp;</td>
						<td>
                            <input type="hidden" name="action" value="update">
                            <input type="submit" name="act" value="{L_089}">
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