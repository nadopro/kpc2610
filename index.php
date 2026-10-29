<?php
session_save_path("./sess");
session_start();

include "config.php";
include "db.php";

$conn = connectDB();

// cmd가 없으면 init
$cmd = $_GET['cmd'] ?? "init";

$ip1 = rand(1, 255);
$ip2 = rand(1, 255);
$ip3 = rand(1, 255);
$ip4 = rand(1, 255);

$ip = $_SERVER["REMOTE_ADDR"];
$ip = "$ip1.$ip2.$ip3.$ip4";
$myid = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$work = $_SERVER['QUERY_STRING'];

    $sql = "insert into log (ip, id, work, time) values 
                ('$ip', '$myid', '$work', now())";

    $result = mysqli_query($conn, $sql);

    $sql = "select * from black_table where ip='$ip'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    if($data)
    {
        // rejects
        $sql = "update black_table set rejects = rejects + 1 where ip='$ip'";
        $result = mysqli_query($conn, $result);
        echo "
        <script>
            location.href='http://warning.or.kr';
        </script>
        ";

    }

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPC 보안 프로그래밍 과정</title>

    <!-- Bootstrap5 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="index.php">KPC</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto">

                <!-- Menu1 -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        취약점 확인
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?cmd=injection">SQL Injection</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=injection2">Secure Injection(Secure)</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=injection3">Save ID</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=injection4">Secure Save</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=brute">Brute Force</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=brute2">Brute Length</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=brute3">Brute Sequence</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=shell">Web Shell</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=chart">Chart</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=gen">Generator</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=monitor">Monitor</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=network">Network</a></li>

                        <li><a class="dropdown-item" href="index.php?cmd=board">게시판</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=editor">WYSIWYG</a></li>

                    </ul>
                </li>

                <!-- Menu2 -->
                <?php 
                if(isset($_SESSION['id']) and $_SESSION['level'] >=9 )
                {

                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        보안코딩
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?cmd=attack">DDoS 흉내</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=slow">시간측정</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=gps">IP 상세정보</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=gps2">IP AJAX</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=ftp">웹 탐색기</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=log">로그 관리</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=log2">로그 시각화</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=join">회원가입(AJAX)</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=dice">주사위(랜덤)</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=fake">페이크</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=resource">CPU/Mem</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=dice">주사위(랜덤)</a></li>
                    </ul>
                </li>

                <?php
                }
                ?>
                <!-- Menu3 -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        기타
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?cmd=init">메인</a></li>
                        <li><a class="dropdown-item" href="index.php?cmd=test">Test</a></li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>

<!-- Content -->
<main class="container flex-grow-1 py-4">

<?php
include $cmd . ".php";
?>

</main>

<!-- Footer -->
<footer class="bg-light border-top py-3 mt-auto">
    <div class="container text-center">
        <strong>한국 생산성본부(KPC)</strong><br>
        정보보호책임자 : 홍길동 (help@kpc.or.kr)
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
closeDB($conn);
?>
