<!DOCTYPE html>
<html>

<head>
	<title>Κρητών Δρώμενα: Πολιτισμός και Παραδόση σε ένα site</title>
	<?php require("inc/resources.php"); ?>
	<script src="resources/js/jssor.slider.mini.js"></script>
</head>

<body>
	<?php require("inc/header.php"); ?>
	
	<div class="container" id="message" align="center">
		<h1>ΚΡΗΤΩΝ ΔΡΩΜΕΝΑ</h1>
		Το Portal kritondromena.gr θα είναι κοντά σας στις 01.08.2015
		<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px;">
			<!-- Slides Container -->
			<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 600px; height: 300px;">
				<div><img u="image" src2="resources/images/kritonbg.jpg" />tileei</div>
				<div><img u="image" src2="resources/images/df.jpg" />xairetw</div>
			</div>
		</div>
		
	</div>
</body>

</html>
<script>
    jQuery(document).ready(function ($) {
        var options = {
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $ChanceToShow: 2
            }
        };
        var jssor_slider1 = new $JssorSlider$('slider1_container', options);
    });
</script>