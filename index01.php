<?php
    session_save_path("./sess");
    include "db.php";

    $conn = connectDB();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KPC 보안 프로그래밍 과정</title>

  <!-- Bootstrap5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">KPC</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              취약점 확인
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">SQL Injection</a></li>
              <li><a class="dropdown-item" href="#">SQL Injection(Secure)</a></li>
              <li><a class="dropdown-item" href="#">menu1-3</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              menu2
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu2-1</a></li>
              <li><a class="dropdown-item" href="#">menu2-2</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              menu3
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu3-1</a></li>
              <li><a class="dropdown-item" href="#">menu3-2</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main class="container flex-grow-1 d-flex align-items-center justify-content-center">
    <h1>KPC 보안 프로그래밍 과정</h1>
  </main>

  <!-- Footer -->
  <footer class="bg-light border-top py-3 mt-auto">
    <div class="container text-center">
      한국 생산성본부(KPC)<br>
      정보보호책임자: 홍길동(help@kpc.or.kr)
    </div>
  </footer>

  <!-- Bootstrap5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>