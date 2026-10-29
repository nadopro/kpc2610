<?php
// gen.php
// index.php에서 $conn 연결이 완료되어 있다고 가정

$temp = rand(250, 260) / 10;   // 25.0 ~ 26.0
$hum  = rand(500, 550) / 10;   // 50.0 ~ 55.0

$sql = "INSERT INTO iot (temp, hum, time)
        VALUES ($temp, $hum, now())";

mysqli_query($conn, $sql);

echo "<h3>IoT 센서 데이터 생성</h3>";

echo "<table class='table table-bordered w-50'>";
echo "<tr><th>온도(Temp)</th><td>{$temp} ℃</td></tr>";
echo "<tr><th>습도(Hum)</th><td>{$hum} %</td></tr>";
echo "<tr><th>생성시간</th><td>" . date("Y-m-d H:i:s") . "</td></tr>";
echo "</table>";

echo "<div class='alert alert-success'>";
echo "DB에 저장되었습니다.<br>";
echo "3초 후 다음 데이터를 생성합니다.";
echo "</div>";
?>

<script>
setTimeout(function () {
    location.href = "index.php?cmd=gen";
}, 3000);
</script>