<?php
	header('Content-Type: text/html; charset=utf-8');
	require("../inc/common.php");
	//$id = $_GET["artId"];
	$event = new Event();
	$evrow = $event->getEventsById('82');
	$event->getRef_Image();
	r($event->data);
	
?>

<!DOCTYPE html>
<html>

<head>
	<title>Πολιτιστικές Εκδηλώσεις από το Κρητών Δρώμενα</title>
	<meta name="description" content="<?= $event->data['Title'] ?>">
	<meta name="keywords" content="Αναζήτηση Κρητικών εκδηλώσεων και κρητικών χορών.">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις δρώμενα και χοροί.">
	<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_metas.php"); ?>
</head>

<body>
	<?php require("../inc/header.php");	?>
	
	<div class="container custom-container" align="center">
	  	<div class="row">
	  		<div class="col-sm-9">
	  		  	<div class="global-column global-main-column">
			  		
			  		<div class="row">
						<div class="col-xs-12 evTitle">
							<h1 class="event-heading"><?= $event->data['Title'] ?></h1>
							<div class="evDate">
								Στις <?= $event->data['EventDate'] ?>
							</div>
						</div>
					</div>
					<hr/>
			
					<div class="row details">
					  <div class="col-xs-12 col-sm-5">
						<div class="row evPlace">
							<?= $event->data['Place'] ?>
						</div>
						<div class="row evMap" >
							<div class="showMap" id="showMap" >
								<input class="lng" type="hidden" value="<?= $event->data['Lng'] ?>" />
								<input class="lat" type="hidden" value="<?= $event->data['Lat'] ?>" />
							</div>
							<div id="map-canvas"></div>
						</div>
					  </div>
					  <div class="col-xs-12 col-sm-7 evDescription" >
						<?= $event->data['Description'] ?>
					  </div>
					</div>
		  		
		  	  	</div>
			</div>
			<div class="col-sm-3">
	  			<div class="global-column global-right-column">
	  				<div class="tse-header-container">
	  					<div class="row"><span class="tse-header tse-header-main">ΑΝΑΖΗΤΗΣΗ</span></div>
	  					<div class="row"><span class="tse-header tse-header-second">ΚΡΗΤΙΚΗΣ ΕΚΔΗΛΩΣΗΣ</span></div>
	  				</div>
	  				<div class="tse-search-container">
	  				<div class="row">
	  					<div class="">
							<form class="form-inline" action="/events/" accept-charset="UTF-8" enctype="multipart/form-data" method="post" id="tseFormPost">
								<select class="se-inputs custom-select" id="tseLocation" name="loc">
									<option value="any">Οπουδήποτε</option>
								    <option value="Χανιά">Χανιά</option>
								    <option value="Ρέθυμνο">Ρέθυμνο</option>
								    <option value="Ηράκλειο">Ηράκλειο</option>
								    <option value="Λασίθι">Λασίθι</option>
								</select>
								<div class="date datepicker no-padding datepickerWeather" id="datetimepicker2">
									<input type="text" class="dateText se-inputs" name="dateSelector" id="tseDate"/>
									<span class="input-group-addon calendar-custom"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<input type="submit" class="se-inputs custom-btn" value="ΑΝΑΖΗΤΗΣΗ"/>
						  	</form>
						</div>
	  				</div>
	  				</div>
	  			</div>
	  		</div>
		</div>
	</div>
</body>
<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_resources.php"); ?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="../resources/js/gmaps.js"></script>
</html>