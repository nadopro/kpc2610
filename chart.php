    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'SQL Injection', 'DDoS', 'XSS'],
          ['2004',  1000,      400, 123],
          ['2005',  10,      460, 1200],
          ['2006',  2000,       1120, 777],
          ['2007',  1030,      540, 567]
        ]);

        var options = {
          title: '취약점 분석',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);

        chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));
        chart.draw(data, options);
      }
    </script>

 
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  
    <div id="curve_chart2" style="width: 100%; height: 500px"></div>
  