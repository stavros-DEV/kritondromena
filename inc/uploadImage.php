<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	$target_file = $target_dir . basename($_FILES[$formName]["name"]);
	$uploadOk = 1;
	$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($image)) {
		$check = getimagesize($_FILES[$formName]["name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			$errorMsg .= "Το αρχείο δεν είναι εικόνα. ";
			$uploadOk = 0;
		}
	}
	
	$i = 0;
	while (file_exists($target_file)) {
		$tmp = explode(".", basename($_FILES[$formName]["name"]));
		$name = $tmp[0];
		$i++;
		$name .= $i;
		$name .= ".".$fileType;
		$target_file = $target_dir . $name;
	} 
	
	// Check file size
	if ($_FILES[$formName]["size"] > 3500000) {
		$errorMsg .= "Πολύ μεγάλο αρχείο. ";
		$uploadOk = 0;
	} 
	
	// Allow certain file formats
	if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" ) {
		$errorMsg .= "Επιτρεπόμενοι τύποι αρχείων: JPG, JPEG, PNG & GIF. ";
		$uploadOk = 0;
	}
	echo $target_file;
	if ($uploadOk == 0) {
		$errorMsg .= "Το σύστημα θα απορρίψει την εικόνα. ";
	} else {
		if (move_uploaded_file($_FILES[$formName]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES[$formName]["name"]). " has been uploaded.";
		} else {
			$errorMsg .= "Το σύστημα δεν κατάφερε να ανεβάσει την φωτογραφία.";
		}
	}
?>