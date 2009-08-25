<html>
<head>
    <link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
    <script type="text/javascript">
    $(document).ready(function() {
        $('#userfilter').change(function(){
            $('#filter').submit();
        });
    });
    </script>
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
    <td background="{SITEURL}admin/images/bac_barint.gif">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr> 
                <td width="30"><img src="{SITEURL}admin/images/i_use.gif" ></td>
                <td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="center" valign="middle">&nbsp;</td>
</tr>
<tr> 
    <td align="center" valign="middle">
        <table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
        <tr>
            <td align="center" class="title">{L_045}</td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF">
                <table width="100%" cellpadding="2" border="0">
<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="8" align="center">{ERROR}</td>
					</tr>
<!-- ENDIF -->
                    <tr>
                        <td colspan="8" bgcolor="#eeeeee">
                            <form name="search" action="" method="post">
                                {L_5022} <input type="text" name="keyword" size="25"> <input type="submit" name="submit" value="{L_5023}"> {L_5024}
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"><b>{TOTALUSERS} {L_301}</b></td>
                        <td align="right">
                            <form name="filter" id="filter" action="" method="post">
                                <select name="usersfilter" id="userfilter">
                                    <option value="all">{L_5296}</option>
                                    <option value="active" <!-- IF USERFILTER eq 'active' -->selected<!-- ENDIF -->>{L_5291}</option>
                                    <option value="admin" <!-- IF USERFILTER eq 'admin' -->selected<!-- ENDIF -->>{L_5294}</option>
                                    <option value="fee" <!-- IF USERFILTER eq 'fee' -->selected<!-- ENDIF -->>{L_5293}</option>
                                    <option value="confirmed" <!-- IF USERFILTER eq 'confirmed' -->selected<!-- ENDIF -->>{L_5292}</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <tr bgcolor="#FFCC00">
                        <td width="15%"><b>{L_293}</b></td>
                        <td width="15%"><b>{L_294}</b></td>
                        <td width="15%"><b>{L_295}</b></td>
                        <td width="15%"><b>{L_296}</b></td>
                        <td width="10%"><b>{L_25_0079}</b></td>
                        <td width="10%"><b>{L_763}</b></td>
                        <td width="10%"><b>{L_560}</b></td>
                        <td width="10%"><b>{L_297}</b></td>
                    </tr>
<!-- BEGIN users -->
                    <tr bgcolor="{users.BGCOLOUR}">
                        <td>
                        	<b>{users.NICK}</b><br>
                            &nbsp;<a href="viewuserauctions.php?id={users.ID}&offset={PAGE}" class="small">{L_5094}</a><br>
                            &nbsp;<a href="userfeedback.php?id={users.ID}&offset={PAGE}" class="small">{L_503}</a><br>
                            &nbsp;<a href="viewuserips.php?id={users.ID}&offset={PAGE}" class="small">{L_2_0004}</a>
                        </td>
                        <td>{users.NAME}</td>
                        <td>{users.COUNTRY}</td>
                        <td><a href="mailto:{users.EMAIL}">{users.EMAIL}</a></td>
                        <td align="center">{users.NEWSLETTER}</td>
                        <td align="center">{users.BALANCE}</td>
                        <td>
    <!-- IF users.SUSPENDED eq 0 -->
                            <b><span style="color:green">{L_5291}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 1 -->
                            <b><span style="color:violet">{L_5294}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 7 -->
                            <b><span style="color:red">{L_5297}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 8 -->
                            <b><span style="color:orange">{L_5292}</span></b><br>
                            <a href="listusers.php?resend=1&id={users.ID}&offset={PAGE}" class="small">{L_25_0074}</a>
    <!-- ELSEIF users.SUSPENDED eq 9 -->
                            <b><span style="color:red">{L_5293}</span></b>
    <!-- ELSEIF users.SUSPENDED eq 10 -->
                            <b><span style="color:orange"><a href="excludeuser.php?id={users.ID}&offset={PAGE}" class="small">{L_25_0136}</a></span></b>
    <!-- ENDIF -->
                        </td>
                        <td>
                            <a href="edituser.php?userid={users.ID}&offset={PAGE}" class="small">{L_298}</a><br>
                            <a href="deleteuser.php?id={users.ID}&offset={PAGE}" class="small">{L_008}</a><br>
                            <a href="excludeuser.php?id={users.ID}&offset={PAGE}" class="small">
    <!-- IF users.SUSPENDED eq 0 -->
                                {L_300}
    <!-- ELSE -->
                                {L_310}
    <!-- ENDIF -->
                            </a><br>
                            <a href="listusers.php?payreminder=1&id={users.ID}&offset={PAGE}" class="small">{L_764}</a>
                        </td>
                    </tr>
<!-- END users -->
                </table>
                <div class="white" align="center">
                    <p>{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</p>
<!-- IF PAGE gt 1 -->
                    <a href="?PAGE={PREV}"><u>{L_5119}</u></a>&nbsp;&nbsp;
<!-- ENDIF -->
<!-- BEGIN pages -->
    <!-- IF PAGE eq pages.COUNTER -->
                    <b>{COUNTER}</b>&nbsp;&nbsp;
    <!-- ELSE -->
                    <a href="?PAGE={COUNTER}"><u>{COUNTER}</u></a>&nbsp;&nbsp;
    <!-- ENDIF -->
<!-- END pages -->
<!-- IF PAGE lt PAGES -->
                    <a href="?PAGE={NEXT}"><u>{L_5120}</u></a> 
<!-- ENDIF -->
                </div>
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->