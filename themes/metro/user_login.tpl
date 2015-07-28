<div class="content">
	<div class="titTable2">
	<h5>{L_181}</h5>
	</div>
	<div class="table2">
<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
<!-- ENDIF -->
		<div class="padding centre">
        <table width="676" border="0" cellpadding="6">
            <tr>
                <td width="301">
                    <h3>{L_862}</h3>

                    <form name="user_login" action="{SSLURL}user_login.php" method="post">
			<div class="input-control modern text iconic">                        
			<input type="text" name="username" size="20" maxlength="20"></p>
			<span class="label">{L_187}</span>
			<span class="informer">Please enter your username</span>
			<span class="icon mif-user"></span>
			</div>
        
			<div class="input-control modern text iconic">
                        <input type="password" name="password" size="20" maxlength="20" value=""></p>
			<span class="label">{L_004}</span>
			<span class="icon mif-lock"></span>
                        <button class="button helper-button reveal"><span class="mif-looks"></span></button>   
</div>
<p>
                        <input type="submit" name="input" value="Login" class="button">
                        <input type="hidden" name="action" value="login">
                        <input type="checkbox" name="rememberme" value="1">&nbsp;{L_25_0085}</p>
                        <p><a href="forgotpasswd.php">{L_215}</a></p>
                    </form>
                </td>
                <td width="339">
                    {L_863}
                </td>
            </tr>
        </table>
        </div>
	</div>
</div>
