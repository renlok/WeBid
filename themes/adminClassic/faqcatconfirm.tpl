<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}/themes/{THEME}/style.css" />
</head>
<body style="margin:0;">
<div style="width:400px; padding:40px;" class="centre">
	<div class="plain-box" style="text-align:center; padding: 10px; font-size: 1.4em;">
	<form action="" method="post">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<p>
      {L_faq_delete_action}
      <table cellpadding="0" cellspacing="0">
        <!-- BEGIN faqcats -->
        <!-- IF faqcats.COUNT > 0 -->
        <tr>
          <td>{faqcats.CATEGORY}</td>
          <td>
            <select name="delete[{faqcats.ID}]">
            <option value="delete">{L_008}</option>
            {faqcats.DROPDOWN}
            </select>
          </td>
        </tr>
        <!-- ENDIF -->
        <!-- END faqcats -->
      </table>
    </p>
    <p>{L_confirm_faq_action}</p>
    <p>{CAT_LIST}</p>
		<div class="break">&nbsp;</div>
		<button type="submit" name="action" value="Yes">{L_yes}</button>
		<button type="submit" name="action" value="No">{L_no}</button>
	</form>
	</div>
</div>
<div>
