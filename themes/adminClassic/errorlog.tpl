<!-- INCLUDE header.tpl -->
		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_891}</h4>
				<form name="errorlog" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
					<div style="margin:10px; overflow:scroll; height:500px; width: 98%;">
						{ERRORLOG}
					</div>
					<input type="hidden" name="action" value="clearlog">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_890}">
				</form>
			</div>
		</div>
<!-- INCLUDE footer.tpl -->