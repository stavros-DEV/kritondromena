<?php
			
	echo '<div class="topSearchEngine">
	  <form class="form-inline" action="/events/" accept-charset="UTF-8" enctype="multipart/form-data" method="post" id="tseFormPost">
		<select class="tseInputFields" id="tseLocation" name="loc">
			<option value="any">Οπουδήποτε</option>
		    <option value="Χανιά">Χανιά</option>
		    <option value="Ρέθυμνο">Ρέθυμνο</option>
		    <option value="Ηράκλειο">Ηράκλειο</option>
		    <option value="Λασίθι">Λασίθι</option>
		</select>
		<div class="date datepicker no-padding datepickerWeather tseDateDiv" id="datetimepicker2">
			<input type="text" class="dateText tseInputFields" name="dateSelector" id="tseDate"/>
			<span id="calendar-custom" class="input-group-addon"><span class="glyphicon glyphicon-calendar" id="glyphicon-calendar-custom"></span></span>
		</div>
		<input type="submit" class="tseInputFields" id="tseSubmit" id="tseSearchButton" value="Αναζήτηση"/>
	  </form>
	</div>';

?>