<?php
// slow.php
// index.php에서 include 되는 파일

$start = microtime(true);

// 1초 지연
sleep(1);

$end = microtime(true);

$elapsed = $end - $start;
$elapsed_ms = $elapsed * 1000;
?>

<div class="container">

    <div class="card">

        <div class="card-header bg-primary text-white">
            Slow Page (1초 지연)
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="180">시작 시간</th>
                    <td><?= date("Y-m-d H:i:s", (int)$start) ?>.<?= sprintf("%03d", ($start - floor($start))*1000) ?></td>
                </tr>

                <tr>
                    <th>종료 시간</th>
                    <td><?= date("Y-m-d H:i:s", (int)$end) ?>.<?= sprintf("%03d", ($end - floor($end))*1000) ?></td>
                </tr>

                <tr>
                    <th>처리 시간 (초)</th>
                    <td><?= number_format($elapsed, 6) ?> sec</td>
                </tr>

                <tr>
                    <th>처리 시간 (ms)</th>
                    <td><?= number_format($elapsed_ms, 3) ?> ms</td>
                </tr>

            </table>

        </div>

    </div>

</div>