		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_25_0169a}</h4>
				<form name="errorlog" action="" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					Your Version: <b>{MYVERSION}</b><br>
					Current Version: {REALVERSION}<br>
					{TEXT}
				</form>
			</div>
		</div>