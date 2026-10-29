<?php
// brute.php
// index.php에서 $conn 연결이 이미 되어 있다고 가정

set_time_limit(0);

echo "<h3>Brute Force 비밀번호 탐색 실습</h3>";
echo "<pre>";

$count = 0;
$found = false;

for ($a = ord('a'); $a <= ord('z'); $a++) {
    for ($b = ord('a'); $b <= ord('z'); $b++) {
        for ($c = ord('a'); $c <= ord('z'); $c++) {
            for ($d = ord('a'); $d <= ord('z'); $d++) {

                $text = chr($a) . chr($b) . chr($c) . chr($d);
                $count++;

                if ($count % 1000 == 0) {
                    echo "{$count}회 검사 중... 현재 값: {$text}\n";
                    flush();
                    ob_flush();
                }

                $sql = "SELECT * FROM users WHERE pass='$text'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {

                    echo "\n비밀번호 발견!\n";
                    echo "찾은 비밀번호: {$text}\n";
                    echo "총 검사 횟수: {$count}회\n\n";
                    echo "동일한 비밀번호를 가진 사용자 목록\n";
                    echo "--------------------------------\n";

                    while ($row = mysqli_fetch_array($result)) {
                        echo "ID: {$row['id']} / 이름: {$row['name']} / 권한: {$row['level']}\n";
                    }

                    $found = true;
                    break 4;
                }
            }
        }
    }
}

if (!$found) {
    echo "\n비밀번호를 찾지 못했습니다.\n";
    echo "총 검사 횟수: {$count}회\n";
}

echo "</pre>";
?>