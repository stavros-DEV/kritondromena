<?php
	header('Content-Type: text/html; charset=utf-8');
	require("../inc/common.php");
	//$id = $_GET["artId"];
	$event = new Event();
	$evrow = $event->getEventsById('82');
	$event->getRef_Image();
	//r($event->data);
	
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
	<div class="hidden-xs">
		<?php require("../inc_view/topSearchEnginePost.php"); ?>
	</div>
	<div class="container" id="message" align="center">
	  	<div class="row">
			<div class="col-xs-12">
		  		<div class="row result <?= $event->data['ID'] ?>">
				    <div class="row evTitle">
					  <div class="col-xs-12">
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
		</div>
	</div>
</body>
<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_resources.php"); ?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="../resources/js/gmaps.js"></script>
</html>