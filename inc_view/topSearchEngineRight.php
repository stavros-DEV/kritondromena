<?php
	echo '<div class="tse-header-container">
	  					<div class="row"><span class="tse-header tse-header-main">ΑΝΑΖΗΤΗΣΗ</span></div>
	  					<div class="row"><span class="tse-header tse-header-second">ΚΡΗΤΙΚΗΣ ΕΚΔΗΛΩΣΗΣ</span></div>
	  				</div>
	  				<div class="tse-search-container">
	  					<div class="row">
							<form class="form-inline" action="/events/" accept-charset="UTF-8" enctype="multipart/form-data" method="post" id="tseFormPost">
								<select class="se-inputs custom-select" id="tseLocation" name="loc">
									<option value="any">Οπουδήποτε</option>
								    <option value="Χανιά">Χανιά</option>
								    <option value="Ρέθυμνο">Ρέθυμνο</option>
								    <option value="Ηράκλειο">Ηράκλειο</option>
								    <option value="Λασίθι">Λασίθι</option>
								</select>
								<div class="date datepicker no-padding datepickerWeather" id="datetimepicker2">
									<input type="text" class="dateText se-inputs" name="dateSelector" id="tseDate"/>
									<span class="input-group-addon calendar-custom"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<input type="submit" class="se-inputs custom-btn" value="ΑΝΑΖΗΤΗΣΗ"/>
						  	</form>
	  					</div>
	  				</div>';