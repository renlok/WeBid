<div style="width:25%; float:left;">
	<div style="margin-left:auto; margin-right:auto;">
		<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
	</div>
</div>
<div style="width:75%; float:right;">
	<div class="main-box">
		<h4 class="rounded-top rounded-bottom">{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_445}</h4>
		<form name="errorlog" action="" method="post">
			<div class="info-box">{L_1142}</div>
			<p>{L_1143}</p>
			<table width="98%" cellpadding="0" cellspacing="0" class="blank">
<!-- BEGIN gateways -->
				<tr>
					<th colspan="2"><b>{gateways.NAME}</b></th>
				</tr>
				<tr>
					<td width="50%">
						<input type="hidden" name="{gateways.PLAIN_NAME}[id]" value="{gateways.GATEWAY_ID}">
						<a href="{gateways.WEBSITE}" target="_blank">{gateways.ADDRESS_NAME}</a>:<br><input type="text" name="{gateways.PLAIN_NAME}[address]" value="{gateways.ADDRESS}" size="50">
<!-- IF gateways.B_PASSWORD -->
						<p>{gateways.PASSWORD_NAME}:<br><input type="text" name="{gateways.PLAIN_NAME}[password]" value="{gateways.PASSWORD}" size="50"></p>
<!-- ELSE -->
						<input type="hidden" name="{gateways.PLAIN_NAME}[password]" value="">
<!-- ENDIF -->
					</td>
					<td>
						<p><input type="checkbox" name="{gateways.PLAIN_NAME}[required]"{gateways.REQUIRED}> {L_446}</p>
						<p><input type="checkbox" name="{gateways.PLAIN_NAME}[active]"{gateways.ENABLED}> {L_447}</p>
					</td>
				</tr>
<!-- END gateways -->
			</table>
			<input type="hidden" name="action" value="update">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<input type="submit" name="act" class="centre" value="{L_530}">
		</form>
	</div>
</div>
