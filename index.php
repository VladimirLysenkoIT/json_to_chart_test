<?php
session_start();
// variables
require 'library.php';
require "classes/JsonHandler.php";
$JsonHandler = new JsonHandler();
$JsonHandler->getJsonFromFile($jsonFilePath);
$dataForGraph = $JsonHandler->prepareDataForChart();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- css including, title -->
    <?php include 'templates/header.php'?>
  </head>
  <body>
    <!-- main content(table/filter/chart)-->
    <?php include 'templates/main.php'?>
    <!-- js files including and call drawChart()-->
    <?php include 'templates/footer.php'?>
  </body>
</html>