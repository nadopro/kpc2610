<?php
// brute2.php
// index.php에서 $conn 연결이 이미 되어 있다고 가정

set_time_limit(0);

function makeText($number, $length)
{
    $text = "";

    for ($i = 0; $i < $length; $i++) {
        $text = chr(($number % 26) + 97) . $text;
        $number = intdiv($number, 26);
    }

    return $text;
}
?>

<h3>Brute Force 비밀번호 탐색 실습</h3>

<form method="post" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label">최소 글자 수</label>
            <input type="number" name="min" class="form-control" value="4" min="1" max="8">
        </div>

        <div class="col-md-3">
            <label class="form-label">최대 글자 수</label>
            <input type="number" name="max" class="form-control" value="6" min="1" max="8">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-danger">
                탐색 시작
            </button>
        </div>
    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $min = intval($_POST['min']);
    $max = intval($_POST['max']);

    if ($min < 1) {
        $min = 1;
    }

    if ($max < $min) {
        $max = $min;
    }

    echo "<pre>";

    echo "탐색 범위 : {$min}글자 ~ {$max}글자\n";
    echo "사용 문자 : a ~ z\n\n";

    $count = 0;
    $found = false;

    for ($length = $min; $length <= $max; $length++) {

        $total = pow(26, $length);

        echo "\n{$length}글자 탐색 시작\n";
        echo "가능한 조합 수 : {$total}\n";
        echo "-----------------------------\n";

        for ($i = 0; $i < $total; $i++) {

            $text = makeText($i, $length);
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
                echo "찾은 비밀번호 : {$text}\n";
                echo "총 검사 횟수 : {$count}회\n\n";

                echo "동일한 비밀번호를 가진 사용자 목록\n";
                echo "--------------------------------\n";

                while ($row = mysqli_fetch_array($result)) {
                    echo "ID: {$row['id']} / 이름: {$row['name']} / 권한: {$row['level']}\n";
                }

                $found = true;
                break 2;
            }
        }
    }

    if (!$found) {
        echo "\n비밀번호를 찾지 못했습니다.\n";
        echo "총 검사 횟수 : {$count}회\n";
    }

    echo "</pre>";
}
?>