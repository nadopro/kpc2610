<?php
// board.php
// index.php에서 $conn, session_start() 완료 상태
// board 테이블에는 ip 필드가 있다고 가정합니다.
// 예: ALTER TABLE board ADD ip CHAR(20) DEFAULT '10.20.30.40';

$mode = $_GET['mode'] ?? 'list';

$login_id = $_SESSION['id'] ?? '';
$login_name = $_SESSION['name'] ?? '';
$login_level = $_SESSION['level'] ?? 1;

$is_login = ($login_id != '');
$is_admin = ($login_level >= 9);

// 접속 IP 확인 함수
function getClientIp()
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// 글쓰기 처리
if ($mode == "do_write") {

    if (!$is_login) {
        echo "<div class='alert alert-danger'>로그인 후 글쓰기가 가능합니다.</div>";
        exit;
    }

    // XSS 실습을 위해 입력값을 그대로 저장하는 구조를 유지합니다.
    // 실제 서비스에서는 mysqli_real_escape_string(), prepared statement, 출력 시 htmlspecialchars()가 필요합니다.
    $title = $_POST['title'];
    $html  = $_POST['html'];
    $ip    = getClientIp();

    $sql = "INSERT INTO board(id, name, title, html, ip, time)
            VALUES('$login_id', '$login_name', '$title', '$html', '$ip', NOW())";

    mysqli_query($conn, $sql);

    echo "<script>
            alert('글이 등록되었습니다.');
            location.href='index.php?cmd=board';
          </script>";
    exit;
}

// 블랙리스트 등록 처리
if ($mode == "black") {

    if (!$is_admin) {
        echo "<div class='alert alert-danger'>관리자만 사용할 수 있습니다.</div>";
        exit;
    }

    $idx = intval($_GET['idx'] ?? 0);

    $sql = "SELECT idx, ip FROM board WHERE idx=$idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (!$row) {
        echo "<div class='alert alert-danger'>글이 없습니다.</div>";
        exit;
    }

    $ip = trim($row['ip']);

    if ($ip == '') {
        echo "<div class='alert alert-danger'>등록할 IP 정보가 없습니다.</div>";
        exit;
    }

    // black_table에 이미 등록된 IP인지 확인
    $sql = "SELECT idx FROM black_table WHERE ip='$ip'";
    $result = mysqli_query($conn, $sql);
    $black = mysqli_fetch_array($result);

    if ($black) {
        // 이미 등록되어 있으면 등록 시간만 갱신합니다.
        // rejects는 차단될 때 증가시키는 값이므로 여기서는 유지합니다.
        $sql = "UPDATE black_table
                SET time = NOW()
                WHERE ip='$ip'";
        mysqli_query($conn, $sql);

        echo "<script>
                alert('이미 등록된 IP입니다. 등록 시간을 갱신했습니다.');
                location.href='index.php?cmd=board';
              </script>";
        exit;
    } else {
        // 신규 등록
        $sql = "INSERT INTO black_table(ip, time, rejects)
                VALUES('$ip', NOW(), 0)";
        mysqli_query($conn, $sql);

        echo "<script>
                alert('블랙리스트에 등록되었습니다.');
                location.href='index.php?cmd=board';
              </script>";
        exit;
    }
}

// 삭제 처리
if ($mode == "delete") {

    $idx = intval($_GET['idx'] ?? 0);

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

    <style>
        .board-link {
            color: inherit;
            text-decoration: none;
        }
        .board-link:hover {
            color: inherit;
            text-decoration: underline;
        }
    </style>

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
                <?php if ($is_admin) { ?>
                    <th class="d-none d-md-table-cell" style="width:150px;">IP</th>
                <?php } ?>
                <th class="d-none d-md-table-cell" style="width:180px;">작성일</th>
                <?php if ($is_admin) { ?>
                    <th class="d-none d-md-table-cell" style="width:170px;">관리</th>
                <?php } ?>
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
                       class="board-link">
                        <?= $row['title'] ?>
                    </a>
                </td>

                <td class="text-center">
                    <?= $row['name'] ?>
                </td>

                <?php if ($is_admin) { ?>
                    <td class="d-none d-md-table-cell text-center">
                        <?= $row['ip'] ?>
                    </td>
                <?php } ?>

                <td class="d-none d-md-table-cell text-center">
                    <?= $row['time'] ?>
                </td>

                <?php if ($is_admin) { ?>
                    <td class="d-none d-md-table-cell text-center">
                        <a href="index.php?cmd=board&mode=black&idx=<?= $row['idx'] ?>"
                           class="btn btn-sm btn-dark"
                           onclick="return confirm('블랙리스트로 등록하시겠습니까?');">
                            블랙리스트 등록
                        </a>
                    </td>
                <?php } ?>
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

    $idx = intval($_GET['idx'] ?? 0);

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
                IP : <?= $row['ip'] ?> |
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

            <div>
                <?php if ($is_admin) { ?>
                    <a href="index.php?cmd=board&mode=black&idx=<?= $row['idx'] ?>"
                       class="btn btn-dark"
                       onclick="return confirm('블랙리스트로 등록하시겠습니까?');">
                        블랙리스트 등록
                    </a>
                <?php } ?>

                <?php if ($is_admin || $row['id'] == $login_id) { ?>
                    <a href="index.php?cmd=board&mode=delete&idx=<?= $row['idx'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('정말 삭제하시겠습니까?');">
                        삭제
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>

<?php
    }
}
?>

</div>
