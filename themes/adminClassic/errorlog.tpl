		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_891}</h4>
				<form name="errorlog" action="" method="post">
					<div style="margin:10px; overflow:scroll; height:500px; width: 98%;">
						{ERRORLOG}
					</div>
					<input type="hidden" name="action" value="clearlog">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_890}">
<!-- IF TYPE eq 'distinct' -->
					<a href="errorlog.php?type=all" class="button">{L_all_error_messages}</a>
<!-- ELSE -->
					<a href="errorlog.php?type=distinct" class="button">{L_unique_error_messages}</a>
<!-- ENDIF -->
				</form>
			</div>
		</div>
