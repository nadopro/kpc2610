<?php
// injection4.php

function decodeText($str) {
    return base64_decode($str);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id   = decodeText($_POST['id']);
    $pass = decodeText($_POST['pass']);

    $id = str_replace("--", "", $id);
    $id = str_replace("'", "", $id);
    $id = str_replace('"', "", $id);

    $pass = str_replace("--", "", $pass);
    $pass = str_replace("'", "", $pass);
    $pass = str_replace('"', "", $pass);

    $sql = "SELECT * FROM users WHERE id='$id' AND pass='$pass'";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($result)) {

        $_SESSION['login'] = true;
        $_SESSION['idx']   = $row['idx'];
        $_SESSION['id']    = $row['id'];
        $_SESSION['name']  = $row['name'];
        $_SESSION['level'] = $row['level'];

        $msg = "<div class='alert alert-success'>로그인 성공</div>";
        ?>
            <script>
                location.href='index.php?cmd=injection4';
            </script>
       <?php
    } else {
        $msg = "<div class='alert alert-danger'>로그인 실패</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card">

            <div class="card-header bg-danger text-white">
                SQL Injection 실습 - 인코딩 저장/전송
            </div>

            <div class="card-body">

                <?php
                if (isset($msg)) {
                    echo $msg;
                }
                ?>

                <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>

                    <div class="alert alert-info">
                        <b>현재 로그인 상태</b><br><br>
                        ID : <?= $_SESSION['id'] ?><br>
                        이름 : <?= $_SESSION['name'] ?><br>
                        권한 : <?= $_SESSION['level'] ?>
                    </div>

                    <div class="d-grid">
                        <a href="index.php?cmd=logout" class="btn btn-secondary">
                            로그아웃
                        </a>
                    </div>

                <?php } else { ?>

                    <form method="post" onsubmit="return encodeLoginData();">

                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="pass" id="pass">

                        <div class="mb-3">
                            <label class="form-label">ID</label>

                            <div class="input-group">
                                <div class="input-group-text">
                                    <input type="checkbox" id="save_id" name="save_id" class="form-check-input mt-0">
                                    <span class="ms-2">저장</span>
                                </div>

                                <input
                                    type="text"
                                    id="id_view"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <div class="input-group">
                                <div class="input-group-text">
                                    <input type="checkbox" id="save_pass" name="save_pass" class="form-check-input mt-0">
                                    <span class="ms-2">저장</span>
                                </div>

                                <input
                                    type="password"
                                    id="pass_view"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">
                                Login
                            </button>
                        </div>

                    </form>

                <?php } ?>

            </div>
        </div>

    </div>
</div>

<script>
function encodeBase64(str) {
    return btoa(unescape(encodeURIComponent(str)));
}

function decodeBase64(str) {
    return decodeURIComponent(escape(atob(str)));
}

window.onload = function() {
    const savedId = localStorage.getItem("saved_id");
    const savedPass = localStorage.getItem("saved_pass");

    if (savedId !== null) {
        document.getElementById("id_view").value = decodeBase64(savedId);
        document.getElementById("save_id").checked = true;
    }

    if (savedPass !== null) {
        document.getElementById("pass_view").value = decodeBase64(savedPass);
        document.getElementById("save_pass").checked = true;
    }
};

function encodeLoginData() {
    const idValue = document.getElementById("id_view").value;
    const passValue = document.getElementById("pass_view").value;

    const saveId = document.getElementById("save_id").checked;
    const savePass = document.getElementById("save_pass").checked;

    const encodedId = encodeBase64(idValue);
    const encodedPass = encodeBase64(passValue);

    document.getElementById("id").value = encodedId;
    document.getElementById("pass").value = encodedPass;

    if (saveId) {
        localStorage.setItem("saved_id", encodedId);
    } else {
        localStorage.removeItem("saved_id");
    }

    if (savePass) {
        localStorage.setItem("saved_pass", encodedPass);
    } else {
        localStorage.removeItem("saved_pass");
    }

    return true;
}
</script>
