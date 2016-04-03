<?php
	if(isset($_GET['async']) && $_GET['async']=='true')
		require($_SERVER["DOCUMENT_ROOT"]."/inc/common.php");
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
	  <div class="row global-column global-main-column">
		<div class="row evTitle">
		  <div class="col-xs-12">
			<?php if($row['Url']): ?>
		  		<?php echo '<a href="/events/'.$row['Url'].'" title='.$row['Title'].'>'.$row['Title'].'</a>' ?>
		  	<?php else: ?>
				<?php echo $row['Title'] ?>
			<?php endif; ?>
			<div class="evDate">
				Στις <?php echo $row['Datetime'] ?>
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
			<?php if($row['Url']): ?>
		  		<?php echo $row['Description'] ?>
		  		<a href="/events/<?= $row['Url'] ?>" title="<?= $row['Title'] ?>" class="btn btn-block btn-default" >Περισσότερα</a>
		  	<?php else: ?>
				<?php echo $row['Description'] ?>
			<?php endif; ?>
		  </div>
		</div>
			
	  </div>
	<?php $i++; endwhile; ?>
	<?php /*No results. */ if ( $i == 0 ) :	?>
		<div class="row result">
		  <div class="alert alert-danger fade in custom-alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  Δεν βρέθηκαν αποτελέσματα για αυτή την αναζήτηση.
		  </div>
		</div>
	<?php endif; ?>
</div>
<?php if ( !isset($_POST['dateSelector']) || !isset($_POST['loc']) ) : ?>
</div>
<?php endif; ?>