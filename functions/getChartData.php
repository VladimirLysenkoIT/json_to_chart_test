<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	function getChartData()
	{
		require '../library.php';
		require PATH . "/classes/JsonHandler.php";
		$period = $_POST['selectedPeriod'];
		$disciplines = $_POST['selectedDisciplines'];
	
		$JsonHandler = new JsonHandler();
		$JsonHandler->getJsonFromFile($jsonFilePath);
		$JsonHandler->setFilterConfiguration($period, $disciplines);
		$JsonHandler->prepareDataForChart(true);
	}
	getChartData();	
}

