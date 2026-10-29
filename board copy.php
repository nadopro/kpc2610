<?php
// board.php
// index.php에서 $conn, session_start() 완료 상태

$mode = $_GET['mode'] ?? 'list';

$login_id = $_SESSION['id'] ?? '';
$login_name = $_SESSION['name'] ?? '';
$login_level = $_SESSION['level'] ?? 1;

$is_login = ($login_id != '');
$is_admin = ($login_level >= 9);

// 글쓰기 처리
if ($mode == "do_write") {

    if (!$is_login) {
        echo "<div class='alert alert-danger'>로그인 후 글쓰기가 가능합니다.</div>";
        exit;
    }

    //$title = mysqli_real_escape_string($conn, $_POST['title']);
    //$html  = mysqli_real_escape_string($conn, $_POST['html']);

    $title = $_POST['title'];
    $html  = $_POST['html'];



    $sql = "INSERT INTO board(id, name, title, html, time)
            VALUES('$login_id', '$login_name', '$title', '$html', NOW())";

    mysqli_query($conn, $sql);

    echo "<script>
            alert('글이 등록되었습니다.');
            location.href='index.php?cmd=board';
          </script>";
    exit;
}

// 삭제 처리
if ($mode == "delete") {

    $idx = intval($_GET['idx']);

    $sql = "SELECT * FROM board WHERE idx=$idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (!$row) {
        echo "<div class='alert alert-danger'>글이 없습니다.</div>";
        exit;
    }

    if ($is_admin || $row['id'] == $login_id) {

        $sql = "DELETE FROM board WHERE idx=$idx";
        mysqli_query($conn, $sql);

        echo "<script>
                alert('삭제되었습니다.');
                location.href='index.php?cmd=board';
              </script>";
        exit;

    } else {
        echo "<div class='alert alert-danger'>삭제 권한이 없습니다.</div>";
        exit;
    }
}
?>

<div class="container">

<?php
// 글목록
if ($mode == "list") {

    $sql = "SELECT * FROM board ORDER BY idx DESC";
    $result = mysqli_query($conn, $sql);
?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>게시판</h3>

        <?php if ($is_login) { ?>
            <a href="index.php?cmd=board&mode=write" class="btn btn-primary">
                글쓰기
            </a>
        <?php } ?>
    </div>

    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th class="d-none d-md-table-cell" style="width:80px;">번호</th>
                <th>제목</th>
                <th style="width:120px;">작성자</th>
                <th class="d-none d-md-table-cell" style="width:180px;">작성일</th>
            </tr>
        </thead>

        <tbody>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td class="d-none d-md-table-cell text-center">
                    <?= $row['idx'] ?>
                </td>

                <td>
                    <a href="index.php?cmd=board&mode=show&idx=<?= $row['idx'] ?>"
                       class="text-decoration-none">
                        <?= $row['title'] ?>
                    </a>
                </td>

                <td class="text-center">
                    <?= $row['name'] ?>
                </td>

                <td class="d-none d-md-table-cell text-center">
                    <?= $row['time'] ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

<?php
}

// 글쓰기
else if ($mode == "write") {

    if (!$is_login) {
        echo "<div class='alert alert-danger'>로그인 후 글쓰기가 가능합니다.</div>";
    } else {
?>

    <h3 class="mb-3">글쓰기</h3>

    <form method="post" action="index.php?cmd=board&mode=do_write">

        <div class="mb-3">
            <label class="form-label">작성자</label>
            <input type="text"
                   class="form-control"
                   value="<?= $login_name ?>"
                   readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">제목</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">내용</label>
            <textarea name="html"
                      class="form-control"
                      rows="10"
                      required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            저장
        </button>

        <a href="index.php?cmd=board" class="btn btn-secondary">
            목록
        </a>

    </form>

<?php
    }
}

// 글보기
else if ($mode == "show") {

    $idx = intval($_GET['idx']);

    $sql = "UPDATE board SET nread = nread + 1 WHERE idx=$idx";
    mysqli_query($conn, $sql);

    $sql = "SELECT * FROM board WHERE idx=$idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (!$row) {
        echo "<div class='alert alert-danger'>글이 없습니다.</div>";
    } else {
?>

    <h3 class="mb-3">글보기</h3>

    <div class="card">
        <div class="card-header">
            <strong><?= $row['title'] ?></strong>
        </div>

        <div class="card-body">

            <div class="mb-3 text-muted">
                작성자 : <?= $row['name'] ?> |
                작성일 : <?= $row['time'] ?> |
                조회수 : <?= $row['nread'] ?>
            </div>

            <hr>

            <div style="min-height:200px;">
                <?= nl2br($row['html']) ?>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between">

            <a href="index.php?cmd=board" class="btn btn-secondary">
                목록
            </a>

            <?php if ($is_admin || $row['id'] == $login_id) { ?>
                <a href="index.php?cmd=board&mode=delete&idx=<?= $row['idx'] ?>"
                   class="btn btn-danger"
                   onclick="return confirm('정말 삭제하시겠습니까?');">
                    삭제
                </a>
            <?php } ?>

        </div>
    </div>

<?php
    }
}
?>

</div>