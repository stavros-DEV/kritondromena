<?php
	header('Content-Type: text/html; charset=utf-8');
	require("../inc/common.php");
	$event = new Event();
	$evrow = $event->getEventsById($_GET['id']);
	$event->getRef_Image();
	
?>

<!DOCTYPE html>
<html>

<head>
	<title>Πολιτιστικές Εκδηλώσεις από το Κρητών Δρώμενα</title>
	<meta name="description" content="<?= $event->data['Title'] ?>">
	<meta name="keywords" content="Αναζήτηση Κρητικών εκδηλώσεων και κρητικών χορών.">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις δρώμενα και χοροί.">
	<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_metas.php"); ?>
	<link rel="stylesheet" href="../resources/css/lightbox.min.css">
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
			
					<div class="row">
						<div class="col-xs-12">
							<a class="example-image-link" href="<?= $event->data['IMAGE']['Location'] ?>" data-lightbox="example-1">
								<img class="kd-image example-image" src="<?= $event->data['IMAGE']['Location'] ?>" alt="<?= $event->data['IMAGE']['Description'] ?>" title="<?= $event->data['IMAGE']['Description'] ?>" />
							</a>
						</div>
					</div>
			
					<div class="row details">
					  	<div class="col-xs-12">
					  		<div class="event-location">
								<div class="row evPlace">
									<div class="col-xs-12">
									<?= $event->data['Place'] ?>
									</div>
								</div>
								<div class="row evMap" >
									<div class="col-xs-12">
									<div class="showMap" id="showMap" >
										<input class="lng" type="hidden" value="<?= $event->data['Lng'] ?>" />
										<input class="lat" type="hidden" value="<?= $event->data['Lat'] ?>" />
									</div>
									</div>
									<div id="map-canvas"></div>
								</div>
						  	</div>
						  	
						  	<div class="evDescription" >
								<?= $event->data['Description'] ?>
							</div>
					  	</div>
					</div>
		  	  	</div>
			</div>
			<div class="col-sm-3">
	  			<div class="global-column global-right-column">
	  				<?php require($_SERVER['DOCUMENT_ROOT']."inc_view/topSearchEngineRight.php"); ?>
	  			</div>
	  		</div>
	  		
		</div>
	</div>
<script src="../resources/js/lightbox-plus-jquery.min.js"></script>
<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_resources.php"); ?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="../resources/js/gmaps.js"></script>

</body>
</html>