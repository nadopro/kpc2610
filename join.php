<?php
// join.php
?>

<h3 class="mb-4">회원가입</h3>

<div class="row justify-content-center">

    <div class="col-md-6">

        <form method="post" action="index.php?cmd=join_ok">

            <div class="mb-3">

                <label class="form-label">아이디</label>

                <input
                    type="text"
                    class="form-control"
                    name="id"
                    id="id"
                    autocomplete="off"
                    onkeyup="checkID();">

                <div id="check_result" class="mt-2"></div>

            </div>

            <div class="mb-3">
                <label class="form-label">이름</label>

                <input
                    type="text"
                    class="form-control"
                    name="name">
            </div>

            <div class="mb-3">
                <label class="form-label">비밀번호</label>

                <input
                    type="password"
                    class="form-control"
                    name="pass">
            </div>

            <button class="btn btn-primary">
                회원가입
            </button>

        </form>

    </div>

</div>

<script>

function checkID()
{
    let id = document.getElementById("id").value;
    let div = document.getElementById("check_result");

    if(id.length < 4)
    {
        div.className = "text-danger";
        div.innerHTML = "아이디는 4글자 이상입니다.";
        return;
    }

    fetch("ajax_check_id.php?id=" + encodeURIComponent(id))
    .then(response => response.text())
    .then(data => {

        if(data == "OK")
        {
            div.className = "text-success";
            div.innerHTML = "사용 가능합니다.";
        }
        else
        {
            div.className = "text-danger";
            div.innerHTML = "사용 중인 아이디입니다.";
        }

    });

}

</script>