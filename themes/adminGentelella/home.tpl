<!-- top tiles -->

<div class="row tile_count">
  <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
    <div class="left"></div>
    <div class="right"> <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
      <div class="count">{C_UUSERS}</div>
      <span class="count_bottom"><i class="green">4% </i> From last Week</span> </div>
  </div>
  <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
    <div class="left"></div>
    <div class="right"> <span class="count_top"><i class="fa fa-clock-o"></i> Total Bids</span>
      <div class="count">{C_BIDS}</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> </div>
  </div>
  <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
    <div class="left"></div>
    <div class="right"> <span class="count_top"><i class="fa fa-user"></i> Total Visits</span>
      <div class="count green">{A_UVISITS}</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> </div>
  </div>
  <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
    <div class="left"></div>
    <div class="right"> <span class="count_top"><i class="fa fa-user"></i> Page Views</span>
      <div class="count">{A_PAGEVIEWS}</div>
      <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> </div>
  </div>
  <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
    <div class="left"></div>
    <div class="right"> <span class="count_top"><i class="fa fa-user"></i> Closed Bids</span>
      <div class="count">{C_CLOSED}</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> </div>
  </div>
  <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
    <div class="left"></div>
    <div class="right"> <span class="count_top"><i class="fa fa-user"></i> Bids on Live Auctions</span>
      <div class="count">{C_AUCTIONS}</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> </div>
  </div>
</div>
<!-- /top tiles --> 

<br />
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
  <div class="x_title">
                                    <h2>{L_25_0010} <i class="fa fa-angle-double-right"></i> {L_525}</h2>
                                    <div class="clearfix"></div>
                                </div>
    <div class="col-md-8"> 
      
      <!-- IF UPDATE_AVAILABLE -->
      <div class="info-box">{L_current_version}</div>
      <!-- ELSE -->
      <div class="alert alert-info info-box fade in" role="alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> {L_outdated_version}</div>
      <!-- ENDIF --> 
      <table class="table table-bordered table-striped" align="center">
        <tr>
          <th colspan="4">{L_25_0025}</th>
        </tr>
        <tr>
          <td><strong>{L_site_url}</strong></td>
          <td>{SITEURL}</td>
        </tr>
        <tr>
          <td><strong>{L_site_name}</strong></td>
          <td>{SITENAME}</td>
        </tr>
        <tr>
          <td><strong>{L_admin_email}</strong></td>
          <td>{ADMINMAIL}</td>
        </tr>
        <tr>
          <td><strong>{L_25_0026}</strong></td>
          <td>{CRON}</td>
        </tr>
        <tr>
          <td><strong>{L_663}</strong></td>
          <td>{GALLERY}</td>
        </tr>
        <tr>
          <td><strong>{L_2__0025}</strong></td>
          <td>{BUY_NOW}</td>
        </tr>
        <tr>
          <td><strong>{L_default_currency}</strong></td>
          <td>{CURRENCY}</td>
        </tr>
        <tr>
          <td><strong>{L_25_0035}</strong></td>
          <td>{TIMEZONE}</td>
        </tr>
        <tr>
          <td><strong>{L_date_format}</strong></td>
          <td>{DATEFORMAT} <small>({DATEEXAMPLE})</small></td>
        </tr>
        <tr>
          <td><strong>{L_default_country}</strong></td>
          <td>{DEFULTCONTRY}</td>
        </tr>
        <tr>
          <td><strong>{L_multilingual_support}</strong></td>
          <td><!-- BEGIN langs -->
            
            <p>{langs.LANG}<!-- IF langs.B_DEFAULT --> ({L_current_default_language})<!-- ENDIF --></p>
            
            <!-- END langs --></td>
        </tr>
        <tr>
          <td><strong>{L_30_0214}</strong></td>
          <td>{THIS_VERSION} ({CUR_VERSION})</td>
        </tr>
      </table>
      <table width="98%" cellpadding="1" cellspacing="0">
        <tr>
          <th colspan="4">{L_25_0031}</th>
        </tr>
        <tr>
          <td width="25%"><strong>{L_25_0055}</strong></td>
          <td width="25%">{C_USERS}</td>
          <td width="25%"><strong>{L_25_0055}</strong></td>
          <td width="25%"><!-- IF USERCONF eq 0 --> 
            <strong>{L_893}</strong>: {C_IUSERS}<br>
            <strong>{L_892}</strong>: {C_UUSERS} (<a href="{SITEURL}admin/listusers.php?usersfilter=admin_approve">{L_5295}</a>) 
            <!-- ELSE --> 
            {C_IUSERS} 
            <!-- ENDIF --></td>
        </tr>
        <tr class="bg">
          <td><strong>{L_25_0057}</strong></td>
          <td>{C_AUCTIONS}</td>
          <td><strong>{L_354}</strong></td>
          <td>{C_CLOSED}</td>
        </tr>
        <tr>
          <td><strong>{L_25_0059}</strong></td>
          <td>{C_BIDS}</td>
          <td><strong>{L_25_0063}</strong></td>
          <td><p><strong>{L_5161}</strong>: {A_PAGEVIEWS}</p>
            <p><strong>{L_5162}</strong>: {A_UVISITS}</p>
            <p><strong>{L_5163}</strong>: {A_USESSIONS}</p></td>
        </tr>
      </table>
      <table width="98%" cellpadding="1" cellspacing="0">
        <tr>
          <th colspan="2">{L_080}</th>
        </tr>
        <tr>
          <td width="70%">{L_clear_cache_explain}</td>
          <td><form action="?action=clearcache" method="post">
              <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
              <input type="submit" name="submit" value="{L_clear_cache}" class="btn btn-danger">
            </form></td>
        </tr>
        <td width="70%">{L_clear_image_cache_explain}</td>
          <td><form action="?action=clear_image_cache" method="post">
              <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
              <input type="submit" name="submit" value="{L_clear_image_cache}" class="btn btn-danger">
            </form></td>
        </tr>
        <tr class="bg">
          <td>{L_1030}</td>
          <td><form action="?action=updatecounters" method="post">
              <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
              <input type="submit" name="submit" value="{L_1031}" class="btn btn-danger">
            </form></td>
        </tr>
      </table>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <h4>{L_1061}</h4>
        <form name="anotes" method="post">
          <textarea name="anotes" class="form-control">{ADMIN_NOTES}</textarea>
          <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}" class="form-control">
          <input type="submit" name="act" value="{L_submit}" class="btn btn-default">
        </form>
      </div>
    </div>
  </div>
  </div>
  <!--col-md-12 col-sm-12 col-xs-12--> 
</div>
<!--./row--> 
<!--right_col--> 
<!-- INCLUDE footer.tpl -->
