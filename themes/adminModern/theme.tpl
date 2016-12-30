		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0009}&nbsp;&gt;&gt;&nbsp;<!-- IF B_EDIT_FILE --><!-- IF FILENAME ne '' -->{L_298}: {FILENAME}<!-- ELSE -->{L_518}<!-- ENDIF --><!-- ELSE -->{L_26_0002}<!-- ENDIF --></h4>
<!-- IF B_EDIT_FILE -->
				<form name="editfile" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">{L_812}</div>
								<div class="col-md-9">
									<!-- IF FILENAME ne '' --><b>{FILENAME}</b><!-- ELSE --><input type="text" name="new_filename" value="" class="form-control"><!-- ENDIF -->
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">{L_813}</div>
								<div class="col-md-9">
									<textarea class="form-control" name="content" rows="15">{FILECONTENTS}</textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" name="action" value="<!-- IF FILENAME ne '' -->edit<!-- ELSE -->add<!-- ENDIF -->">
									<input type="hidden" name="filename" value="{FILENAME}">
									<input type="hidden" name="theme" value="{EDIT_THEME}">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<button class="btn btn-primary" type="submit" name="act">{L_071}</button>
								</div>
							</div>
						</div>
					</div>
				</form>
<!-- ENDIF -->
				<form name="theme" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
<!-- BEGIN themes -->
							<div class="row">
								<div class="col-md-6">
									<input type="radio" name="dtheme" value="{themes.NAME}" <!-- IF themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>
									<b>{themes.NAME}</b>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12"><a href="theme.php?do=listfiles&theme={themes.NAME}">{L_26_0003}</a></div>
									</div>
									<div class="row">
										<div class="col-md-12"><a href="theme.php?do=addfile&theme={themes.NAME}">{L_26_0004}</a></div>
									</div>
								</div>
							</div>
	<!-- IF themes.B_LISTFILES -->
							<div class="row">
								<div class="col-md-6">&nbsp;</div>
								<div class="col-md-6">
									<select name="file" multiple size="24" style="font-weight:bold; width:350px"
								ondblclick="document.getElementById('action').value = ''; document.getElementById('theme').value = '{themes.NAME}'; this.form.submit();">
		<!-- BEGIN files -->
										<option value="{themes.files.FILE}">{themes.files.FILE}</option>
		<!-- END files -->
									</select>
								</div>
							</div>
	<!-- ENDIF -->
<!-- END themes -->
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
<!-- BEGIN admin_themes -->
							<div class="row">
								<div class="col-md-6">
									<input type="radio" name="admin_theme" value="{admin_themes.NAME}" <!-- IF admin_themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>
									<b>{admin_themes.NAME}</b>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12"><a href="theme.php?do=listfiles&theme={admin_themes.NAME}">{L_26_0003}</a></div>
									</div>
									<div class="row">
										<div class="col-md-12"><a href="theme.php?do=addfile&theme={admin_themes.NAME}">{L_26_0004}</a></div>
									</div>
								</div>
							</div>
	<!-- IF admin_themes.B_LISTFILES -->
							<div class="row">
								<div class="col-md-6">&nbsp;</div>
								<div class="col-md-6">
									<select name="file" multiple size="24" style="font-weight:bold; width:350px"
								ondblclick="document.getElementById('action').value = ''; document.getElementById('theme').value = '{admin_themes.NAME}'; this.form.submit();">
		<!-- BEGIN files -->
										<option value="{admin_themes.files.FILE}">{admin_themes.files.FILE}</option>
		<!-- END files -->
									</select>
								</div>
							</div>
	<!-- ENDIF -->
<!-- END admin_themes -->
						</div>
					</div>
					<input type="hidden" name="action" value="update" id="action">
					<input type="hidden" name="theme" value="" id="theme">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_26_0000}</button>
				</form>
			</div>
		</div>
