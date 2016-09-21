		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
					<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{TYPENAME}&nbsp;&gt;&gt;&nbsp;{PAGENAME}</h4>
					<form name="conf" action="" method="post" enctype="multipart/form-data">
						<table width="98%" cellpadding="2" align="center" class="blank">
<!-- BEGIN block -->
						<tr valign="top">
<!-- IF block.B_HEADER -->
							<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
								<b>{block.TITLE}</b>
							</td>
<!-- ELSE -->
							<td width="175">{block.TITLE}</td>
							<td style="padding:3px;">
								{block.DESCRIPTION}
	<!-- IF block.TYPE eq 'yesno' -->
								<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'text' -->
								<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="50" maxlength="255">
	<!-- ELSE -->
								{block.TYPE}
	<!-- ENDIF -->
							</td>
<!-- ENDIF -->
						</tr>
<!-- END block -->
						<tr valign="top">
							<td  colspan="2">
								<button type="button" onclick="showDialog();return false;">{L_1137}</button>
							</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>
		<div id="dialog-modal" title="{L_1134}" style="display: none;">
			<div class="rounded-top rounded-bottom">
				Mail details currently saved and used during this test:<br><br>
				Mail Protocol = {MAIL_PROTOCOL}<br>
				Smtp Authentication = {SMTP_AUTH}<br>
				Smtp Security = {SMTP_SEC}<br>
				Smtp Port = {SMTP_PORT}<br>
				Smtp Username = {SMTP_USER}<br>
				Smtp Password = {SMTP_PASS}<br>
				Smtp Host = {SMTP_HOST}<br>
				Alert Emails = {ALERT_EMAILS}<br>
				Don't forget to save any changes to take effect <button onclick="$('form[name=conf]').submit();">Save changes</button>
			</div>
			{L_1135}
			<div class="test_m">hi</div>
			<div class="form-style" id="contact_form">
				<p><button class="test_button" onclick="showDialog();" style="button">{L_1136}</button></p>
				<div id="contact_results"></div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(document).on('click', '.test_button',  function(e) {
					e.preventDefault();
					if ($('#text_testmail').val() == '')
					{
						alert('Empty messages cause errors!');
					}
					post_data = {
						'user_name'     : '{L_1139}',
						'user_email'    : '{ADMIN_EMAIL}',
						'subject'       : '{L_1138}',
						'message'       : $('#text_testmail').val(),
						'csrftoken'     : $('input[name=csrftoken]').val()
					};
					//Ajax post data to server
					$.post('emailsettings.php?test_email', post_data, function(response) {
						//load json data from server and output message
						if(response.type == 'error')
						{
							output = '<div class="error-box">'+response.text+'</div>';
						}
						else
						{
							output = '<div class="success-box">'+response.text+'</div>';
						}
						$("#contact_form #contact_results").hide().html(output).slideDown();
					}, 'json');
				});
			});
			function showDialog()
			{
				$("#dialog-modal").dialog(
				{
					width: 600,
					height: 500,
					buttons: {
					"{L_1140}": function() {
							$(this).dialog("close");
						}
					},
					open: function(event, ui)
					{
							var textarea = $('<input type="textarea" id="text_testmail" name="text_testmail" style="height: 50px; width:90%;">');
							$('.test_m').html(textarea);
					}
				});
			}

			$(document).ready(function() {
				if ($('select[name=mail_protocol] option:selected').val() == 2)
				{
					$('.smtp').parent().parent().show();
					$('.non_smtp').parent().parent().hide();
				}
				else
				{
					$('.smtp').parent().parent().hide();
					$('.non_smtp').parent().parent().show();
				}
				if ($('select[name=mail_protocol] option:selected').val() == 0)
				{
					$('.para').parent().parent().show();
				}
				else
				{
					$('.para').parent().parent().hide();
				}

				$('select[name=mail_protocol]').on('change', function() {
					//alert('changid');
					if ($(this).val() == 2)
					{
						$('.smtp').parent().parent().show(300);
						$('.non_smtp').parent().parent().hide();
					}
					else
					{
						$('.smtp').parent().parent().hide();
						$('.non_smtp').parent().parent().show(300);
					}
					if ($(this).val() == 0)
					{
						$('.para').parent().parent().show(300);
					}
					else
					{
						$('.para').parent().parent().hide();
					}
				});
			});
		</script>
