<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_205}
		</div>

		<table width="100%" cellpadding="0" cellspacing="0" class="notd">
		<tr>
			<td>
			<dl class="tabs">
				<dd><a href="{SITEURL}user_menu.php?cptab=summary">{L_25_0080}</a></dd>  
				<dd><a href="{SITEURL}user_menu.php?cptab=account">{L_25_0081}</a></dd>  
<!-- IF B_CAN_SELL -->
				<dd><a href="{SITEURL}user_menu.php?cptab=selling">{L_25_0082}</a></dd>	
<!-- ENDIF -->
				<dd><a href="{SITEURL}user_menu.php?cptab=buying">{L_25_0083}</a></dd> 	   
			</dl>
			</td>
		</tr>
		<tr>
			<td>
			<div class="titTable4">
				{L_200}<b>{YOURUSERNAME}</b> [<a href="{SITEURL}logout.php">{L_245}</a>]
			</div>
<!-- IF B_MENUTITLE -->
			<div class="titTable4">
				{UCP_TITLE}
			</div>
<!-- ENDIF -->
			<div class="table2">
<!-- IF B_ISERROR -->
				<p class="errfont" style="background-color;#FF9933;display:block">{UCP_ERROR}</p>
<!-- ENDIF -->
			</div>
			</td>
		</tr>
		</table>
