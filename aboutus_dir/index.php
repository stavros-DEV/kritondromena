<html>

<head>
	<title>Δρώμενα</title>
	<meta name="description" content="">
	<meta content="" name="keywords">
	<meta name="page-topic" content="">
	<?php require("../inc/resources.php"); ?>
</head>

<body>
	<?php require("../inc/header.php"); ?>
	<div class="hidden-xs">
	  <?php require("../inc_view/topSearchEnginePost.php"); ?>
	</div>
	<div class="container" id="message" align="center">
	  <div class="row result">
		<div class="row evTitle">
			<div class="col-xs-12">
				<h1>Σχετικα με εμας</h1>
			</div>
		</div><hr/>
		<div class="col-md-6">
		
		</div>
		<div class="col-md-6">
		  <form class="form-horizontal" action="" id="contactus-form" novalidate >			  
			  <div class="col-xs-12 actionResult">
			  
			  </div>
			  <div class="col-xs-12">
				<input type="text" class="form-control contact-form" id="msg-name" name="eventTitleN" placeholder="Όνομα" required/>
			  </div>
			  <div class="col-xs-12">
				<input type="text" class="form-control contact-form" id="msg-email" name="eventEmailN" placeholder="E-mail" required>
			  </div>
			  <div class="col-xs-12">
			    <textarea class="form-control contact-form" rows="10" id="msg-text" name="eventDescriptionN" placeholder="Το Μύνημά σας." lang="el" spellcheck="true" required></textarea>
			  </div>
			  <div class="col-xs-12">
				<button type="submit" class="btn btn-block btn-primary" id="enterEvent">Επικοινωνήστε μαζί μας</button>
			  </div>

		  </form>
		</div>
	  </div>
	</div>
</body>

</html>
