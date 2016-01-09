var map;
$( document ).ready(function() {
	var pathname = window.location.pathname;
	if (pathname == "/new-event/") {
		$("#li_addevent").addClass("active");
		$('#summernote').summernote({height: 300});
	} else if (pathname == "/events/") {
		$("#li_events").addClass("active");
	} else if (pathname == "/about-us/") {
		$("#li_about").addClass("active");
	}
	
	$('#datetimepicker1').datepicker({
		startDate: new Date(),
		format: "yyyy-mm-dd",
		orientation: "bottom left",
		todayHighlight: true,
		autoclose: true
	});
	if ($(window).width() < 767){
		$('#datetimepicker2').datepicker({
			startDate: new Date(),
			format: "yyyy-mm-dd",
			orientation: "bottom left",
			todayHighlight: true,
			autoclose: true,
			disableTouchKeyboard: true
		});
	} else {
		$('#datetimepicker2').datepicker({
			startDate: new Date(),
			format: "yyyy-mm-dd",
			orientation: "top left",
			todayHighlight: true,
			autoclose: true,
			disableTouchKeyboard: true
		});
	}
	
	$('.datepicker').datepicker('update', new Date());
	
	/*New event is added; Check the values. */
	 $('#eventsForm').submit( function() {
        return checkInput();
    });
	if ($(window).width() > 992 && pathname.indexOf("/events/") >= 0 && pathname.length > 8 ){
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true,
			'fitImagesInViewport': false
		});
	}
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
	
	// We need to use event delegation, because elements added to the DOM after this code was ran
	$(document).on("click", ".showMap", function() {
		
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
	
	if (pathname.indexOf("/events/") >= 0 && pathname.length > 8) {//event details page
		var mapCanvasid = "#map-canvas";
		var lat = $('#showMap .lat').val();
		var lng = $('#showMap .lng').val();
		
		if (lat != '' && lng != '') {
			$(mapCanvasid).css("width", "370px");
			$(mapCanvasid).css("height", "250px");
			
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
		}
	}
	
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
		
		if(place == "any") {
			var url = "../events_dir/ajaxResults.php?async=true&date="+date;
			place = "Οπουδήποτε";
		} else
			var url = "../events_dir/ajaxResults.php?async=true&loc="+place+"&date="+date;
		
		$( "#ajaxResults" ).load( url, function(){
			$(this).fadeIn('slow');
		});
		$("#ajaxLoading img:last-child").fadeOut(1000, function() { $(this).remove(); });
		
		$(".result-description").hide().text('Ημερομηνία: ' + date + ', Τοποθεσία: ' + place).fadeIn('2000');
		
		return false;
	});
	
	$("#contactus-form").on("submit", function (e) {
		var name  = $('#msg-name').val();
		var email = $('#msg-email').val();
		var msg   = $('#msg-text').val();
		
		$.ajax({
			'url': '../ajax/sendMessage.php',
			'type': 'POST',
			'data': $('#contactus-form').serialize(),
			'success': function(result){
				 $( ".actionResult" ).html( result );
			}
		});
		$("#contactus-form").trigger("reset");
		return false;
	});
	
	$( window ).load(function() {
		var hash = window.location.hash;
		var eventID = hash.substr(6, hash.length);
		if ($(window).width() < 767)
		  var minus = 50;
		else
		  var minus = 85;
		
		if(hash){
			$('html, body').animate({
	          scrollTop: $("."+eventID).offset().top - minus
			}, 2000);
		}
	});
	
	if (pathname.indexOf("/articles/") >= 0) {
	
	var _SlideshowTransitions = [
             //Rotate Overlap
             { $Duration: 1200, $Zoom: 11, $Rotate: -1, $Easing: { $Zoom: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Round: { $Rotate: 0.5 }, $Brother: { $Duration: 1200, $Zoom: 1, $Rotate: 1, $Easing: $JssorEasing$.$EaseSwing, $Opacity: 2, $Round: { $Rotate: 0.5 }, $Shift: 90 } },
             //Switch
             { $Duration: 1400, x: 0.25, $Zoom: 1.5, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Zoom: $JssorEasing$.$EaseInSine }, $Opacity: 2, $ZIndex: -10, $Brother: { $Duration: 1400, x: -0.25, $Zoom: 1.5, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Zoom: $JssorEasing$.$EaseInSine }, $Opacity: 2, $ZIndex: -10 } },
             //Rotate Relay
             { $Duration: 1200, $Zoom: 11, $Rotate: 1, $Easing: { $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Round: { $Rotate: 1 }, $ZIndex: -10, $Brother: { $Duration: 1200, $Zoom: 11, $Rotate: -1, $Easing: { $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Round: { $Rotate: 1 }, $ZIndex: -10, $Shift: 600 } },
             //Doors
             { $Duration: 1500, x: 0.5, $Cols: 2, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInOutCubic }, $Opacity: 2, $Brother: { $Duration: 1500, $Opacity: 2 } },
             //Rotate in+ out-
             { $Duration: 1500, x: -0.3, y: 0.5, $Zoom: 1, $Rotate: 0.1, $During: { $Left: [0.6, 0.4], $Top: [0.6, 0.4], $Rotate: [0.6, 0.4], $Zoom: [0.6, 0.4] }, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Brother: { $Duration: 1000, $Zoom: 11, $Rotate: -0.5, $Easing: { $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Shift: 200 } },
             //Fly Twins
             { $Duration: 1500, x: 0.3, $During: { $Left: [0.6, 0.4] }, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true, $Brother: { $Duration: 1000, x: -0.3, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } },
             //Rotate in- out+
             { $Duration: 1500, $Zoom: 11, $Rotate: 0.5, $During: { $Left: [0.4, 0.6], $Top: [0.4, 0.6], $Rotate: [0.4, 0.6], $Zoom: [0.4, 0.6] }, $Easing: { $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Brother: { $Duration: 1000, $Zoom: 1, $Rotate: -0.5, $Easing: { $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Shift: 200 } },
             //Rotate Axis up overlap
             { $Duration: 1200, x: 0.25, y: 0.5, $Rotate: -0.1, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Brother: { $Duration: 1200, x: -0.1, y: -0.7, $Rotate: 0.1, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2 } },
             //Chess Replace TB
             { $Duration: 1600, x: 1, $Rows: 2, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1600, x: -1, $Rows: 2, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } },
             //Chess Replace LR
             { $Duration: 1600, y: -1, $Cols: 2, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1600, y: 1, $Cols: 2, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } },
             //Shift TB
             { $Duration: 1200, y: 1, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1200, y: -1, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } },
             //Shift LR
             { $Duration: 1200, x: 1, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1200, x: -1, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } },
             //Return TB
             { $Duration: 1200, y: -1, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $ZIndex: -10, $Brother: { $Duration: 1200, y: -1, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $ZIndex: -10, $Shift: -100 } },
             //Return LR
             { $Duration: 1200, x: 1, $Delay: 40, $Cols: 6, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $ZIndex: -10, $Brother: { $Duration: 1200, x: 1, $Delay: 40, $Cols: 6, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $ZIndex: -10, $Shift: -100 } },
             //Rotate Axis down
             { $Duration: 1500, x: -0.1, y: -0.7, $Rotate: 0.1, $During: { $Left: [0.6, 0.4], $Top: [0.6, 0.4], $Rotate: [0.6, 0.4] }, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Brother: { $Duration: 1000, x: 0.2, y: 0.5, $Rotate: -0.1, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2 } },
             //Extrude Replace
             { $Duration: 1600, x: -0.2, $Delay: 40, $Cols: 12, $During: { $Left: [0.4, 0.6] }, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: { $Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad }, $Opacity: 2, $Outside: true, $Round: { $Top: 0.5 }, $Brother: { $Duration: 1000, x: 0.2, $Delay: 40, $Cols: 12, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 1028, $Easing: { $Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad }, $Opacity: 2, $Round: { $Top: 0.5 } } }
         ];

         var _CaptionTransitions = [
         //CLIP|LR
         {$Duration: 900, $Clip: 3, $Easing: $JssorEasing$.$EaseInOutCubic },
         //CLIP|TB
         {$Duration: 900, $Clip: 12, $Easing: $JssorEasing$.$EaseInOutCubic },

         //DDGDANCE|LB
         {$Duration: 1800, x: 0.3, y: -0.3, $Zoom: 1, $Easing: { $Left: $JssorEasing$.$EaseInJump, $Top: $JssorEasing$.$EaseInJump, $Zoom: $JssorEasing$.$EaseOutQuad }, $Opacity: 2, $During: { $Left: [0, 0.8], $Top: [0, 0.8] }, $Round: { $Left: 0.8, $Top: 2.5} },
         //DDGDANCE|RB
         {$Duration: 1800, x: -0.3, y: -0.3, $Zoom: 1, $Easing: { $Left: $JssorEasing$.$EaseInJump, $Top: $JssorEasing$.$EaseInJump, $Zoom: $JssorEasing$.$EaseOutQuad }, $Opacity: 2, $During: { $Left: [0, 0.8], $Top: [0, 0.8] }, $Round: { $Left: 0.8, $Top: 2.5} },

         //TORTUOUS|HL
         {$Duration: 1500, x: 0.2, $Zoom: 1, $Easing: { $Left: $JssorEasing$.$EaseOutWave, $Zoom: $JssorEasing$.$EaseOutCubic }, $Opacity: 2, $During: { $Left: [0, 0.7] }, $Round: { $Left: 1.3} },
         //TORTUOUS|VB
         {$Duration: 1500, y: -0.2, $Zoom: 1, $Easing: { $Top: $JssorEasing$.$EaseOutWave, $Zoom: $JssorEasing$.$EaseOutCubic }, $Opacity: 2, $During: { $Top: [0, 0.7] }, $Round: { $Top: 1.3} },

         //ZMF|10
         {$Duration: 600, $Zoom: 11, $Easing: { $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },

         //ZML|R
         {$Duration: 600, x: -0.6, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2 },
         //ZML|B
         {$Duration: 600, y: -0.6, $Zoom: 11, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2 },

         //ZMS|B
         {$Duration: 700, y: -0.6, $Zoom: 1, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2 },

         //ZM*JDN|LB
         {$Duration: 1200, x: 0.8, y: -0.5, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseOutCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Top: [0, 0.5]} },
         //ZM*JUP|LB
         {$Duration: 1200, x: 0.8, y: -0.5, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Top: [0, 0.5]} },
         //ZM*JUP|RB
         {$Duration: 1200, x: -0.8, y: -0.5, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Top: [0, 0.5]} },

         //ZM*WVR|LT
         {$Duration: 1200, x: 0.5, y: 0.3, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseInWave }, $Opacity: 2, $Round: { $Rotate: 0.8} },
         //ZM*WVR|RT
         {$Duration: 1200, x: -0.5, y: 0.3, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseInWave }, $Opacity: 2, $Round: { $Rotate: 0.8} },
         //ZM*WVR|TL
         {$Duration: 1200, x: 0.3, y: 0.5, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Top: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Round: { $Rotate: 0.8} },
         //ZM*WVR|BL
         {$Duration: 1200, x: 0.3, y: -0.5, $Zoom: 11, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Top: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Round: { $Rotate: 0.8} },

         //RTT|10
         {$Duration: 700, $Zoom: 11, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} },

         //RTTL|R
         {$Duration: 700, x: -0.6, $Zoom: 11, $Rotate: 1, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.8} },
         //RTTL|B
         {$Duration: 700, y: -0.6, $Zoom: 11, $Rotate: 1, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.8} },

         //RTTS|R
         {$Duration: 700, x: -0.6, $Zoom: 1, $Rotate: 1, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Zoom: $JssorEasing$.$EaseInQuad, $Rotate: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseOutQuad }, $Opacity: 2, $Round: { $Rotate: 1.2} },
         //RTTS|B
         {$Duration: 700, y: -0.6, $Zoom: 1, $Rotate: 1, $Easing: { $Top: $JssorEasing$.$EaseInQuad, $Zoom: $JssorEasing$.$EaseInQuad, $Rotate: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseOutQuad }, $Opacity: 2, $Round: { $Rotate: 1.2} },

         //RTT*JDN|RT
         {$Duration: 1000, x: -0.8, y: 0.5, $Zoom: 11, $Rotate: 0.2, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseOutCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Top: [0, 0.5]} },
         //RTT*JDN|LB
         {$Duration: 1000, x: 0.8, y: -0.5, $Zoom: 11, $Rotate: 0.2, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseOutCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Top: [0, 0.5]} },
         //RTT*JUP|RB
         {$Duration: 1000, x: -0.8, y: -0.5, $Zoom: 11, $Rotate: 0.2, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Top: [0, 0.5]} },
         {$Duration: 1000, x: -0.5, y: 0.8, $Zoom: 11, $Rotate: 1, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseLinear, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Left: [0, 0.5] }, $Round: { $Rotate: 0.5 } },
         //RTT*JUP|BR
         {$Duration: 1000, x: -0.5, y: -0.8, $Zoom: 11, $Rotate: 0.2, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseLinear, $Zoom: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $During: { $Left: [0, 0.5]} },

         //R|IB
         {$Duration: 900, x: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutBack }, $Opacity: 2 },
         //B|IB
         {$Duration: 900, y: -0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutBack }, $Opacity: 2 },

         ];

         var options = {
             $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
             $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
             $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
             $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

             $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
             $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
             $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
             $SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
             $SlideHeight: 450,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
             $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
             $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
             $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
             $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
             $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
             $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

             $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                 $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                 $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                 $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                 $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
             },

             $CaptionSliderOptions: {                            //[Optional] Options which specifies how to animate caption
                 $Class: $JssorCaptionSlider$,                   //[Required] Class to create instance to animate caption
                 $CaptionTransitions: _CaptionTransitions,       //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
                 $PlayInMode: 0,                                 //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
                 $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
             },

             $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                 $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                 $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                 $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                 $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                 $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                 $SpacingX: 10,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                 $SpacingY: 10,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                 $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
             },

             $ArrowNavigatorOptions: {
                 $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                 $ChanceToShow: 2                                //[Required] 0 Never, 1 Mouse Over, 2 Always
             }
         };

         var jssor_slider1 = new $JssorSlider$("slider1_container", options);
         //responsive code begin
         //you can remove responsive code if you don't want the slider scales while window resizes
         function ScaleSlider() {
             var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
             if (parentWidth)
                 jssor_slider1.$ScaleWidth(Math.min(parentWidth, 600));
             else
                 window.setTimeout(ScaleSlider, 30);
         }
         ScaleSlider();

         $(window).bind("load", ScaleSlider);
         $(window).bind("resize", ScaleSlider);
         $(window).bind("orientationchange", ScaleSlider);
         //responsive code end
         
	}
});