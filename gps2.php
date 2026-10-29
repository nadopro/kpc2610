<?php
// gps.php
?>

<h3 class="mb-3">IP 위치 조회</h3>

<form onsubmit="searchIP(); return false;" class="row g-2 mb-3">

    <div class="col-md-10">
        <input type="text"
               id="ip"
               class="form-control"
               placeholder="예: 8.8.8.8">
    </div>

    <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">
            실행
        </button>
    </div>

</form>

<div id="msgBox"></div>

<table id="resultTable" class="table table-bordered mt-3" style="display:none;">
    <tr>
        <th style="width:150px;">status</th>
        <td id="status"></td>
    </tr>

    <tr>
        <th>country</th>
        <td id="country"></td>
    </tr>

    <tr>
        <th>위치</th>
        <td>
            <span id="position"></span>

            <button type="button"
                    class="btn btn-sm btn-primary ms-2"
                    onclick="openMap();">
                지도 보기
            </button>
        </td>
    </tr>
</table>

<label class="form-label">JSON 결과</label>

<textarea id="jsonResult"
          class="form-control"
          rows="18"
          readonly></textarea>

<script>
let currentPosition = "";

function searchIP() {
    const ip = document.getElementById("ip").value.trim();
    const msgBox = document.getElementById("msgBox");
    const resultTable = document.getElementById("resultTable");
    const jsonResult = document.getElementById("jsonResult");

    msgBox.innerHTML = "";
    resultTable.style.display = "none";
    jsonResult.value = "";

    if (ip === "") {
        msgBox.innerHTML = `
            <div class="alert alert-warning">
                IP 주소를 입력하세요.
            </div>
        `;
        return;
    }

    const url = "http://ip-api.com/json/" + encodeURIComponent(ip);

    fetch(url)
        .then(response => response.json())
        .then(data => {

            jsonResult.value = JSON.stringify(data, null, 4);

            if (data.status === "success") {

                const status = data.status;
                const country = data.country;
                const lat = data.lat;
                const lon = data.lon;

                currentPosition = lat + "," + lon;

                document.getElementById("status").textContent = status;
                document.getElementById("country").textContent = country;
                document.getElementById("position").textContent = currentPosition;

                resultTable.style.display = "table";

            } else {
                msgBox.innerHTML = `
                    <div class="alert alert-danger">
                        조회 실패
                    </div>
                `;
            }
        })
        .catch(error => {
            msgBox.innerHTML = `
                <div class="alert alert-danger">
                    AJAX 요청 오류 : ${error}
                </div>
            `;
        });
}

function openMap() {
    if (currentPosition !== "") {
        window.open(
            "https://google.com/maps?q=" + encodeURIComponent(currentPosition),
            "mapPopup",
            "width=900,height=700"
        );
    }
}
</script>