		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h2>{L_5436}&nbsp;&gt;&gt;&nbsp;{L_5068}</h2>
				<form name="wordlist" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">&nbsp;</div>
								<div class="col-md-9">{L_5069}</div>
							</div>
							<div class="row">
								<div class="col-md-3">{L_5070}</div>
								<div class="col-md-9">
									<input type="radio" name="wordsfilter" value="y"{WFYES}> {L_030}
									<input type="radio" name="wordsfilter" value="n"{WFNO}> {L_029}
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">{L_5071}</div>
								<div class="col-md-9">
									{L_5072}<br>
									<textarea class="form-control" name="filtervalues" cols="45" rows="15">{WORDLIST}</textarea>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act" class="centre">{L_530}</button>
				</form>
			</div>
		</div>