<!DOCTYPE html>
<html lang="en">
<head>
	<title>WeBid Administration back-end</title>
	<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="generator" content="WeBid">

	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/style.css">
	<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/jquery.lightbox.css" media="screen">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>

	<script src="{SITEURL}js/jquery.js"></script>
</head>
<body id="{CURRENT_PAGE}">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-4">&nbsp;</div>
			<div class="col-md-4 well">
<!-- IF ERROR ne '' -->
				<div class="alert alert-danger" role="alert"><b>{ERROR}</b></div>
<!-- ENDIF -->
				<form action="" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<div class="row">
						<div class="col-md-12">
							{L_delete_category_move_auctions}
							<table cellpadding="0" cellspacing="0">
	<!-- BEGIN categories -->
		<!-- IF categories.HAS_CHILDREN -->
								<tr>
									<td>{categories.NAME}</td><td>
										<select name="delete[{categories.ID}]">
											<option value="delete">{L_008}</option>
											<option value="move">{L_840}: </option>
										</select>
									</td>
									<td><input type="text" size="5" name="moveid[{categories.ID}]"></td>
								</tr>
		<!-- ELSE -->
								<input type="hidden" name="delete[{categories.ID}]" value="delete">
		<!-- ENDIF -->
	<!-- END categories -->
							</table>
							<p>{L_this_cannot_be_undone}</p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary" type="submit" name="action" value="Yes">{L_yes}</button>
							<button class="btn btn-primary" type="submit" name="action" value="No">{L_no}</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-4">&nbsp;</div>
		</div>
