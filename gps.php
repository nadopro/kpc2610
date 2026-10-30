<?php
// gps.php

$ip = $_POST['ip'] ?? '';

$jsonPretty = '';
$errorMsg = '';

$status = '';
$country = '';
$lat = '';
$lon = '';
$position = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ip = trim($ip);

    if ($ip == '') {
        $errorMsg = 'IP 주소를 입력하세요.';
    } else {

        $url = "http://ip-api.com/json/" . urlencode($ip);

        // cURL 확장이 비활성화된 환경에서는 PHP 스트림으로 요청합니다.
        $response = false;

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            if ($response === false) {
                $errorMsg = '네트워크 오류: ' . curl_error($ch);
            }
            curl_close($ch);
        } elseif (filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN)) {
            $context = stream_context_create([
                'http' => ['method' => 'GET', 'timeout' => 10, 'ignore_errors' => true]
            ]);
            $response = @file_get_contents($url, false, $context);
            if ($response === false) {
                $errorMsg = '네트워크 요청에 실패했습니다. 방화벽 또는 외부 HTTP 연결을 확인하세요.';
            }
        } else {
            $errorMsg = 'cURL 확장과 allow_url_fopen이 모두 비활성화되어 있습니다. php.ini에서 extension=curl을 활성화하세요.';
        }

        if ($response !== false) {
            $data = json_decode($response, true);
            if (!is_array($data)) {
                $errorMsg = 'API 응답을 JSON으로 해석할 수 없습니다.';
            } else {
                $jsonPretty = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
                if (($data['status'] ?? '') === 'success') {
                    $status   = $data['status'];
                    $country  = (string) ($data['country'] ?? '');
                    $lat      = (string) ($data['lat'] ?? '');
                    $lon      = (string) ($data['lon'] ?? '');
                    $position = "$lat,$lon";
                } else {
                    $errorMsg = '조회 실패: ' . (string) ($data['message'] ?? '알 수 없는 오류');
                }
            }
        }
    }
}
?>

<h3 class="mb-3">IP 위치 조회</h3>

<form method="post" class="row g-2 mb-3">

    <div class="col-md-10">
        <input type="text"
               name="ip"
               class="form-control"
               placeholder="예: 8.8.8.8"
               value="<?= htmlspecialchars($ip) ?>">
    </div>

    <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">
            실행
        </button>
    </div>

</form>

<?php if ($errorMsg != '') { ?>
    <div class="alert alert-warning">
        <?= htmlspecialchars($errorMsg) ?>
    </div>
<?php } ?>

<?php if ($status == 'success') { ?>

<table class="table table-bordered mt-3">
    <tr>
        <th style="width:150px;">status</th>
        <td><?= htmlspecialchars($status) ?></td>
    </tr>

    <tr>
        <th>country</th>
        <td><?= htmlspecialchars($country) ?></td>
    </tr>

    <tr>
        <th>위치</th>
        <td>
            <?= htmlspecialchars($position) ?>

            <button type="button"
                    class="btn btn-sm btn-primary ms-2"
                    onclick="window.open('https://google.com/maps?q=<?= urlencode($position) ?>', 'mapPopup', 'width=900,height=700');">
                지도 보기
            </button>
        </td>
    </tr>
</table>

<?php } ?>

<?php if ($jsonPretty != '') { ?>

    <label class="form-label">JSON 결과</label>

    <textarea class="form-control"
              rows="18"
              readonly><?= htmlspecialchars($jsonPretty) ?></textarea>

<?php } ?>