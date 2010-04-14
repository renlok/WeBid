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
                <td width="30"><img src="images/i_gra.gif"></td>
                <td class="white">{L_25_0009}&nbsp;&gt;&gt;&nbsp;{L_26_0002}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
<!-- IF B_EDIT_FILE -->
		<form name="conf" action="" method="post">
		<table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title"><!-- IF FILENAME ne '' -->{L_298}: {FILENAME}<!-- ELSE -->{L_518}<!-- ENDIF --></td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="2" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
					<tr valign="top">
						<td>{L_812}</td>
						<td align="center">
                        	<!-- IF FILENAME ne '' --><b>{FILENAME}</b><!-- ELSE --><input type="text" name="new_filename" value="" style="width:600px;"><!-- ENDIF -->
                        </td>
					</tr>
					<tr valign="top">
						<td>{L_813}</td>
						<td align="center">
                        	<textarea style="width:600px; height:400px;" name="content">{FILECONTENTS}</textarea>
                        </td>
					</tr>
					<tr valign="top">
						<td height="22">&nbsp;</td>
						<td height="22">&nbsp;</td>
					</tr>
					<tr>
						<td>
                        	<input type="hidden" name="action" value="<!-- IF FILENAME ne '' -->edit<!-- ELSE -->add<!-- ENDIF -->">
                            <input type="hidden" name="filename" value="{FILENAME}">
                            <input type="hidden" name="theme" value="{THEME}">
                        </td>
						<td><input type="submit" name="act" value="{L_071}"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
		</form>
        <br><br>
<!-- ENDIF -->
		<form name="conf" action="" method="post">
		<table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{L_26_0002}</td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="2" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
    <!-- BEGIN themes -->
                    <tr style="background-color:{themes.BGCOLOUR};">
                        <td style="padding-left:10px;">
                            <input type="radio" name="dtheme" value="{themes.NAME}" <!-- IF themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>
                            <b>{themes.NAME}</b>
                        </td>
                        <td align="left">
                            <a href="theme.php?do=listfiles&theme={themes.NAME}">{L_26_0003}</a><br>
                            <a href="theme.php?do=addfile&theme={themes.NAME}">{L_26_0004}</a><br>
                        </td>
                    </tr>
        <!-- IF themes.B_LISTFILES -->
                    <tr style="background-color:{themes.BGCOLOUR};">
                        <td align="center" colspan="2">
                        	<select name="file" multiple size="24" style="font-weight:bold; width:350px"
                             ondblclick="document.getElementById('action').value = ''; document.getElementById('theme').value = '{themes.NAME}'; this.form.submit();">
                            <optgroup>
                            <option style="background-color:<!-- IF themes.B_ADMINSHOWN -->#ABABAB<!-- ELSE -->#CCCCCC<!-- ENDIF -->;" value="admin">Admin Templates <!-- IF themes.B_ADMINSHOWN -->«<!-- ELSE -->»<!-- ENDIF --></option>
            <!-- BEGIN adminfiles -->
            				<option value="admin/{themes.adminfiles.FILE}">{themes.adminfiles.FILE}</option>
            <!-- END adminfiles -->
            				</optgroup>
            <!-- BEGIN files -->
            				<option value="{themes.files.FILE}">{themes.files.FILE}</option>
            <!-- END files -->
            				</select>
                        </td>
                    </tr>
        <!-- ENDIF -->
    <!-- END themes -->
					<tr valign="top">
						<td height="22">&nbsp;</td>
						<td height="22">&nbsp;</td>
					</tr>
					<tr>
						<td>
                        	<input type="hidden" name="action" value="update" id="action">
                            <input type="hidden" name="theme" value="" id="theme">
                        </td>
						<td><input type="submit" name="act" value="{L_26_0000}"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
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