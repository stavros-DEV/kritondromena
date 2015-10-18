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
	<?php require("../inc/resources.php"); ?>
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="../resources/js/gmaps.js"></script>
	
</head>

<body>
	<?php require("../inc/header.php");	?>
	<div class="hidden-xs">
	  <?php require("../inc_view/topSearchEnginePost.php"); ?>
	</div>
	<div class="container" id="message" align="center">
	  <div class="row">
		<div class="col-xs-12">
		  <div class="main-landing-message">
		    <h1><?= $event->data['Title'] ?></h1>
		  </div>
		  
		  <div id="defaultResults">
		  
		  <div class="row result <?= $event->data['ID'] ?>">
		    <div class="row evTitle">
			  <div class="col-xs-12">
				<?= $event->data['Title'] ?>
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
				<!--  <div class="row evMap" >
					<div class="showMap" id="showMap<?php echo $i; ?>" >
						<input type="hidden" value="<?php echo $i; ?>" />
						<input class="lng" type="hidden" value="<?= $event->data['Lng'] ?>" />
						<input class="lat" type="hidden" value="<?= $event->data['Lat'] ?>" />
						<?php if(!empty($row['Lng']) && !empty($row['Lat'])){ ?>
						<button type="submit" class="btn btn-block-custom btn-primary" >Εμφάνιση στο χάρτη</button>
						<?php } ?>
					</div>
					<div id="map-canvas<?php echo $i; ?>"></div>
				</div>-->
			  </div>	
			  <div class="col-xs-12 col-sm-7 evDescription" >
				<?= $event->data['Description'] ?>
				<!--<a href="" class="btn btn-block btn-default" >Περισσότερα</a>-->
			  </div>
			</div>
			
		  </div>
		  
		  </div>
		  
		  <div id="ajaxLoading"></div>
		  <div id="ajaxResults"></div>
		</div>
	  </div>
	</div>
</body>

</html>
