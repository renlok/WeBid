<html>
<head>
<title>{SITENAME}</title>
<link rel="stylesheet" type="text/css" href="themes/{THEME}/style.css">
<script type="text/javascript" src="js/jquery.js"></script>

<!-- Load Queue widget CSS and jQuery -->
<style type="text/css">@import url({SITEURL}inc/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>

<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="{SITEURL}inc/plupload/js/plupload.full.js"></script>
<script type="text/javascript" src="{SITEURL}inc/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,gears,flash,silverlight,browserplus',
		url : '{SITEURL}ajax.php?do=uploadaucimages',
		max_file_size : '{MAXPICSIZE}kb',
		chunk_size : '1mb',
		unique_names : true,

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,jpeg,gif,png"},
		],

		// Flash settings
		flash_swf_url : '{SITEURL}inc/plupload/js/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : '{SITEURL}inc/plupload/js/plupload.silverlight.xap',

		// Post init events, bound after the internal events
		init : {
			Refresh: function(up) {
				// Called when upload shim is moved
			},

			StateChanged: function(up) {
				// Called when the state of the queue is changed
			},

			QueueChanged: function(up) {
				// Called when the files in queue are changed by adding/removing files
				if (up.files.length > ({MAXPICS} - {UPLOADED}))
				{
					for (var key in up.files) {
						if (up.files.length > ({MAXPICS} - {UPLOADED})) {
							up.removeFile(up.files[key]);
						}
					}
				}
				up.refresh();
			},

			UploadProgress: function(up, file) {
				// Called while a file is being uploaded
			},

			FilesAdded: function(up, files) {
				// Callced when files are added to queue
			},

			FilesRemoved: function(up, files) {
				// Called when files where removed from queue

				plupload.each(files, function(file) {
				});
			},

			FileUploaded: function(up, file, info) {
				// Called when a file has finished uploading
				$.get('{SITEURL}ajax.php?do=getupldtable', function(data) {
					$('#uploaded').html(data);
				});
			},

			ChunkUploaded: function(up, file, info) {
				// Called when a file chunk has finished uploading
			},

			Error: function(up, args) {
				// Called when a error has occured
			}
		}
	});
});
</script>

<script type="text/javascript">
$(document).ready(function () {
	var num_images = $('#numimages', window.opener.document).val();
	var now_images = {UPLOADED};
	var image_cost = {IMAGE_COST_PLAIN};
	if (num_images != now_images) {
		var fee_diff = (now_images - num_images) * image_cost;
		var nowfee = $("#fee_exact", window.opener.document).val() + fee_diff;
		$("#fee_exact", window.opener.document).val(nowfee);
		$("#to_pay").text(Math.round(nowfee*1{FEE_DECIMALS})/1{FEE_DECIMALS});
		$('#numimages', window.opener.document).val(now_images);
	}
});
</script>
</head>

<body>
<div class="padding">
<!-- IF ERROR ne '' -->
	<div class="error-box">
		{ERROR}
	</div>
<!-- ENDIF -->
	<div class="titTable2">
		{L_663}
	</div>

	<table cellpadding="3" cellspacing="0" border="0" align="center" width="90%">
		<tr bgcolor="{HEADERCOLOUR}">
			<td width="76%" colspan="2">
				<b>{L_684}</b>
			</td>
			<td width="12%" align="center">
				<b>{L_008}</b>
			</td>
			<td width="12%" align="center">
				<b>{L_686}</b>
			</td>
		</tr>
		<tbody id="uploaded">
<!-- BEGIN images -->
		<tr>
			<td>
				<img src="{images.IMAGE}" width="60" border="0">
			</td>
			<td width="46%">
				{images.IMGNAME}
			</td>
			<td align="center">
				<a href="?action=delete&img={images.ID}"><IMG SRC="images/trash.gif" border="0"></a>
			</td>
			<td align="center">
				<a href="?action=makedefault&img={images.IMGNAME}"><img src="images/{images.DEFAULT}" border="0"></a>
			</td>
		</tr>
<!-- END images -->
		</tbody>
	</table>
	<p>{PICINFO}</p>
	<p>{IMAGE_COST}</p>
	<div id="uploader">
		<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>

	<br style="clear:both;">
	<center>
		<a href="javascript: window.close()">{L_678}</a>
	</center>
</div>
</body>
</html>