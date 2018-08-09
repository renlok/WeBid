
            <div style="margin-left:auto; margin-right:auto;">

</div>
<!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="{SITEURL}themes/{THEME}/img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li title="">{L_239}</li>
            <li>/</li>
            <li class="current">{PAGE_TITLE}</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End -->

    	<!-- Right Side/Main Content Start -->
    <div id="rightside">
        <!-- IF WARNINGREPORT -->
            <!-- Green Status Bar Start -->
        <div class="status error">
        	<p><img src="{SITEURL}themes/{THEME}/img/icons/icon_error.png"  alt="Error" /><span>Error!</span> {WARNINGMESSAGE}</p>
        </div>
        <!-- Green Status Bar End -->
<!-- ENDIF -->
<!-- IF ERROR ne '' -->
        <!-- Blue Status Bar Start -->
        <div class="status info">
        	<p><img src="{SITEURL}themes/{THEME}/img/icons/icon_info.png" alt="Information" /><span>Information:</span>  {ERROR}</p>
        </div>
        <!-- Blue Status Bar End -->
<!-- ENDIF -->


        <!-- Content Box Start -->
        <div class="contentcontainer">
            <div class="contentbox">
      <form name="conf" action="" method="post" enctype="multipart/form-data">
				<table width="98%" cellpadding="2" align="center" class="blank">
<!-- BEGIN block -->
					<tr valign="top">
  <!-- IF block.B_HEADER -->
						<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#0099ee;">
                        	<b>{block.TITLE}</b>
						</td>
  <!-- ELSE -->
						<td width="175">{block.TITLE}</td>
						<td style="padding:3px;">
							{block.DESCRIPTION}
	<!-- IF block.TYPE eq 'yesno' -->
				<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'batch' -->
				<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'batchstacked' -->
				<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE2}	
	<!-- ELSEIF block.TYPE eq 'datestacked' -->
				<input type="radio" name="{block.NAME}" value="USA"<!-- IF block.DEFAULT eq 'USA' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="EUR"<!-- IF block.DEFAULT eq 'EUR' --> checked<!-- ENDIF -->> {block.TAGLINE2}	
	<!-- ELSEIF block.TYPE eq 'select3num' -->
				<input type="radio" name="{block.NAME}" value="0"<!-- IF block.DEFAULT eq '0' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
				<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
				<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
	<!-- ELSEIF block.TYPE eq 'select3contact' -->
				<input type="radio" name="{block.NAME}" value="always"<!-- IF block.DEFAULT eq 'always' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
				<input type="radio" name="{block.NAME}" value="logged"<!-- IF block.DEFAULT eq 'logged' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
				<input type="radio" name="{block.NAME}" value="never"<!-- IF block.DEFAULT eq 'never' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
	<!-- ELSEIF block.TYPE eq 'text' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="80" maxlength="255">
	<!-- ELSEIF block.TYPE eq 'password' -->
				<input type="password" name="{block.NAME}" value="{block.DEFAULT}" size="50" maxlength="255">
	<!-- ELSEIF block.TYPE eq 'textarea' -->
				<textarea name="{block.NAME}" cols="80" rows="10">{block.DEFAULT}</textarea>
	<!-- ELSEIF block.TYPE eq 'days' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="4" maxlength="4"> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'percent' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="3" maxlength="3"> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'decimals' -->
				<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="5" maxlength="10"> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'yesnostacked' -->
				<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'sortstacked' -->
				<input type="radio" name="{block.NAME}" value="alpha"<!-- IF block.DEFAULT eq 'alpha' --> checked<!-- ENDIF -->> {block.TAGLINE1}
				<br><input type="radio" name="{block.NAME}" value="counter"<!-- IF block.DEFAULT eq 'counter' --> checked<!-- ENDIF -->> {block.TAGLINE2}
	<!-- ELSEIF block.TYPE eq 'checkbox' -->
				<input type="checkbox" name="{block.NAME}" id="{block.DEFAULT}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
	<!-- ELSEIF block.TYPE eq 'dropdown' -->
				<form name="{block.NAME}" action="" method="GET"<!-- IF block.DEFAULT eq 'always' --> selected<!-- ENDIF -->>
		  			<div class="Browse">
				{DROPDOWN}
	<!-- ELSEIF block.TYPE eq 'upload' -->
				<input type="file" name="{block.NAME}" size="25" maxlength="100">
				<input type="hidden" name="MAX_FILE_SIZE" value="51200">
	<!-- ELSEIF block.TYPE eq 'image' -->
				<img src="{IMAGEURL}">{block.TAGLINE1}<br>
	<!-- ELSEIF block.TYPE eq 'link' -->
				<a href="{LINKURL}">{block.TAGLINE1}</a>
	<!-- ELSE -->
				{block.TYPE}
	<!-- ENDIF -->
						</td>
  <!-- ENDIF -->
					</tr>
<!-- END block -->
				</table>
                    <input type="hidden" name="action" value="update">
                    <input type="submit" name="act" class="centre" value="{L_530}">
				</form>
            </div>
        </div>

    <!-- Right Side/Main Content End -->
<!-- INCLUDE footer.tpl -->
