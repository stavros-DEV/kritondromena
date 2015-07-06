var map;
$( document ).ready(function() {
	var pathname = window.location.pathname;
	if (pathname == "/new-event/") {
		$("#li_addevent").addClass("active");
	} else if (pathname == "/events/") {
		$("#li_events").addClass("active");
	} else if (pathname == "/about-us/") {
		$("#li_about").addClass("active");
	}
	
	$('#datetimepicker1').datepicker({
		startDate: new Date(),
		format: "yyyy-mm-dd",
		orientation: "top left",
		todayHighlight: true,
		autoclose: true
	});
	
	$('.datepicker').datepicker('update', new Date());
	
	/*New event is added; Check the values. */
	 $('#eventsForm').submit( function() {
        return checkInput();
    });
	
	var numofWords = 0;

	function checkInput() {
		/*if (numofWords < 20){
			$('#eventDescription').css("border-color", "red");
			return false;
		} else */if ($('#eventTitle').val().length == 0) {
			$('#eventTitle').css("border-color", "red");
			return false;
		} else if ($('#eventPlace').val().length == 0) {
			$('#eventPlace').css("border-color", "red");
			return false;
		} else {
			return true;
		}
	}

	/*Get geo location using google api. */
	$("#eventPlace").focusout(function() {
		
		
		if (!$("#eventPlace").is(":focus") && $("#eventPlace").val()) {
			/*Add processing icon. */
			$(".messageGlyphicon span").removeClass("glyphicon-remove");
			$(".messageGlyphicon span").removeClass("glyphicon-ok");
			$('.messageGlyphicon span').prepend('<img id="theImg" src="../resources/icons/processing.gif" />');
			
			var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address=" + $("#eventPlace").val() + "&key=AIzaSyDzO7UQ_c127qzlFbBAHgO2Vg42c99Hdqk&language=el";
			var noresults = true;
			
			jQuery.getJSON(geocodingAPI, function (json) {
			  try {
				if (json.results.length > 0) {
					var location = {
						"Locality": json.results[0].address_components[0].long_name,
						"AreaLevel4": json.results[0].address_components[2].long_name,
						"AreaLevel3": json.results[0].address_components[3].long_name,
						"Lat": json.results[0].geometry.location.lat,
						"Lng": json.results[0].geometry.location.lng,
					}
					
					if (location["AreaLevel4"] == location["Locality"] && location["AreaLevel4"] == location["AreaLevel3"]) {
						var place = location["Locality"];
					} else if (location["AreaLevel4"] == location["AreaLevel3"]) {
						var place = location["Locality"] + ", " + location["AreaLevel4"]
					} else if (location["AreaLevel4"] == location["Locality"]) {
						var place = location["Locality"] + ", " + location["AreaLevel3"]
					} else if (location["AreaLevel3"] == location["Locality"]) {
						var place = location["Locality"] + ", " + location["AreaLevel4"]
					} else
						var place = location["Locality"] + ", " + location["AreaLevel4"] + ", " + location["AreaLevel3"];
					
					$("#eventPlace").val(place);
					$("#eventLng").val(location["Lng"]);
					$("#eventLat").val(location["Lat"]);
					
					/*Success icon*/
					$('#eventPlace').css("border-color", "green");
					$("#placeGlyph span").removeClass("glyphicon-remove");
					$("#placeGlyph span").addClass("glyphicon-ok");
					$("#placeGlyph span").css("color", "green");
					noresults = false;
				} else {
					addFailClass();
				}
			
			  } catch (e) {
				addFailClass();
			  }
			});
		}
	});
	
	function addFailClass() {
		$('#eventPlace').css("border-color", "red");
		$("#placeGlyph span").removeClass("glyphicon-ok");
		$("#placeGlyph span").addClass("glyphicon-remove");
		$("#placeGlyph span").css("color", "red");
		noresults = true;
	}
	
	$('#eventDescription').on('change keyup paste', function() {
		countTextAreaWords();
	});
	
	function countTextAreaWords(){
		var words = $('#eventDescription').val();
		if (words.length == 0) {
			numofWords = 0;
		} else {
			var temp = words.trim().split(' ');
			numofWords = temp.length;
		}
		if (numofWords < 20) {
			$('#wordsInfo').html(20 - numofWords + " λέξεις ακόμα.");
			$('#wordsInfo').css("color", "red");
		} else {
			$('#wordsInfo').html("Η περιγραφή ικανοποιεί τον ελάχιστο απαιτούμενο αριθμό λέξεων!");
			$('#wordsInfo').css("color", "green");
		}
		return numofWords;
	}
	
	
	$('.showMap').click(function() {
		var mapid = this.id;

		var lat = $('#' + mapid + ' .lat').val();
		var lng = $('#' + mapid + ' .lng').val();
		if (mapid.length == 8) {
			var lastChar = mapid.substr(mapid.length - 1);
		} else if (mapid.length == 9) {
			var lastChar = mapid.substr(mapid.length - 2);
		} else {
			var lastChar = mapid.substr(mapid.length - 3);
		}
		
		var mapCanvasid = "#map-canvas" + lastChar;
		
		$(mapCanvasid).css("width", "330px");
		$(mapCanvasid).css("height", "200px");
		
		map = new GMaps({
			div: mapCanvasid,
			lat: lat,
			lng: lng,
			zoom: 9
		});
		
		map.addMarker({
		  lat: lat,
		  lng: lng,
		});
	});
	
	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});
	/*
	 $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        console.log(numFiles);
        console.log(label);
    });*/
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' εικόνες' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });
	
	
	/*Top Search Results*/
	$("#tseForm").on("submit", function (e) {
		$( "#defaultResults" ).remove();
		$( "#ajaxLoading" ).append('<img id="loadingImage" src="../resources/images/site/custom-ajax-loader.gif" />').fadeIn('slow');
		var date  = $('#tseDate').val();
		var place = $('#tseLocation').val();
		
		if(place == "any")
			var url = "../events_dir/ajaxResults.php?date="+date;
		else
			var url = "../events_dir/ajaxResults.php?loc="+place+"&date="+date;
		
		$( "#ajaxResults" ).load( url, function(){
			$(this).fadeIn('slow');
		});
		$("#ajaxLoading img:last-child").fadeOut(1000, function() { $(this).remove(); });
		//$("#ajaxLoading img:last-child").remove();
		return false;
	});
	
	$('#summernote').summernote({height: 300});
});