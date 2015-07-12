<?php 
	require("events_dir/getEvents.php");

?>

<!DOCTYPE html>
<html>

<head>
	<title>Κρητών Δρώμενα: Πολιτισμός και Παραδόση σε ένα site</title>
	<?php require("inc/resources.php"); ?>
	<!--<script src="resources/js/jssor.slider.mini.js"></script>-->
</head>

<body>
	<?php require("inc/header.php"); ?>
	<div class="hidden-xs">
	  <?php require("inc_view/topSearchEnginePost.php"); ?>
	</div>
	<div class="container" id="message" align="center">
	  <div class="row">
	    <div class="col-md-12 main-landing-message">
		
		<h1>ΚΡΗΤΩΝ ΔΡΩΜΕΝΑ</h1>
		Το Portal kritondromena.gr θα είναι κοντά σας στις 01.08.2015
		<!--<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px;">
			 Slides Container 
			<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 600px; height: 300px;">
				<div><img u="image" src2="resources/images/kritonbg.jpg" />tileei</div>
				<div><img u="image" src2="resources/images/df.jpg" />xairetw</div>
			</div>
		</div>-->
		</div>
	  </div>
	  
	  <div class="row">
		<div class="col-md-6 home-custom-column">
			<div class="home-columns home-left-column">
				<div class="evTitle"><h3>Κρητών Δρώμενα</h3></div><hr/>
				<?php $i = 0; while($row = $res->fetch_assoc()) : ?>
				  <div class="row">
					<div class="home-events-title">
						<a href="/events/#event<?= $row['ID'] ?>"><?php echo $row['Title'] ?></a>
					</div>
					<div class="home-events-date">
						<?php echo $row['EventDate'] ?>
					</div>
				  </div>
				<?php $i++; endwhile; ?>
			</div>
		</div>
		
		<div class="col-md-6 home-custom-column">
			<div class="home-columns home-right-column">
				<div class="evTitle"><h3>Κείμενα</h3></div><hr/>
			</div>
		</div>
	  </div>	
	</div>
</body>

</html>
<script>
    /*jQuery(document).ready(function ($) {
        var options = {
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $ChanceToShow: 2
            }
        };
        var jssor_slider1 = new $JssorSlider$('slider1_container', options);
    });*/
</script>