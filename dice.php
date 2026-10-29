<?php
// dice.php

$count = $_POST['count'] ?? 60;
$count = intval($count);

$dice = [
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0
];

$executed = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($count < 1) {
        $count = 60;
    }

    for ($i = 0; $i < $count; $i++) {
        $num = rand(1, 6);
        $dice[$num]++;
    }

    $executed = true;
}
?>

<h3 class="mb-3">주사위 던지기 실습</h3>

<form method="post" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="number"
               name="count"
               class="form-control"
               value="<?= $count ?>"
               min="1">
    </div>

    <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">
            실행
        </button>
    </div>
</form>

<?php if ($executed) { ?>

<table class="table table-bordered text-center align-middle">
    <thead class="table-dark">
        <tr>
            <th>주사위 번호</th>
            <th>출현횟수</th>
            <th>비율</th>
        </tr>
    </thead>

    <tbody>
        <?php for ($i = 1; $i <= 6; $i++) { 
            $rate = ($dice[$i] / $count) * 100;
        ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $dice[$i] ?></td>
            <td><?= number_format($rate, 2) ?>%</td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php } ?>