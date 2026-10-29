<?php
// injection.php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id   = $_POST['id'];
    $pass = $_POST['pass'];

    // -------------------------------
    // SQL Injection 취약 코드 (실습용)
    // -------------------------------

    $id = str_replace("--", "", $id);
    $id = str_replace("'", "", $id);
    $id = str_replace('"', "", $id);

    $pass = str_replace("--", "", $pass);
    $pass = str_replace("'", "", $pass);
    $pass = str_replace('"', "", $pass);


    $sql = "SELECT * FROM users WHERE id='$id' AND pass='$pass'";

    $result = mysqli_query($conn, $sql);


    if ($row = mysqli_fetch_array($result)) {

        echo "idx = $row[idx]<br>";
        $_SESSION['login'] = true;
        $_SESSION['idx']   = $row['idx'];
        $_SESSION['id']    = $row['id'];
        $_SESSION['name']  = $row['name'];
        $_SESSION['level'] = $row['level'];

        $msg = "<div class='alert alert-success'>
                    로그인 성공
                </div>";
        ?>
            <script>
                location.href='index.php?cmd=injection2';
            </script>
       <?php
    } else {

        $msg = "<div class='alert alert-danger'>
                    로그인 실패
                </div>";

    }
}
?>

<div class="row justify-content-center">

    <div class="col-md-5">

        <div class="card">

            <div class="card-header bg-danger text-white">
                SQL Injection 실습 (취약한 로그인)
            </div>

            <div class="card-body">

                <?php
                if (isset($msg)) {
                    echo $msg;
                }
                ?>

                <?php
                if (isset($_SESSION['login']) && $_SESSION['login']) {
                ?>

                    <div class="alert alert-info">

                        <b>현재 로그인 상태</b><br><br>

                        ID : <?= $_SESSION['id'] ?><br>
                        이름 : <?= $_SESSION['name'] ?><br>
                        권한 : <?= $_SESSION['level'] ?>

                    </div>

                    <div class="d-grid">

                        <a href="index.php?cmd=logout"
                           class="btn btn-secondary">
                            로그아웃
                        </a>

                    </div>

                <?php
                } else {
                ?>

                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label">ID</label>

                            <input
                                type="text"
                                name="id"
                                class="form-control">
                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="pass"
                                class="form-control">

                        </div>

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-danger">

                                Login

                            </button>

                        </div>

                    </form>

                <?php
                }
                ?>

            </div>

        </div>

    </div>

</div>
