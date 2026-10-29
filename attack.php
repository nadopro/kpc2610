<?php
// attack.php
?>

<h3>부하 발생 실습</h3>

<div class="card mb-3">
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">공격 PC 개수</label>
            <input type="number" id="pcCount" class="form-control" value="3" min="1" max="20">
        </div>

        <div class="mb-3">
            <label class="form-label">공격 횟수</label>
            <input type="number" id="attackCount" class="form-control" value="10" min="1" max="100">
        </div>

        <button class="btn btn-danger" onclick="startAttack()">
            공격 시작
        </button>

    </div>
</div>

<div class="alert alert-info">
    요청 대상 : <b>index.php?cmd=slow</b>
</div>

<h5>실행 결과</h5>
<pre id="resultBox" class="border bg-light p-3" style="height:400px; overflow:auto;"></pre>

<script>
function log(msg) {
    const box = document.getElementById("resultBox");
    box.textContent += msg + "\n";
    box.scrollTop = box.scrollHeight;
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function runAttack(pcNo, attackCount) {

    for (let i = 1; i <= attackCount; i++) {

        const start = performance.now();

        try {
            const response = await fetch("index.php?cmd=slow&pc=" + pcNo + "&no=" + i + "&t=" + Date.now());
            await response.text();

            const end = performance.now();
            const elapsed = end - start;

            log("PC " + pcNo + " / " + i + "회 요청 완료 / " + elapsed.toFixed(2) + " ms");

        } catch (e) {
            log("PC " + pcNo + " / " + i + "회 요청 실패");
        }

        await sleep(100);
    }

    log("PC " + pcNo + " 작업 종료");
}

function startAttack() {

    const pcCount = parseInt(document.getElementById("pcCount").value);
    const attackCount = parseInt(document.getElementById("attackCount").value);

    document.getElementById("resultBox").textContent = "";

    log("부하 발생 시작");
    log("공격 PC 개수 : " + pcCount);
    log("공격 횟수 : " + attackCount);
    log("--------------------------------");

    for (let pc = 1; pc <= pcCount; pc++) {
        runAttack(pc, attackCount);
    }
}
</script>