<?php
// log2.php
?>

<div class="text-center my-5">

    <button type="button"
            class="btn btn-primary btn-lg"
            onclick="openVisualFullScreen();">
        시각화
    </button> 
    <button type="button"
            class="btn btn-primary btn-lg"
            onclick="openVisualFullScreen2();">
        시각화(2회 이상)
    </button>

    <button type="button"
            class="btn btn-primary btn-lg"
            onclick="openVisualFullScreen3();">
        시각화(Collapsible Tree)
    </button>

</div>

<script>
function openVisualFullScreen() {
    const win = window.open(
        "visual.php",
        "visualWindow",
        "width=" + screen.width + ",height=" + screen.height + ",left=0,top=0,fullscreen=yes"
    );

    if (win) {
        win.focus();
    }
}

function openVisualFullScreen2() {
    const win = window.open(
        "visual2.php",
        "visualWindow",
        "width=" + screen.width + ",height=" + screen.height + ",left=0,top=0,fullscreen=yes"
    );

    if (win) {
        win.focus();
    }
}

function openVisualFullScreen3() {
    const win = window.open(
        "visual3.php",
        "visualWindow",
        "width=" + screen.width + ",height=" + screen.height + ",left=0,top=0,fullscreen=yes"
    );

    if (win) {
        win.focus();
    }
}
</script>