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
	
?>
<?php if ( !isset($_POST['dateSelector']) || !isset($_POST['loc']) ) : ?>
<div id="ajaxResults">
<?php endif; ?>
<div id="defaultResults">
	
	<?php foreach($res as $key => $row) { ?>
	  <div class="row result">
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
				<div class="showMap" id="showMap<?php echo $key; ?>" >
					<input type="hidden" value="<?php echo $key; ?>" />
					<input class="lng" type="hidden" value="<?php echo $row['Lng'] ?>" />
					<input class="lat" type="hidden" value="<?php echo $row['Lat'] ?>" />
					<?php if(!empty($row['Lng']) && !empty($row['Lat'])){ ?>
					<button type="submit" class="btn btn-block-custom btn-primary" >Εμφάνιση στο χάρτη</button>
					<?php } ?>
				</div>
				<div id="map-canvas<?php echo $key; ?>"></div>
			</div>
		  </div>
		
		  <div class="col-xs-12 col-sm-7 evDescription" >
			<?php echo $row['Description'] ?>
		  </div>
		</div>
			
	  </div>
	<?php  } ?>
	<?php /*No results. */ if ( count($res) == 0 ) :	?>
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