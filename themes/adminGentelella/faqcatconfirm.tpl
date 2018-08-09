<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{L_25_0009} <i class="fa fa-angle-double-right"></i> {L_clear_cache}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          <li><a class="close-link"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
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
        <input type="submit" name="action" value="{L_030}" class="btn bnt-primary">
        <input type="submit" name="action" value="{L_029}" class="btn bnt-primary">
	</form>
    </div>
</div>
<div>
</div>
<!-- INCLUDE footer.tpl -->
