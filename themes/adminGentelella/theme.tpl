

<div class="col-md-12">
             	<h2>{L_25_0009}&nbsp;&gt;&gt;&nbsp;<!-- IF B_EDIT_FILE --><!-- IF FILENAME ne '' -->{L_298}: {FILENAME}<!-- ELSE -->{L_518}<!-- ENDIF --><!-- ELSE -->{L_26_0002}<!-- ENDIF --></h2>
</div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
          <div class="col-md-8"> 
<!-- IF ERROR ne '' -->
				<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> {ERROR}</div>
<!-- ENDIF -->
<!-- IF B_EDIT_FILE -->
                <form name="editfile" action="" method="post">
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
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
                    </table>
                    <input type="hidden" name="action" value="<!-- IF FILENAME ne '' -->edit<!-- ELSE -->add<!-- ENDIF -->">
                    <input type="hidden" name="filename" value="{FILENAME}">
                    <input type="hidden" name="theme" value="{EDIT_THEME}">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" class="centre" value="{L_071}">
                </form>
<!-- ENDIF -->
                <form name="theme" action="" method="post">
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <th colspan="2">{L_NAY_03}</th>
    <!-- BEGIN themes -->
                        <tr {themes.BG}>
                            <td style="padding-left:10px;" width="75%">
                                <input type="radio" name="dtheme" value="{themes.NAME}" <!-- IF themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>
                                <b>{themes.NAME}</b>
                            </td>
                            <td align="left">
                                <p><a href="theme.php?do=listfiles&theme={themes.NAME}">{L_26_0003}</a></p>
                                <p><a href="theme.php?do=addfile&theme={themes.NAME}">{L_26_0004}</a></p>
                            </td>
                        </tr>
        <!-- IF themes.B_LISTFILES -->
                        <tr {themes.BG}>
                            <td align="center" colspan="2">
                                <select name="file" multiple size="24" style="font-weight:bold; width:350px"
                                ondblclick="document.getElementById('action').value = ''; document.getElementById('theme').value = '{themes.NAME}'; this.form.submit();">
            <!-- BEGIN files -->
                                <option value="{themes.files.FILE}">{themes.files.FILE}</option>
            <!-- END files -->
                                </select>
                            </td>
                        </tr>
        <!-- ENDIF -->
    <!-- END themes -->
                    </table>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <th colspan="2">{L_NAY_04}</th>
    <!-- BEGIN admin_themes -->
                        <tr {admin_themes.BG}>
                            <td style="padding-left:10px;" width="75%">
                                <input type="radio" name="admin_theme" value="{admin_themes.NAME}" <!-- IF admin_themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>
                                <b>{admin_themes.NAME}</b>
                            </td>
                            <td align="left">
                                <p><a href="theme.php?do=listfiles&theme={admin_themes.NAME}">{L_26_0003}</a></p>
                                <p><a href="theme.php?do=addfile&theme={admin_themes.NAME}">{L_26_0004}</a></p>
                            </td>
                        </tr>
        <!-- IF admin_themes.B_LISTFILES -->
                        <tr {admin_themes.BG}>
                            <td align="center" colspan="2">
                                <select name="file" multiple size="24" style="font-weight:bold; width:350px"
                                ondblclick="document.getElementById('action').value = ''; document.getElementById('theme').value = '{admin_themes.NAME}'; this.form.submit();">
            <!-- BEGIN files -->
                                <option value="{admin_themes.files.FILE}">{admin_themes.files.FILE}</option>
            <!-- END files -->
                                </select>
                            </td>
                        </tr>
        <!-- ENDIF -->
    <!-- END admin_themes -->
                    </table>
                    <input type="hidden" name="action" value="update" id="action">
                    <input type="hidden" name="theme" value="" id="theme">
                    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
                    <input type="submit" name="act" value="{L_26_0000}">
                </form>
            </div>
        </div>    
</div>


<!-- INCLUDE footer.tpl -->
