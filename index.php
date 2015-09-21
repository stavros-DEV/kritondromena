<?php 
	header('Content-Type: text/html; charset=utf-8');
	require("events_dir/getEvents.php");
	require("model/clsArticle.php");
	$article = new Article();
	$resart = $article->getArticles();
	
?>

<!DOCTYPE html>
<html>

<head>
	<title>Κρητών Δρώμενα: Πολιτισμός και Παραδόση σε ένα site</title>
	<meta name="description" content="Πολιτιστικές εκδηλώσεις, μουσικές βραδιές και κρητική παράδοση σε ένα site. Αναζητήστε τα δρώμενα που σας ενδιαφέρουν και τα πανηγύρια που συμβαίνουν στην Κρήτη. Οι πολιτιστικοί σύλλογοι, παρουσιάζουν εδώ όλα τα γλέντια που διοργανώνουν και αφορούν την Κρητική μουσική παράδοση. Οι ομορφιές και η κουλτούρα της Κρήτης μας, παρουσιάζονται με εύκολο και σύγχρονο τρόπο μέσα από το kritondromena.gr.">
	<meta name="keywords" content="Κρητικές εκδηλώσεις, δρώμενα και γλέντια">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις, κείμενα Κρητικής κουλτούρας.">
	<?php require("inc/resourcesRest.php"); ?>
</head>

<body>
	<?php require("inc/header.php"); ?>
	<div class="hidden-xs">
	  <?php require("inc_view/topSearchEnginePost.php"); ?>
	</div>
	<div class="container" id="message">
	  <div class="row">
	    <div class="col-md-12 main-landing-message">
		
		<h1>Κρητικες Εκδηλωσεις &amp; Δρωμενα</h1>
		<ul>
			<li>Καταχωρήστε εντελώς δωρεάν την εκδήλωση που οργανώνετε.</li>
			<li>Αναζητήστε εύκολα τις μουσικές και πολιτιστικές εκδηλώσεις που σας ενδιαφέρουν.</li>
			<li>Στηρίξτε την προσπάθειά μας να διαδώσουμε την Κρητική μας παράδοση.</li>
		</ul>
		</div>
	  </div>
	  
	  <div class="row">
		<div class="col-md-6 home-custom-column">
			<div class="home-columns home-left-column">
				<div class="evTitle"><h3>Κρητών Δρώμενα (<?php echo mysqli_num_rows($res); ?>)</h3></div><hr/>
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
				<div class="evTitle"><h3>Κείμενα (<?php echo count($resart); ?>)</h3></div><hr/>
				<div class="row articleDescr">
				  <div class="col-xs-12">
				   <?php foreach($resart as $rowart){ ?>
					<div class="article-title">
						<a href="<?= $rowart['Vanity'] ?>" title="<?= $rowart['Title'] ?>"><?php echo $rowart['Title']; ?></a>
					</div>
					<div class="article-description">
						<?php echo mb_substr(strip_tags($rowart['Text']), 0, 300)."..."; ?>
					</div>
					<a href="<?= $rowart['Vanity'] ?>" title="<?= $rowart['Title'] ?>" class="btn btn-block btn-default" >Περισσότερα</a>
					<br/>
				   <?php } ?>
				  </div>
				</div>
			</div>
		</div>
	  </div>	
	</div>
</body>

</html>
<?php require("inc/resourcesJs.php"); ?>