<?php
// resource.php

// ------------------------------------
// CPU 사용률
// ------------------------------------

$cmd = 'powershell -NoProfile -ExecutionPolicy Bypass -Command "(Get-Counter \"\\Processor(_Total)\\% Processor Time\").CounterSamples.CookedValue"';

$cpu = shell_exec($cmd);
echo $cpu;

$cpu = number_format((float)$cpu, 1);


// ------------------------------------
// Apache 메모리 사용량(MB)
// ------------------------------------

$memory = trim(shell_exec(
    'powershell -Command "((Get-Process httpd | Measure-Object WorkingSet64 -Sum).Sum/1MB)"'
));

$memory = number_format((float)$memory, 2);


// ------------------------------------
// Apache 프로세스 수
// ------------------------------------

$process = trim(shell_exec(
    'powershell -Command "(Get-Process httpd).Count"'
));

if($process=="")
    $process=0;

?>

<h3>Server Resource Monitor</h3>

<table class="table table-bordered" style="max-width:500px;">
<tr>
    <th style="width:180px;">CPU 사용률</th>
    <td><?= $cpu ?> %</td>
</tr>

<tr>
    <th>Apache Memory</th>
    <td><?= $memory ?> MB</td>
</tr>

<tr>
    <th>Apache Process</th>
    <td><?= $process ?></td>
</tr>

<tr>
    <th>갱신 시간</th>
    <td><?= date("Y-m-d H:i:s") ?></td>
</tr>

</table>

<script>
setTimeout(function(){

    location.href="index.php?cmd=resource";

},3000);
</script>