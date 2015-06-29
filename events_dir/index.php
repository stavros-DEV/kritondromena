<!DOCTYPE html>
<html>

<head>
	<title>Καταχώρηση Δρώμενου</title>
	<?php require("../inc/resources.php"); ?>
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="../resources/js/gmaps.js"></script>
	
</head>

<body>
	<?php require("../inc/header.php"); ?>
	<div class="topSearchEngine">
	  <form class="form-inline">
		<select class="tseInputFields" id="tseLocation">
			<option>Οπουδήποτε</option>
		   <option>Χανιά</option>
		   <option>Ρέθυμνο</option>
		   <option>Ηράκλειο</option>
		   <option>Λασίθι</option>
		   <option>Αλλού</option>
		</select>
		<div class="date datepicker no-padding datepickerWeather tseDateDiv" id="datetimepicker1">
			<input type="text" class="dateText tseInputFields" name="dateSelector" id="eventDate"/>
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
		<input type="text" class="tseInputFields" id="tseDate"/>
		<input type="submit" class="tseInputFields" id="tseSubmit" value="Αναζήτηση"/>
	  </form>
	</div>
	<div class="container" id="message" align="center">
	  <div class="row">
		<div class="col-xs-12">
		  <h1>ΠΑΡΟΥΣΙΑΣΗ ΑΠΟΤΕΛΕΣΜΑΤΩΝ</h1>
		  <p>Το Portal kritondromena.gr θα είναι κοντά σας στις 01.08.2015</p>
		  
		  <?php require("getEvents.php"); ?>
		  
		  <?php $i = 0; while($row = $res->fetch_assoc()) : ?>
		  
		  <div class="row result">		  
		    <div class="row evTitle">
			  <div class="col-xs-12">
				<a href="<?= $row['Url'] ?>" title="<?= $row['Title'] ?>"><?php echo $row['Title'] ?></a>
				<div class="evDate">
					Στις <?php echo $row['EventDate'] ?>
				</div>
				
			  </div>
			  
			</div>
			<hr/>
			<div class="row details">
			  <div class="col-xs-12 col-sm-5">
				
				<div class="row evPlace">
					<?php echo $row['Place'] ?>
				</div>
				<div class="row evMap" >
					<div class="showMap" id="showMap<?php echo $i; ?>" >
						<input type="hidden" value="<?php echo $i; ?>" />
						<input class="lng" type="hidden" value="<?php echo $row['Lng'] ?>" />
						<input class="lat" type="hidden" value="<?php echo $row['Lat'] ?>" />
						<button type="submit" class="btn btn-block-custom btn-primary" >Εμφάνιση στο χάρτη</button>
					</div>
					<div id="map-canvas<?php echo $i; ?>"></div>
				</div>
			  </div>
			  <div class="col-xs-12 col-sm-7 evDescription" >
				<?php echo $row['Description'] ?>
				<a href="<?= $row['Url'] ?>" class="btn btn-block btn-default" >Περισσότερα</a>
			  </div>
			</div>
			
		  </div>
		  <?php $i++; endwhile; ?>
		  
		</div>
	  </div>
	</div>
</body>

</html>
