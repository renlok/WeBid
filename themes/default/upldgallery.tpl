<html>
<head>
<title>{SITENAME}</title>
<link rel="stylesheet" type="text/css" href="themes/{THEME}/style.css">
<style media="all" type="text/css">
.imgareaselect-border1 {
	background: url(images/border-v.gif) repeat-y left top;
}

.imgareaselect-border2 {
    background: url(images/border-h.gif) repeat-x left top;
}

.imgareaselect-border3 {
    background: url(images/border-v.gif) repeat-y right top;
}

.imgareaselect-border4 {
    background: url(images/border-h.gif) repeat-x left bottom;
}

.imgareaselect-border1, .imgareaselect-border2,
.imgareaselect-border3, .imgareaselect-border4 {
    opacity: 0.5;
    filter: alpha(opacity=50);
}

.imgareaselect-handle {
    background-color: #fff;
    border: solid 1px #000;
    opacity: 0.5;
    filter: alpha(opacity=50);
}

.imgareaselect-outer {
    background-color: #000;
    opacity: 0.5;
    filter: alpha(opacity=50);
}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	var num_images = $('#numimages', window.opener.document).val();
	var now_images = {NUMIMAGES};
	var image_cost = {IMAGE_COST};
	if (num_images != now_images) {
		var fee_diff = (now_images - num_images) * image_cost;
		var nowfee = $("#fee_exact", window.opener.document).val() + fee_diff;
		$("#fee_exact", window.opener.document).val(nowfee);
		$("#to_pay").text(Math.round(nowfee*1{FEE_DECIMALS})/1{FEE_DECIMALS});
		$('#numimages', window.opener.document).val(now_images);
	}
});
</script>
<!-- IF B_CROPSCREEN -->
<script type="text/javascript" src="js/jquery.imgareaselect.js"></script>
<script type="text/javascript">
function preview(img, selection) {
	var scaleX = {SCALEX} / selection.width;
	var scaleY = {SCALEY} / selection.height;

	$('#thumbprev').css({
		width: Math.round((scaleX / {IMGRATIO}) * {IMGWIDTH}) + 'px',
		height: Math.round((scaleY / {IMGRATIO}) * {IMGHEIGHT}) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1 * {IMGRATIO});
	$('#y1').val(selection.y1 * {IMGRATIO});
	$('#x2').val(selection.x2 * {IMGRATIO});
	$('#y2').val(selection.y2 * {IMGRATIO});
	$('#w').val(selection.width * {IMGRATIO});
	$('#h').val(selection.height * {IMGRATIO});
}

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if (x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h=="") {
			alert("You must make a selection first");
			return false;
		} else {
			return true;
		}
	});
});

$(window).load(function () {
	$('#thumbnail').imgAreaSelect({ aspectRatio: '{RATIO}', onSelectChange: preview, x1: 0, y1: 0, x2: {STARTX}, y2: {STARTY} });
});

</script>
<!-- ENDIF -->
</head>

<body bgcolor="#FFFFFF">
<div class="container">
<!-- IF B_CROPSCREEN -->
<div style="color:#000000;" align="center">
	<p>{L_610}</p>
	<img src="{IMGPATH}" style="{SWIDTH}" id="thumbnail" alt="Create Thumbnail">
	<p>{L_613}</p>
	<div style="overflow:hidden; border:#000000 double; {THUMBWH}">
		<img src="{IMGPATH}" style="position: relative;" alt="Thumbnail Preview" id="thumbprev">
	</div>
	<form name="thumbnail" action="?action=crop&img={IMAGE}" method="post">
    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<input type="hidden" name="x1" value="0" id="x1">
		<input type="hidden" name="y1" value="0" id="y1">
		<input type="hidden" name="x2" value="{STARTX}" id="x2">
		<input type="hidden" name="y2" value="{STARTY}" id="y2">
		<input type="hidden" name="w" value="50" id="w">
		<input type="hidden" name="h" value="50" id="h">
		<input type="submit" class="button" name="upload_thumbnail" value="{L_616}" id="save_thumb"><input type="submit" class="button" name="upload_thumbnail" value="{L_618}" >
	</form>
	<span class="smallspan">{L_629}</span>
</div>
<!-- ELSE -->
<form name="upload" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
<table cellpadding="3" cellspacing="0" border="0" align="center" width="90%">
	<tr>
		<td bgcolor="{HEADERCOLOUR}" colspan="2">
			<b>{L_663}</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			{L_673} {MAXIMAGES} {L_674}<br>
			{L_679}
		</td>
	</tr>
	<!-- IF ERROR ne '' -->
	<tr>
		<td class="errfont" align="center">
			{ERROR}
		</td>
	</tr>
	<!-- ENDIF -->
	<!-- IF B_CANUPLOAD -->
	<tr>
		<td>
			1. {L_680}<br>
			<input type="file" name="userfile" size="15">
		</td>
	</tr>
	<tr>
		<td>
			2. {L_681}<br>
			<input type="submit" name="uploadpicture" value="{L_681}">
		</td>
	</tr>
	<tr>
		<td>
			{L_682}
		</td>
	</tr>
	<!-- ELSE -->
	<tr>
		<td class="errfont" align="center">
			{L_688} {MAXIMAGES} {L_689}
		</td>
	</tr>
	<!-- ENDIF -->
</table>
<!-- ENDIF -->
<br style="clear:both;">
<br>
<center>
<b>{L_687}</b>
</center>
<table cellpadding="3" cellspacing="0" border="0" align="center" width="90%">
	<tr bgcolor="{HEADERCOLOUR}">
		<td width="46%">
			<b>{L_684}</b>
		</td>
		<td width="30%">
			<b>{L_685}</b>
		</td>
		<td width="12%" align="center">
			<b>{L_008}</b>
		</td>
		<td width="12%" align="center">
			<b>{L_686}</b>
		</td>
	</tr>
	<!-- BEGIN images -->
	<tr>
		<td>
			{images.IMGNAME}
		</td>
		<td>
			{images.IMGSIZE}
		</td>
		<td align="center">
			<a href="?action=delete&img={images.ID}"><IMG SRC="images/trash.gif" border="0"></a>
		</td>
		<td align="center">
			<a href="?action=makedefault&img={images.IMGNAME}"><img src="images/{images.DEFAULT}" border="0"></a>
		</td>
	</tr>
	<!-- END images -->
</table>
<br><br>
<center>
	<input type="submit" name="creategallery" value="{L_683}">
</center>
</form>
<br><br>
<center>
	<a href="javascript: window.close()">{L_678}</a>
</center>
</div>
</body>
</html>