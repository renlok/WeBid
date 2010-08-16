<!-- INCLUDE header.tpl -->
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<div class="box">
                	<h4 class="rounded-top">{L_5436}</h4>
                    <div class="rounded-bottom">
                    	<ul class="menu">
                        	<li><a href="{SITEURL}admin/maintainance.php">{L__0001}</a></li>
                        	<li><a href="{SITEURL}admin/wordsfilter.php">{L_5068}</a></li>
                        	<li><a href="{SITEURL}admin/errorlog.php">{L_891}</a></li>
                        </ul>
                    </div>
                </div>
            	<div class="box">
                	<h4 class="rounded-top">Something</h4>
                    <div class="rounded-bottom">
                    	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tincidunt varius elit non dapibus. Donec nec mauris quis metus volutpat pellentesque. Mauris justo lacus, porttitor non commodo non, tincidunt et velit. Suspendisse nulla elit, laoreet sit amet gravida vitae, iaculis interdum massa. Aliquam pretium turpis quis odio posuere id molestie risus adipiscing. Suspendisse nisi purus, feugiat quis pellentesque non, ultricies sed metus. Sed mollis leo et leo auctor gravida. Aenean accumsan lacus ut erat viverra bibendum. Nulla eu gravida quam. Phasellus sit amet est massa. Nulla pellentesque facilisis velit dignissim euismod. Sed tincidunt quam eget lorem placerat commodo. Proin ultrices, lectus rutrum posuere tincidunt, ante urna vulputate nulla, id malesuada risus nulla ut odio.
                    </div>
                </div>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_2_0017}&nbsp;&gt;&gt;&nbsp;{L_2_0020}</h4>
				<form name="errorlog" action="" method="post">
<!-- IF ERROR ne '' -->
					<div class="error-box"><b>{ERROR}</b></div>
<!-- ENDIF -->
                    <table width="98%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td bgcolor="#FFFF66" colspan="5">
                                {L_2_0021}
                                <input type="text" name="ip">
                                <input type="submit" name="Submit2" value="&gt;&gt;">
                                {L_2_0024}
                            </td>
                        </tr>
                        <tr>
                            <th width="29%"><b>{L_087}</b></td>
                            <th width="25%"><b>{L_2_0009}</b></td>
                            <th width="19%"><b>{L_560}</b></td>
                            <th width="18%"><b>{L_5028}</b></td>
                            <th width="9%"><b>{L_008}</b></td>
                        </tr>
<!-- BEGIN ips -->
                        <tr {ips.BG}>
                            <td>{L_2_0025}</td>
                            <td align="center">{ips.IP}</td>
                            <td align="center"> 
    <!-- IF ips.ACTION eq 'accept' -->
                            	{L_2_0012}
    <!-- ELSE -->
                            	{L_2_0013}
    <!-- ENDIF -->
                            </td>
                            <td> 
    <!-- IF ips.ACTION eq 'accept' -->
                                <input type="checkbox" name="deny[]" value="{ips.ID}">
                                &nbsp;{L_2_0006}
    <!-- ELSE -->
                                <input type="checkbox" name="accept[]" value="{ips.ID}">
                                &nbsp;{L_2_0007}
    <!-- ENDIF -->
                            </td>
                            <td align="center"><input type="checkbox" name="delete[]" value="{ips.ID}"></td>
<!-- BEGINELSE -->
                            <td colspan="5">{L_831}</td>
<!-- END ips -->
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="submit" name="act" class="centre" value="{L_2_0015}">
				</form>
            </div>
        </div>
<!-- INCLUDE footer.tpl -->