<?php
	echo '<nav class="navbar navbar-default navbar-fixed-top" id="topNavigation">
		  <div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Αρχικη</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="topNavLi" id="li_events"><a href="/events/">Κρητων Δρωμενα<span class="sr-only">(current)</span></a></li>
				<li class="topNavLi" id="li_addevent"><a href="/new-event/">Καταχωρηση Δρωμενου</a></li>
				<li class="topNavLi" id="li_about"><a href="/about-us/">Σχετικα με εμας</a></li>
			  </ul>
			</div>
		</div>
	</nav>';
?>