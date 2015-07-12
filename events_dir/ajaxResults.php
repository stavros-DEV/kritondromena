<?php
	require("../model/clsEvent.php");
	$events = new Event();
	if(!isset($_GET['loc']) && isset($_GET['date']))
		$res = $events->getEventsByParams('', $_GET['date']);
	elseif(isset($_GET['loc']) && isset($_GET['date'])) {
		if($_GET['loc']=="any")
			$_GET['loc'] = "";
		$res = $events->getEventsByParams($_GET['loc'], $_GET['date']);		
	}
	
	if(isset($res) && !$res) {
		echo "no results";
		exit();
	}elseif(!isset($res)){
		echo "No results!";
		exit();
	}
?>
<?php if ( !isset($_POST['dateSelector']) || !isset($_POST['loc']) ) : ?>
<div id="ajaxResults">
<?php endif; ?>
<div id="defaultResults">
	
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
	<?php echo "RESULTS: ".$i ?>
</div>
<?php if ( !isset($_POST['dateSelector']) || !isset($_POST['loc']) ) : ?>
</div>
<?php endif; ?>