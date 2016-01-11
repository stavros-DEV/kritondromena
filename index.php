<?php
	header('Content-Type: text/html; charset=utf-8');
	require("inc/common.php");
	
	$events = new Event();
	$res = $events->getEventsByDate( date( "Y-m-d", time() - 60 * 60 * 24 ) );
	
	$article = new Article();
	$resart = $article->getArticles();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Κρητών Δρώμενα: Πολιτισμός και Παραδόση σε ένα site</title>
	<meta name="description" content="Πολιτιστικές εκδηλώσεις, μουσικές βραδιές, κρητική παράδοση και όλα τα Γλέντια Κρητικών Πολιτιστικών Συλλόγων. Οι ομορφιές και η κουλτούρα της Κρήτης μας στο kritondromena.gr.">
	<meta name="keywords" content="Κρητικές εκδηλώσεις, δρώμενα και γλέντια">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις, κείμενα Κρητικής κουλτούρας.">
	<?php require('common_metas.php'); ?>
</head>

<body>
	<?php require('header.php'); ?>
	<div class="hidden-xs">
	  <?php require('topSearchEnginePost.php'); ?>
	</div>
	<div class="container" id="message">
	  <div class="row">
	    <div class="col-md-12 main-landing-message">
		
		<h1 class="basic-heading">Κρητικες Εκδηλωσεις &amp; Δρωμενα</h1>
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
				<div class="evTitle"><h3>Κρητών Δρώμενα (<?php echo count($res); ?>)</h3></div><hr/>
				<?php foreach($res as $row ) { ?>
				  <div class="row">
					<div class="home-events-title">
						<? if($row['Url']): ?>
							<a href="/events/<?= $row['Url'] ?>"><?php echo $row['Title'] ?></a>
						<? else: ?>
							<a href="/events/#event<?= $row['ID'] ?>"><?php echo $row['Title'] ?></a>
						<? endif; ?>
					</div>
					<div class="home-events-date">
						<?php echo $row['Date'] ?>
					</div>
				  </div>
				<?php } ?>
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
						<?php echo mb_substr($rowart['MetaDescription'], 0, 200, 'UTF-8')."...";?>
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
<?php require('common_resources.php'); ?>
</body>
</html>