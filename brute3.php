<?php

// GET 방식으로 cnt 값 가져오기, 기본값은 0
$cnt = isset($_GET['cnt']) ? intval($_GET['cnt']) : 0;

// 문자 조합 생성에 사용할 알파벳
$letters = "abcdefghij";
$size = strlen($letters);

// 문자 조합 생성
$pass = "";
$tempCnt = $cnt;
for ($i = 0; $i < 4; $i++) { // 4글자 조합 생성
    $index = $tempCnt % $size; // 현재 자릿수 문자 결정
    $pass = $letters[$index] . $pass; // 조합에 문자 추가
    $tempCnt = intdiv($tempCnt, $size); // 다음 자릿수로 이동
}

// SQL 쿼리 실행
$sql = "SELECT * FROM users WHERE pass='$pass'";
$result = mysqli_query($conn, $sql);
echo "sql = $sql<br>";

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Found match for pass: $pass</h3>";
    while ($data = mysqli_fetch_array($result)) {
        echo "ID: {$data['id']}, PASS: {$data['pass']}<br>";
    }
    exit; // 비밀번호를 찾으면 종료
} else {
    echo "<p>No match for pass: $pass</p>";
}

// 다음 cnt 값을 계산
$nextCnt = $cnt + 1;

// 1초 후에 다음 링크로 이동
$sleep = rand(10, 500);
echo "
sleep = $sleep <br>
<script>
    setTimeout(function() {
        window.location.href = 'index.php?cmd=brute3&cnt=$nextCnt';
    }, $sleep); // 1초 대기
</script>
";
?>
