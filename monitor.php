    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      <?php
        $sql = "select * from iot";
        $result = mysqli_query($conn, $sql);
        $dataCount = mysqli_num_rows($result);

        //echo "dataCount = $dataCount<br>"; // 150
        $start = $dataCount - 100 +1;
      ?>

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['시간', '온도', '습도'],

          <?php
            $sql = "select * from iot order by idx asc limit $start, 100";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_array($result);
            while($data)
            {
              echo "['$data[time]', $data[temp], $data[hum] ],";
              $data = mysqli_fetch_array($result);
            }
          ?>

         
        ]);

        var options = {
          title: 'IoT 센서',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);

      }
    </script>

 
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  

    <script>
    setTimeout(function () {
        location.href = "index.php?cmd=monitor";
    }, 3000);
    </script>