<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css">
	<script type="text/javascript" src="{SITEURL}admin/{SITEURL}fck/fckeditor.js"></script>
	<script type="text/javascript">
		function window_open(pagina,titulo,ancho,largo,x,y){
		var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
		open(pagina,titulo,Ventana);
		}
	</script>
	<script type="text/javascript" src="{SITEURL}admin/{SITEURL}admin/js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$('a.new-window').click(function(){
		window.open(this.href, this.alt, "toolbar=0,location=0,directories=0,scrollbars=1,screenX=100,screenY=100,status=0,menubar=0,resizable=0,width=550,height=550");
		return false;
		});
		});
	</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td background="{SITEURL}admin/images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td width="30"><img src="{SITEURL}admin/images/i_{TYPE}.gif" ></td>
				<td class="white">{TYPENAME}&nbsp;&gt;&gt;&nbsp;{PAGENAME}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" valign="middle">&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<br>
		<form name="conf" action="" method="post" enctype="multipart/form-data">
		<table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{TITLEBARNAME}{PAGENAME}</td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="2" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
<!-- BEGIN block -->
					<tr valign="top">
						<td width="175">{block.TITLE}</td>
						<td style="padding:3px;">
							{block.DESCRIPTION}
	<!-- IF block.TYPE eq 'yesno' -->
				<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'batch' -->
				<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'batchstacked' -->
				<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE2}	
	<!-- ELSEIF block.TYPE eq 'datestacked' -->
				<input type="radio" name="{block.NAME}" value="USA"<!-- IF block.DEFAULT eq 'USA' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="EUR"<!-- IF block.DEFAULT eq 'EUR' --> checked<!-- ENDIF -->> {block.TAGLINE2}	
	<!-- ELSEIF block.TYPE eq 'select3num' -->
				<input type="radio" name="{block.NAME}" value="0"<!-- IF block.DEFAULT eq '0' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
				<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
				<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
	<!-- ELSEIF block.TYPE eq 'select3contact' -->
				<input type="radio" name="{block.NAME}" value="always"<!-- IF block.DEFAULT eq 'always' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
				<input type="radio" name="{block.NAME}" value="logged"<!-- IF block.DEFAULT eq 'logged' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
				<input type="radio" name="{block.NAME}" value="never"<!-- IF block.DEFAULT eq 'never' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
	<!-- ELSEIF block.TYPE eq 'text' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="50" maxlength="255">
	<!-- ELSEIF block.TYPE eq 'password' -->
				<input type="password" name="{block.NAME}" value="{block.DEFAULT}" size="50" maxlength="255">
	<!-- ELSEIF block.TYPE eq 'textarea' -->
				<textarea name="{block.NAME}" cols="65" rows="10">{block.DEFAULT}</textarea>
	<!-- ELSEIF block.TYPE eq 'days' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="4" maxlength="4"> {block.TAGLINE1}			
	<!-- ELSEIF block.TYPE eq 'kbytes' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="4" maxlength="4"> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'percent' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="3" maxlength="3"> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'decimals' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="5" maxlength="10"> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'yesnostacked' -->
				<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'sortstacked' -->
				<input type="radio" name="{block.NAME}" value="alpha"<!-- IF block.DEFAULT eq 'alpha' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="counter"<!-- IF block.DEFAULT eq 'counter' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'checkbox' -->
				<input type="checkbox" name="{block.NAME}" id="{block.DEFAULT}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'dropdown' -->
				<form name="{block.NAME}" action="" method="GET"<!-- IF block.DEFAULT eq 'always' --> selected<!-- ENDIF -->>
		  			<div class="Browse">
				{DROPDOWN}
	<!-- ELSEIF block.TYPE eq 'upload' -->
				<input type="file" name="{block.NAME}" size="25" maxlength="100">
				<input type=HIDDEN name="MAX_FILE_SIZE" value="51200">
	<!-- ELSEIF block.TYPE eq 'image' -->
				<img src="{IMAGEURL}">{block.TAGLINE1}<br>
	<!-- ELSEIF block.TYPE eq 'link' -->
				<a href="{LINKURL}">{block.TAGLINE1}</a>
	<!-- ELSE -->					
				{block.TYPE}
	<!-- ENDIF -->
						</td>
					</tr>
<!-- END block -->
					<tr valign="top">
						<td height="22">&nbsp;</td>
						<td height="22">&nbsp;</td>
					</tr>
					<tr>
						<td><input type="hidden" name="action" value="update"></td>
						<td><input type="submit" name="act" value="{L_530}"></td>
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