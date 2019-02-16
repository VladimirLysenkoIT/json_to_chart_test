function drawChart(data_json) {
  // wrap where the canvas is embedded
  var chartWrap = document.getElementById('chart_wrap');
  chartWrap.innerHTML = "";
  chartWrap.innerHTML = '<canvas style="width: 800px !important; height: 400px !important;" id="myChart" ></canvas>';
  
  // canvas in which the chart is embedded
  var ctx = document.getElementById('myChart').getContext('2d');

  // data set for plotting
  var dataset = [];
  var i = 0;
  Object.keys(data_json["Disciplines"]).map(function(objectKey, index) {
    dataset[i] = {
    label: objectKey,
        fill: false,
        backgroundColor: chartPalette[objectKey],
        borderColor: chartPalette[objectKey],
        data: data_json["Disciplines"][objectKey],
    };
    ++i;
});

  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'line',
      // The data for our dataset
      data: {
          labels: data_json["Period"],
          datasets: dataset
      },
      // Configuration options go here
     options: {
          responsive: true,
          title: {
            display: true,
            text: 'Chart.js Line Chart'
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          scales: {
            xAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Month'
              }
            }],
            yAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Value'
              }
            }]
          }
        }
  });
}