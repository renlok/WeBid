<html>
<head>
<title>{SITENAME}</title>
<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/style.css">
<link type="text/css" rel="stylesheet" href="{SITEURL}js/pluploadjs/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen">

<script type="text/javascript" src="{SITEURL}js/jquery.js"></script>
<script type="text/javascript" src="{SITEURL}js/pluploadjs/plupload.full.min.js"></script>
<script type="text/javascript" src="{SITEURL}js/pluploadjs/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	// Setup html5 version
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : '{SITEURL}ajax.php?do=uploadaucimages',
		chunk_size : '1mb',
		unique_names : true,
		dragdrop: true,
		multiple_queues: {MAXPICS} < {UPLOADED} ? "true" : "false",

		// Specify what files to browse for
		filters : {
		// Maximum file size
			max_file_size : "{MAXPICSIZE}kb",
			// Specify what files to browse for
			mime_types: [
			{title : "Image files", extensions : "jpg,jpeg,gif,png"}
		]
		},
		multipart_params : {
			"csrftoken" : "{_CSRFTOKEN}"
		},

		// Resize images on clientside if we can
		resize: {
			width : {MAXWIDTHHEIGHT},
			height : {MAXWIDTHHEIGHT},
			quality : 90,
			crop: false // crop to exact dimensions
		},

		// Flash settings
		flash_swf_url : '{SITEURL}js/pluploadjs/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : '{SITEURL}js/pluploadjs/Moxie.xap',

		// Post init events, bound after the internal events
		init : {
			Refresh: function(up) {
				// Called when the position or dimensions of the picker change
			},

			StateChanged: function(up) {
				// Called when the state of the queue is changed
			},

			QueueChanged: function(up) {
				// Called when queue is changed by adding or removing files
				if (up.files.length > ({MAXPICS} - {UPLOADED}))
				{
					for (var key in up.files)
					{
						if (up.files.length > ({MAXPICS} - {UPLOADED}))
						{
							up.removeFile(up.files[key]);
							if ($('#uploader_browse').is(":visible"))
							{
								alert('You have reached the max allowed of ' + {MAXPICS} + ' files.');
							}
							$('#uploader_browse').hide();

						}
					}
				}
			},

			UploadProgress: function(up, file) {
				// Called while a file is being uploaded
			},

			FileFiltered: function(up, file) {
				// Called when file successfully files all the filters
			},

			FilesAdded: function(up, files) {
				// Called when files are added to queue
				var max_files = {MAXPICS};
				plupload.each(files, function (file) {
					if (up.files.length > max_files)
					{
						// alert('You are allowed to add only ' + max_files + ' files.');
						up.removeFile(file);
					}
				});

				if (files.length >= max_files)
				{
					$('#uploader_browse').hide('slow');
				}
			},

			FilesRemoved: function(up, files) {
				// Called when files are removed from queue
				var max_files = {MAXPICS};
				if (files.length < max_files)
				{
					$('#uploader_browse').fadeIn('slow');
				}

				plupload.each(files, function(file) {
				});
			},

			FileUploaded: function(up, file, info) {
				// Called when a file has finished uploading
				$.get('{SITEURL}ajax.php?do=getupldtable', function(data) {
					$('#uploaded').html(data);
				});
				if (up.files.length < ({MAXPICS} - {UPLOADED}))
				{
					// $('.plupload_buttons').fadeIn('slow'); $('.plupload_upload_status').hide();
				}
			},

			ChunkUploaded: function(up, file, info) {
				// Called when file chunk has finished uploading
			},

			UploadComplete: function(up, files) {
				// Called when all files are either uploaded or failed
				window.location = window.location.pathname;
			},

			Destroy: function(up) {
				// Called when uploader is destroyed
			},

			Error: function(up, args) {
				// Called when a error has occured
				console.log(args);
			}
		}
	});
});
</script>

<script type="text/javascript">
$(document).ready(function () {
	if ( {MAXPICS} == {UPLOADED})
	{
		$('.plupload_file_name').hide('slow'); $('.moxie-shim-html5').hide();
	}

	var num_images = $('#numimages', window.opener.document).val();
	var now_images = {UPLOADED};
	var image_cost = {IMAGE_COST_PLAIN};
	if (num_images != now_images)
	{
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
		<p>You browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</div>
	<br style="clear:both;">
	<center>
		<a href="javascript: window.close()">{L_678}</a>
	</center>
</div>
</body>
</html>
