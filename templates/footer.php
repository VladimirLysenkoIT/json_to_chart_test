	
	<script>
    window.onload = function() {
      var json_graph_data = <?php echo $dataForGraph; ?>;
      drawChart(json_graph_data);
    };
  </script>
  <!-- my js files -->
  <script type="text/javascript" src="js/chartPalette.js"></script>
  <script type="text/javascript" src="js/filterDataHandler.js"></script>
	<script type="text/javascript" src="js/sendFilterOptionsAJAX.js"></script>
  <script type="text/javascript" src="js/filterGeneralCheckboxHandler.js"></script>
  <script type="text/javascript" src="js/filterCheckboxesHandler.js"></script>
  <!-- Chartjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
  <!-- chart draw function -->
  <script type="text/javascript" src="js/chartjs/drawChart.js"></script>
     <!-- END chart js -->
	<!-- END my js files -->
  </body>
</html>