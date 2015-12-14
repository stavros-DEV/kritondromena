<?php header('Content-Type: text/html; charset=utf-8');
	require($_SERVER["DOCUMENT_ROOT"]."/inc/common.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Πολιτιστικές Εκδηλώσεις από το Κρητών Δρώμενα</title>
	<meta name="description" content="Αναζητήστε όλες τις πολιτιστικές εκδηλώσεις, γλέντια και πανηγύρια που συμβαίνουν στην Κρήτη. Οι κρητικοί χοροί και η κουλτούρα, μέσα από το Κρητών Δρώμενα.">
	<meta name="keywords" content="Αναζήτηση Κρητικών εκδηλώσεων και κρητικών χορών.">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις δρώμενα και χοροί.">
	<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_metas.php"); ?>
</head>

<body>
	<?php require("../inc/header.php");	?>
	<div class="hidden-xs">
	  <?php require("../inc_view/topSearchEngine.php"); ?>
	</div>
	<div class="container" id="message" align="center">
	  <div class="row">
		<div class="col-xs-12">
		  <div class="main-landing-message">
			<h1 class="basic-heading">Αναζητηστε Κρητικες βραδιες και εκδηλωσεις</h1>
			<p>Αναζητήστε εύκολα τις μουσικές βραδιές, εκδηλώσεις δρώμενα που σας ενδιαφέρουν.</p>
			<div class="result-description">
			
			<?php if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) : 
				if ( $_POST['loc'] == "any")
					$location = "Οπουδήποτε";
				else
					$location = $_POST['loc'];
			?>
				Ημερομηνία: <?php echo $_POST['dateSelector']; ?>, Τοποθεσία: <?php echo $location; ?>
			<?php endif; ?> 
			
			</div>
		  </div>
		  <?php 
			if(isset($_POST['loc'])) {
				$_GET['loc'] = $_POST['loc'];
			}
		
			if(isset($_POST['dateSelector'])) {
				$_GET['date'] = $_POST['dateSelector'];
				require('ajaxResults.php');
			}
		  
		  if ( !isset($_POST['dateSelector']) && !isset($_POST['loc']) ) : ?>
		  <?php 
		  $events = new Event();
		  $res = $events->getEventsByDate( date( "Y-m-d", time() - 60 * 60 * 24 ) );
		  ?>
		  <div id="defaultResults">
		  <?php $i = 0; foreach( $res as $row ) { ?>
		  
		  <div class="row result <?= $row['ID'] ?>">
		    <div class="row evTitle">
			  <div class="col-xs-12">
				<?php echo $row['Title'] ?>
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
						<?php if(!empty($row['Lng']) && !empty($row['Lat'])){ ?>
						<button type="submit" class="btn btn-block-custom btn-primary" >Εμφάνιση στο χάρτη</button>
						<?php } ?>
					</div>
					<div id="map-canvas<?php echo $i; ?>"></div>
				</div>
			  </div>	
			  <div class="col-xs-12 col-sm-7 evDescription" >
				<?php echo $row['Description'] ?>
				<!--<a href="" class="btn btn-block btn-default" >Περισσότερα</a>-->
			  </div>
			</div>
			
		  </div>
		  <?php $i++; } ?>
		  </div>
		  <?php endif; ?>
		  <div id="ajaxLoading"></div>
		  <div id="ajaxResults"></div>
		</div>
	  </div>
	</div>
</body>
<?php require($_SERVER['DOCUMENT_ROOT']."inc/common_resources.php"); ?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="../resources/js/gmaps.js"></script>
</html>
