<html>
<head>
<link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
<script type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
}
function selectAllDelete(formObj, isInverse) 
{
   for (var i=0; i < formObj.length; i++) 
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
				<td width="30"><img src="{SITEURL}admin/images/i_set.gif" width="21" height="19"></td>
				<td class="white">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_078}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr> 
	<td align="center" valign="middle">
		<br>
		<form name="conf" action="" method="post">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		<tr> 
			<td align="center" class="title">{L_078}</td>
		</tr>
		<tr> 
			<td> 
				<table width="100%" cellpadding=2 bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td class="error" colspan="2" align="center">{ERROR}</td>
				</tr>
<!-- ENDIF -->
				<tr> 
					<td width="10">&nbsp;</td>
					<td colspan="4">
						<p>{L_161}</p>
						<p><img src="{SITEURL}images/nodelete.gif" width="20" height="21"> {L_2__0030}</p>
					</td>
				</tr>
				<tr> 
					<td width=10 height="21">&nbsp;</td>
					<td colspan="4" height="21">{CRUMBS}</td>
				</tr>
				<tr>
					<td width="10">&nbsp;</td>
					<td bgcolor="#EEEEEE" width="40%"><b>{L_087}</b></td>
					<td bgcolor="#EEEEEE" width="20%"><b>{L_328}</b></td>
					<td bgcolor="#EEEEEE" width="20%"><b>{L_329}</b></td>
					<td bgcolor="#EEEEEE" width="20%"><b>{L_008}</b></td>
				</tr>
<!-- BEGIN cats -->
				<tr valign="top" style="background-color: {cats.ROW_COLOUR};">
					<td width="10" align="right" valign="top">
						<a href="categories.php?parent={cats.CAT_ID}"><img src="{SITEURL}images/plus.gif" border=0 alt="Browse Subcategories"></a>
					</td>
					<td valign="top">
						<input type="text" name="categories[{cats.CAT_ID}]" value="{cats.CAT_NAME}" size="50">
					</td>
					<td>
						<input type="text" name="colour[{cats.CAT_ID}]" value="{cats.CAT_COLOUR}" size="25">
					</td>
					<td>
						<input type="text" name="image[{cats.CAT_ID}]" value="{cats.CAT_IMAGE}" size=25>
					</td>
					<td align="center">
	<!-- IF cats.B_CAN_DELETE -->
						<input type="checkbox" name="delete[{cats.CAT_ID}]" value="{cats.CAT_ID}">
	<!-- ELSE -->
						<img src="{SITEURL}images/nodelete.gif" alt="You cannot delete this category">
	<!-- ENDIF -->
					</td>
				</tr>
<!-- END cats -->
				<tr>
					<td colspan="4">&nbsp;</td>
					<td align="center"><a href="javascript: void(0)" onClick="selectAllDelete(document.forms[0],1)">{L_30_0102}</a></td>
				</tr>
				<tr>
					<td>{L_394}</td>
					<td>
						<input type="text" name="new_category" size="25">
					</td>
					<td>
						<input type="text" name="cat_colour" size="25">
					</td>
					<td>
						<input type="text" name="cat_image" size="25">
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5" height="22">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>{L_368}</td>
					<td colspan="3">
						<textarea name="mass_add" cols="35" rows="6"></textarea>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="5">
						<input type="hidden" name="parent" value="{PARENT}">
						<input type="submit" name="action" value="{L_089}">
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

<!-- INCLUDE footer.tpl -->