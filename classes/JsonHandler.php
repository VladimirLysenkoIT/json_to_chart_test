<?php

 /**
 * class JsonHandler receives information with monthly data on applications for training for the year, decodes it into an array.
 * Using decoded data, it draws a table, a filter, and prepares data to draw a graph that is rendered by the JS library.
 */
class JsonHandler
{	
	// JSON decoded to array
	private $data = [];
	// the message that is displayed in the absence of data
	public $absenceDataMessage = "Unfortunately there is no data on applications";

	/**
 	*
 	* The method gets information from the Jason file and calls the method jsonToArray()
 	* @param	string $filePath the full path to the file with JSON
 	* @return 	false if the file is not find
 	* @access 	public
 	*/
	public function getJsonFromFile($filePath)
	{	
		if (file_exists($filePath)) {
            $json = file_get_contents($filePath);
			$this->jsonToArray($json);
        }else{
           return false;
        }
	}


	/**
 	*
 	* The method decodes a JSON string into an array and stores it in the $data property.
 	* $this->data['period'] stores the months in which applications were submitted
 	* $this->data['disciplines'] stores the names of disciplines and the number of applications received for each month
 	* @return 	false if no data of period or disciplines
 	*
 	* @param	string $json data on applications for training in JSON format
 	* @access 	private
 	*/
	private function jsonToArray ($json)
	{	
		$decodedJson[] = json_decode($json, true);
		if (isset($decodedJson[0]['Columns']) && isset($decodedJson[0]['Rows'])) {
			$this->data['period'] = $decodedJson[0]['Columns'];
			$this->data['disciplines'] = $decodedJson[0]['Rows'];
		}else{
			return false;
		}
	}


	/**
 	*
 	* The method draws a table with monthly data about training requests using data from the $data property.
 	* The array $this->data['period']-contains the names of months $this - >data['period'][0] == 'January', [1] == 'February', ....
 	* The array $this->data['disciples'] - is an array of arrays, the keys of which - the names of disciplines,
 	* values - arrays with data on the number of applications for months $this->data['disciples']['MA'][1,2,.....]
 	*
 	* If the $data property is empty, prints the message $this->absenceDataMessage instead of the table and stops the method execution
 	* @return 	false if $data property is empty 
 	* @access 	public
 	*/
	public function drawTable()
	{
		if (empty($this->data)) {
			echo '<p>'. $this->absenceDataMessage .'</p>';
			return false;
		}

		$periodLength = count($this->data['period']);
		// Columns titles
  		echo '<thead class="thead-dark">';
  			echo '<tr>';
  		 		echo '<th scope="col">#</th>';
  				for ($i=0; $i < $periodLength; $i++) { 
  					echo '<th scope="col">' . $this->data['period'][$i] . '</th>';
  				}
  		 	echo '</tr>';
  		echo '</thead>';
		// END Columns titles
	
  		// main table content
		echo '<tbody>';
		foreach ($this->data['disciplines'] as $disciplineTitle => $applicationsNumber) {
			$applicationsNumberLenght = count($applicationsNumber);
			echo '<tr>';
				// Row titles
				echo '<th scope="row">' . $disciplineTitle . '</th>';
				// Row content
				for ($i=0; $i < $applicationsNumberLenght; $i++) { 
		  		   	echo '<td>' . $applicationsNumber[$i] . '</td>';
				}
			echo '</tr>';
		}
  		echo '</tbody>';
  		// END main table content
	}


	/**
 	*
 	* The method saves chart filter settings to $_SESSION.
 	* The string $_SESSION['selectedPeriod'] - contains the names of the selected months. 
 	* The string $this->data['disciplines'] - contains the names of the selected disciplines.
 	* @param	string $period - selected period
 	* @param	string $disciplines - selected disciplines
 	* @access 	public
 	*/
	public function setFilterConfiguration($period, $disciplines)
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['selectedPeriod'] = htmlspecialchars($period);
		$_SESSION['selectedDisciplines'] = htmlspecialchars($disciplines);
	}


	/**
	* This method draws in the filter the select's options (<select id="filter_select" class="custom-select">) using data from
	* $this->data['period'] .
	* Using this select the user chooses for what period the chart should be drawn: draw for 1 month, 2 months, n months...
	* If the user has already used the filter - display the previously selected option with the "selected" property"
	* If the user has not yet used the filter-display the selected option-the entire period, the chart will also be drawn
	* for the entire period.
	* If there is nothing in the $date property - do not draw anything
 	* @access 	public
	*/
	public function drawSelect()
	{	
		if (empty($this->data)) {
			return false;
		}
		// the entire available period
		$allPeriod = count($this->data['period']);
		//  if there are filter settings, display the option selected in the selection that the user has selected in the filter earlier
		if (isset($_SESSION['selectedPeriod'])) {
			$selectedPeriod = $_SESSION['selectedPeriod'];
			if ($selectedPeriod == $allPeriod) {
				echo "<option selected value='" . $allPeriod . "' >All period </option>";
			}else{
				echo "<option value='" . $allPeriod . "' >All period </option>";
			}

			for ($i=1; $i <= $allPeriod; $i++) { 
				// if $i == 1 write "month"
				if ($i == 1) {
					if ($i == $selectedPeriod) {
						echo "<option selected value='1'>1 month</option>";
					}else{
						echo "<option value='1'>1 month</option>";
					}
				// if $i > 1 write  "monthS"
				}else{
					if ($i == $selectedPeriod) {
						echo "<option selected value='" . $i . "'>" . $i  . " months</option>";
					}else{
						echo "<option value='" . $i . "'>" . $i  . " months</option>";
					}
				}
			}
		}else{
			// If the user has not yet used the filter - display the selected option- "All period"
			echo "<option selected value='" . $allPeriod . "' >All period </option>";
			for ($i=1; $i <= $allPeriod; $i++) { 
				if (1 == $i) {
					echo "<option value='1'>1 month</option>";
				}else{
					echo "<option value='" . $i . "'>" . $i  . " months</option>";
				}
			}
		}
	}


	/**
	* This method draws checkboxes in the filter using data from $this->data['disciples'] .
	* Using these checkboxes, the user can select which disciplines to display on the chart
	*  If the user has already used the filter - display previously selected checkboxes with the "checked" property"
	* If the user has not yet used the filter - display all checkboxes with the "checked" property"
	* The chart will also be drawn with data for all disciplines
	* If there is nothing in the $date property - do not draw anything
 	* @access 	public
	*/
	public function drawCheckboxes()
	{	
		if (empty($this->data)) {
			return false;
		}
		//  array with all disciplines
		$disciplines = $this->data['disciplines'];
		// If the user has already used the filter - display previously selected checkboxes with the "checked" property"
		if (isset($_SESSION['selectedDisciplines'])) {
			//  selected checkboxes
			$selectedDisciplines = $_SESSION['selectedDisciplines'];
			$checkboxId = 1;
			foreach ($disciplines as $disciplineTitle => $applicationsNumber) {
				if (strstr($selectedDisciplines, $disciplineTitle)) {
					echo "<div class='form-check form-check-inline'>";
						echo "<input checked class='form-check-input filter_checkbox' type='checkbox' id='filter_checkbox_".$checkboxId."' name='disciplin[]' value='" . $disciplineTitle . "' onclick='filterCheckboxesHandler()'>";
						echo "<label class='form-check-label' for='filter_checkbox_".$checkboxId."'>" . $disciplineTitle . "</label>";
					echo "</div>";
				}else{
					echo "<div class='form-check form-check-inline'>";
						echo "<input class='form-check-input filter_checkbox' type='checkbox' id='filter_checkbox_".$checkboxId."' name='disciplin[]' value='" . $disciplineTitle . "' onclick='filterCheckboxesHandler()'>";
						echo "<label class='form-check-label' for='filter_checkbox_".$checkboxId."'>" . $disciplineTitle . "</label>";
					echo "</div>";
				}
				$checkboxId++;
			}
			echo "<div class='form-check form-check-inline'>";
  				echo '<input class="form-check-input filter_checkbox_general" type="checkbox" id="filter_check_all" value="All disciplines" onclick="filterGeneralCheckboxHandler()">';
				echo '<label class="form-check-label" for="filter_check_all">All disciplines</label>';
			echo "</div>";
		}else{
			// If the user has not yet used the filter - display all checkboxes with the "checked" property"
			$checkboxId = 1;
			foreach ($disciplines as $disciplineTitle => $applicationsNumber) {
				echo "<div class='form-check form-check-inline'>";
					echo "<input checked class='form-check-input filter_checkbox' type='checkbox' id='filter_checkbox_".$checkboxId."' name='disciplin[]' value='" . $disciplineTitle . "' onclick='filterCheckboxesHandler()'>";
					echo "<label class='form-check-label' for='filter_checkbox_".$checkboxId."'>" . $disciplineTitle . "</label>";
				echo "</div>";
				$checkboxId++;
			}
			echo "<div class='form-check form-check-inline'>";
  				echo '<input checked class="form-check-input filter_checkbox_general" type="checkbox" id="filter_check_all" value="All disciplines" onclick="filterGeneralCheckboxHandler()">';
				echo '<label class="form-check-label" for="filter_check_all">All disciplines</label>';
			echo "</div>";
		}
	}


	/**
	* This method is called both via AJAX and in the usual way
	* This method takes the data from the $data property and prepares it for drawing a JS file,
	* if the user used the filter-you need to give the data in accordance with the filter configurations
	* if not - give the information without filtering.
	*
	* @param $isAJAX is false by default , if you want to read the answer in JS via AJAX using "request.responseText"
	* when calling the method set "$isAJAX" - true
	*
	* @return false if  $this->data is empty
	* @return string $dataForChart in JSON format if $isAJAX is false
	*
	*/
	public function prepareDataForChart($isAJAX=false)
	{	
		// If $this->data is empty - do nothing
		if (empty($this->data)) {
			return false;
		}

		// if we have saved filter configurations - filter the data according to them
		if (isset($_SESSION['selectedPeriod']) && isset($_SESSION['selectedDisciplines'])) {
			// save in a variable the selected number of months
			$period = array_slice($this->data['period'], 0, $_SESSION['selectedPeriod']) ;

			// save only selected disciplines with data for the selected period to the variable
			$disc = $this->data['disciplines'];
			foreach ($disc as $disciplineTitle => $applicationsNumber) {
				if (strstr($_SESSION['selectedDisciplines'], $disciplineTitle)) {
					$disciplines[$disciplineTitle] = array_slice($applicationsNumber, 0, $_SESSION['selectedPeriod']);
				}
			}
			$dataForChart['Disciplines'] = $disciplines;
			$dataForChart['Period'] = $period;
		}else{
			$dataForChart['Disciplines'] = $this->data['disciplines'];
			$dataForChart['Period'] = $this->data['period'];
			
		}
		
		if ($isAJAX) {
			echo json_encode($dataForChart);
		}else{
			return json_encode($dataForChart);
		}
	}
}