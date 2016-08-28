<script type="text/JavaScript">
$(".form1").submit(function(){
	if ($(".to").val() == "")
	{
		return false;
	}
	if ($(".subject").val() == "")
	{
		return false;
	}
	if ($(".message").val() == "")
	{
		return false;
	}
	return true;
});
</script>
<div class="well">
	<form class="form-horizontal" name="form1" id="form1" method="post" action="mail.php">
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<div class="form-group">
			<label for="to" class="col-sm-2 control-label">{L_241}:</label>
			<div class="col-sm-10">
				<input name="sendto" type="text" class="form-control" value="{REPLY_TO}" id="to">
			</div>
		</div>
		<div class="form-group">
			<label for="subject" class="col-sm-2 control-label">{L_332}:</label>
			<div class="col-sm-10">
				<input name="subject" type="text" value="{REPLY_SUBJECT}" id="subject" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="message" class="col-sm-2 control-label">{L_333}:</label>
			<div class="col-sm-10">
				<textarea name="message" rows="5" id="message" class="form-control"></textarea>
			</div>
		</div>
		<div class="text-center">
<!-- IF B_QMKPUBLIC -->
			<div class="checkbox">
				<label><input type="checkbox" name="public"{REPLY_PUBLIC}> {L_543}</label>
			</div>
			<input type="hidden" name="is_question" value="0">
<!-- ENDIF -->
			<input type="hidden" name="hash" value="{HASH}">
			<input class="btn btn-primary" name="submit" type="submit" value="{L_submit}">
		</div>
	</form>
</div>
<div class="text-center">
<!-- IF B_CONVO -->
	<br>
	<div style="overflow:scroll; min-height:100px; max-height:500px;">
	<!-- BEGIN convo -->
		<div style=" padding: 5px; {convo.BGCOLOUR}">
			{convo.MSG}
		</div>
	<!-- END convo -->
	</div>
<!-- ENDIF -->
</div>
<br>