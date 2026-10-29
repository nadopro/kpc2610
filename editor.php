<?php
// editor.php
?>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<h3 class="mb-3">WYSIWYG 글쓰기 예제</h3>

<form method="post" action="index.php?cmd=editor">

    <!-- 제목 -->
    <div class="mb-3">
        <label class="form-label">제목</label>
        <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요">
    </div>

    <!-- 버튼 입력부 -->
    <div class="mb-2">
        <button type="button" class="btn btn-outline-dark btn-sm" onclick="execCmd('bold')">
            <span class="material-icons align-middle">format_bold</span>
        </button>

        <button type="button" class="btn btn-outline-dark btn-sm" onclick="execCmd('underline')">
            <span class="material-icons align-middle">format_underlined</span>
        </button>

        <button type="button" class="btn btn-outline-dark btn-sm" onclick="execCmd('italic')">
            <span class="material-icons align-middle">format_italic</span>
        </button>
    </div>

    <!-- 글쓰기부 -->
    <div id="editor"
         contenteditable="true"
         class="form-control"
         style="height:300px; overflow:auto;">
    </div>

    <input type="hidden" name="html" id="html">

    <!-- 글등록 버튼 -->
    <div class="mt-3">
        <button type="submit" class="btn btn-primary" onclick="saveContent()">
            글등록
        </button>
    </div>

</form>

<script>
function execCmd(command) {
    document.execCommand(command, false, null);
}

function saveContent() {
    document.getElementById("html").value =
        document.getElementById("editor").innerHTML;
}
</script>