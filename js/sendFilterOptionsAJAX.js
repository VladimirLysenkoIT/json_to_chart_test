function sendFilterOptions(params) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if(request.readyState == 4 && request.status == 200){
      graphData = JSON.parse(request.responseText);
      drawChart(graphData);
    }
  }
  request.open("POST", "functions/getChartData.php");
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send(params);
}