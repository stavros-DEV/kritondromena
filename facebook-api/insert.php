<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container" id="message">
	<div class="form-group">
	<form class="form" action="" id="fb-api-form" novalidate >
	<input type="text" class="form-control" id="fb-id" name="fb-id" placeholder="FACEBOOK ID" required/>
	<input type="text" class="form-control" id="fb-name" name="fb-name" placeholder="EXACT FACEBOOK NAME" required/>
	<input type="text" class="form-control" id="kd-name" name="kd-name" placeholder="KRITONDROMENA NAME" required/>
	<button type="submit" class="btn btn-block btn-primary" id="enterEvent">ENTER DATA</button>
	</form>
	<div class="action-result"></div>
	</div>
	</div>
	
	<script>
	$("#fb-api-form").on("submit", function (e) {

		if ($('#fb-id').val()=='' || $('#fb-id').val()=='' || !$('#fb-id').val().match(/^\d+$/)) {
			$( ".action-result" ).html( "<div class='alert alert-danger fade in'>FACEBOOK ID AND KRITONDROMENA NAME ARE REQUIRED</div>" );
			return false;
		}
		
		$.ajax({
			'url': '../ajax/enter_facebook.php',
			'type': 'POST',
			'data': $('#fb-api-form').serialize(),
			'success': function(result){
				var res = $.parseJSON(result);
				if (res['status'] == 'OK')
					$( ".action-result" ).html( "<div class='alert alert-success fade in'>" + res['msg'] + ": " + res['id'] + "</div>" );
				else
					$( ".action-result" ).html( "<div class='alert alert-danger fade in'>" + res['msg'] + "</div>" );
			}
		});
		$("#contactus-form").trigger("reset");
		return false;
	});
	</script>
</body>
</html>