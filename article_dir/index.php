<?php 
	header('Content-Type: text/html; charset=utf-8');
	require("../model/clsArticle.php");
	$id = $_GET["artId"];
	$article = new Article();
	$res = $article->getArticleById($id);
	$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Κρητών Δρώμενα: Πολιτισμός και Παραδόση σε ένα site</title>
	<meta name="description" content="">
	<meta name="keywords" content="Κρητικές εκδηλώσεις, δρώμενα και γλέντια">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις, κείμενα Κρητικής κουλτούρας.">
	<?php require("../inc/resources.php"); ?>
</head>

<body>
	<?php require("../inc/header.php"); ?>
	<div class="hidden-xs">
	  <?php require("../inc_view/topSearchEnginePost.php"); ?>
	</div>
	<div class="container" id="message" align="center">
	  
	  
	  <div class="row result">
		<div class="row evTitle">
			<div class="col-xs-12">
				<?php echo $row['Title'] ?>
			</div>
		</div><hr/>
		<div class="col-xs-12 evDescription">
			<?php echo $row['Text'] ?>
		</div>
	  </div>	
	</div>
</body>

</html>
