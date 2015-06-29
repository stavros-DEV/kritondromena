<?php 
	header('Content-Type: text/html; charset=utf-8');
	if(isset($_POST["eventTitleN"]) && isset($_POST["eventPlaceN"]) && isset($_POST["dateSelector"]) && isset($_POST["eventDescriptionN"]) && isset($_POST["eventEmailN"])) {
		require("addEvent.php");
	}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Κρητών Δρώμενα: Πολιτισμός και Παραδόση σε ένα site</title>
	<?php require("../inc/resources.php"); ?>
</head>

<body>
	<div class="container" id="message">
	<?php require("../inc/header.php"); ?>
	<div class="row"><div class="col-xs-12">
		<h1>ΚΡΗΤΩΝ ΔΡΩΜΕΝΑ</h1>
		Το Portal kritondromena.gr θα είναι κοντά σας στις 01.08.2015
		<br/><br/>
		<div class="eventDetails">
		  <form class="form-horizontal" method="POST" id="eventsForm" role="form" accept-charset="UTF-8" enctype="multipart/form-data" >
		    <?php if (!isset($fail)) : ?>
			<?php elseif ($fail) : ?>
				<div class="alert alert-success fade in">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  Το δρώμενο σας καταχωρήθηκε στο σύστημα με επιτυχία!
				  <?php echo $errorMsg; ?>
				</div>
			<?php else : ?>
				<div class="alert alert-danger fade in">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  Υπήρξε κάποιο πρόβλημα, κατά την καταχώρηση του δρώμενου. Παρακαλείσθε όπως επικοινωνήσετε μαζί μας.
				</div>
			<?php endif; ?>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="eventTitle">Τίτλος Δρώμενου</label>
			  <div class="col-sm-6">
				<input type="text" class="form-control" id="eventTitle" name="eventTitleN" placeholder="π.χ. Γλέντι Χορευτικού Σύλλογου Χανίων" required>
			  </div>
			  <label class="control-label col-sm-1" for="eventTitle">Εικόνα/ες</label>
			  <div class="col-sm-3">
			    <div class="input-group">
                  <span class="input-group-btn">
                    <span class="btn btn-info btn-file">
                        Επιλογή&hellip; <input type="file" name="eventImageN" accept="image/*" multiple>
                    </span>
                  </span>
                  <input type="text" class="form-control" readonly/>
				</div>
			  </div>
			</div>
			<div class="form-group">
			  
			  <label class="control-label col-sm-2" for="eventPlace">Τοποθεσία</label>
			  <div class="col-sm-6" id="placeGlyph">
				<input type="text" class="form-control inline" id="eventPlace" name="eventPlaceN" placeholder="π.χ Κουρνάς Χανίων" required/>
				<span class="glyphicon form-control-feedback"></span>
				<input type="hidden" id="eventLng" name="eventLngN" /><input type="hidden" id="eventLat" name="eventLatN" />
			  </div>
			  
			  <label class="control-label col-sm-1" for="eventDate">Ημερομηνία</label>
			  <div class="col-sm-3">
				<div class="input-group date datepicker no-padding datepickerWeather" id="datetimepicker1">
				  <input type="text" class="form-control dateText" name="dateSelector" id="eventDate"/>
				  <span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				  </span>
				</div>
			  </div>
			  
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="eventDescription">Περιγραφή<br/>(τουλ. 40 λέξεις)</label>
				<div class="col-sm-10">
				  <textarea class="form-control" rows="10" id="eventDescription" name="eventDescriptionN" placeholder="Αναλυτικά οι πληροφορίες για το δρώμενο." lang="el" spellcheck="true" required></textarea>
				</div>
				<div class="row"><div class="col-sm-offset-2 col-sm-10" id="wordsInfo"></div></div>
			</div>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="eventEmail">E-mail</label>
			  <div class="col-sm-10">
				<input type="text" class="form-control" id="eventEmail" name="eventEmailN" placeholder="π.χ nikos@hotmail.com" required>
			  </div>
			</div>
			<div class="form-group">        
			  <div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-block btn-primary" id="enterEvent">Καταχώρηση Δρώμενου</button>
			  </div>
			</div>
		  </form>
		</div>
	  </div></div>
	</div>
</body>

</html>
