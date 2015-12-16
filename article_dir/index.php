<?php 
	header('Content-Type: text/html; charset=utf-8');
	require("../inc/common.php");
	$id = $_GET["artId"];
	$article = new Article();
	$row = $article->getArticleById($id);
?>

<!DOCTYPE html>
<html>

<head>
	<title><?php echo $row['Title'] ?> από το Κρητών Δρώμενα</title>
	<meta name="description" content="<?php echo $row['MetaDescription'] ?>">
	<meta name="keywords" content="Κρητικές εκδηλώσεις, δρώμενα και γλέντια">
	<meta name="page-topic" content="Κρητικές εκδηλώσεις, κείμενα Κρητικής κουλτούρας.">
	<?php require('common_metas.php'); ?>
</head>

<body>
	<?php require('header.php'); ?>
	<div class="hidden-xs">
	  <?php require('topSearchEnginePost.php'); ?>
	</div>
	<div class="container" id="message" align="center">
		<div class="row result">
			<div class="row evTitle">
				<div class="col-xs-12">
					<?php echo $row['Title'] ?>
				</div>
			</div><hr/>
			<div class="col-xs-12">
				<?php echo $row['JssorSlider']; ?>
			</div>
			<div class="col-xs-12 evDescription">
				<?php echo $row['Text']; ?>
			</div>
	  	</div>
	</div>
	
</body>
<script type="text/javascript" src="/resources/js/jssor.js"></script>
<script type="text/javascript" src="/resources/js/jssor.slider.js"></script>
<?php require('common_resources.php'); ?>
</html>