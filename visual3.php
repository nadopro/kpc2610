<?php
// visual_tree.php
// visual2.php를 Collapsible Tree 형태로 변경한 버전입니다.
// 네트워크 대역별로 1개의 컴퓨터(IP)만 있는 경우는 data.json 생성 단계에서 제외합니다.

date_default_timezone_set('Asia/Seoul');

include "db.php";
$conn = connectDB();

$jsonFile = "data.json";

if (file_exists($jsonFile)) {
    unlink($jsonFile);
}

$todayStart = date("Y-m-d 00:00:00");
$now = date("Y-m-d H:i:s");

$sql = "SELECT ip, time
        FROM log
        WHERE time >= '$todayStart'
        AND time <= '$now'
        ORDER BY time ASC";

$result = mysqli_query($conn, $sql);

$allEvents = [];
$groupIpMap = [];

while ($row = mysqli_fetch_array($result)) {

    $ip = $row["ip"];
    $time = $row["time"];

    $parts = explode(".", $ip);

    // IPv4 형태만 네트워크 대역으로 처리
    if (count($parts) < 4) {
        continue;
    }

    $group = $parts[0] . "." . $parts[1] . "." . $parts[2];

    $allEvents[] = [
        "ip" => $ip,
        "group" => $group,
        "time" => $time
    ];

    if (!isset($groupIpMap[$group])) {
        $groupIpMap[$group] = [];
    }

    $groupIpMap[$group][$ip] = true;
}

// 하나의 대역 안에 서로 다른 컴퓨터(IP)가 2개 이상 있는 대역만 유지
$validGroups = [];

foreach ($groupIpMap as $group => $ipSet) {
    if (count($ipSet) >= 2) {
        $validGroups[$group] = true;
    }
}

$events = [];

foreach ($allEvents as $event) {
    if (isset($validGroups[$event["group"]])) {
        $events[] = [
            "ip" => $event["ip"],
            "time" => $event["time"]
        ];
    }
}

$data = [
    "startTime" => $todayStart,
    "endTime" => $now,
    "events" => $events
];

file_put_contents(
    $jsonFile,
    json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

closeDB($conn);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>Log Collapsible Tree Visualization</title>

<script src="https://d3js.org/d3.v7.min.js"></script>

<style>
html, body {
    margin: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

#chart {
    width: 100vw;
    height: calc(100vh - 110px);
    background: #f8f9fa;
}

#brushArea {
    width: 100vw;
    height: 110px;
    background: #ffffff;
    border-top: 1px solid #ccc;
}

.node circle {
    cursor: pointer;
    stroke: #333;
    stroke-width: 2px;
}

.node text {
    font-size: 12px;
    dominant-baseline: middle;
    pointer-events: none;
}

.link {
    fill: none;
    stroke: #999;
    stroke-width: 2px;
}

.info {
    position: absolute;
    left: 15px;
    top: 15px;
    background: rgba(255,255,255,0.92);
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 13px;
    line-height: 1.5;
    z-index: 10;
}

.tooltip {
    position: absolute;
    display: none;
    background: rgba(0,0,0,0.82);
    color: #fff;
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 12px;
    pointer-events: none;
    z-index: 20;
    white-space: pre-line;
}
</style>
</head>

<body>

<div class="info" id="info"></div>
<div class="tooltip" id="tooltip"></div>

<svg id="chart"></svg>
<svg id="brushArea"></svg>

<script>
const width = window.innerWidth;
const height = window.innerHeight - 110;
const brushHeight = 110;

const svg = d3.select("#chart")
    .attr("width", width)
    .attr("height", height);

const brushSvg = d3.select("#brushArea")
    .attr("width", width)
    .attr("height", brushHeight);

const container = svg.append("g");
const tooltip = d3.select("#tooltip");

svg.call(
    d3.zoom()
        .scaleExtent([0.2, 5])
        .on("zoom", event => {
            container.attr("transform", event.transform);
        })
);

const colorScale = d3.scaleLinear()
    .domain([1, 30])
    .range(["white", "red"])
    .clamp(true);

let rawEvents = [];
let allStart, allEnd;
let nodeId = 0;
let root;

d3.json("data.json?t=" + Date.now()).then(data => {

    rawEvents = data.events.map(d => ({
        ip: d.ip,
        time: new Date(d.time)
    }));

    allStart = new Date(data.startTime);
    allEnd = new Date(data.endTime);

    drawBrush();
    updateTree(allStart, allEnd);
});

function buildTreeData(startTime, endTime) {

    const filtered = rawEvents.filter(d =>
        d.time >= startTime && d.time <= endTime
    );

    const ipMap = {};
    const groupMap = {};

    filtered.forEach(d => {
        const ip = d.ip;
        const parts = ip.split(".");
        const group = parts.slice(0, 3).join(".");

        if (!ipMap[ip]) {
            ipMap[ip] = {
                name: ip,
                type: "ip",
                count: 0,
                firstTime: d.time,
                lastTime: d.time,
                group: group
            };
        }

        ipMap[ip].count++;

        if (d.time < ipMap[ip].firstTime) ipMap[ip].firstTime = d.time;
        if (d.time > ipMap[ip].lastTime) ipMap[ip].lastTime = d.time;

        if (!groupMap[group]) {
            groupMap[group] = {
                name: group,
                type: "group",
                count: 0,
                firstTime: d.time,
                lastTime: d.time,
                children: []
            };
        }

        groupMap[group].count++;

        if (d.time < groupMap[group].firstTime) groupMap[group].firstTime = d.time;
        if (d.time > groupMap[group].lastTime) groupMap[group].lastTime = d.time;
    });

    // 브러시로 선택된 시간 구간에서 다시 계산했을 때,
    // 하나의 대역에 1개의 컴퓨터(IP)만 남으면 시각화에서 제외
    const groupUniqueIpMap = {};

    Object.values(ipMap).forEach(ip => {
        if (!groupUniqueIpMap[ip.group]) {
            groupUniqueIpMap[ip.group] = {};
        }
        groupUniqueIpMap[ip.group][ip.name] = true;
    });

    Object.keys(groupMap).forEach(group => {
        const ipCount = groupUniqueIpMap[group]
            ? Object.keys(groupUniqueIpMap[group]).length
            : 0;

        if (ipCount < 2) {
            delete groupMap[group];
        }
    });

    Object.values(ipMap).forEach(ip => {
        if (groupMap[ip.group]) {
            groupMap[ip.group].children.push(ip);
        }
    });

    const groups = Object.values(groupMap)
        .sort((a, b) => d3.descending(a.count, b.count));

    groups.forEach(group => {
        group.children.sort((a, b) => d3.descending(a.count, b.count));
    });

    const visibleIpCount = groups.reduce((sum, group) => sum + group.children.length, 0);

    return {
        tree: {
            name: "Server",
            type: "server",
            count: filtered.length,
            firstTime: startTime,
            lastTime: endTime,
            children: groups
        },
        total: filtered.length,
        visibleGroupCount: groups.length,
        visibleIpCount: visibleIpCount
    };
}

function updateTree(startTime, endTime) {

    container.selectAll("*").remove();
    nodeId = 0;

    const result = buildTreeData(startTime, endTime);

    document.getElementById("info").innerHTML =
        "선택 구간<br>" +
        formatTime(startTime) + " ~ " + formatTime(endTime) +
        "<br>전체 접속 수 : " + result.total +
        "<br>표시 대역 수 : " + result.visibleGroupCount +
        "<br>표시 IP 수 : " + result.visibleIpCount +
        "<br><br>노드를 클릭하면 접기/펼치기";

    root = d3.hierarchy(result.tree);
    root.x0 = height / 2;
    root.y0 = 80;

    // 처음에는 Server와 대역 노드는 펼치고, IP는 보이도록 유지
    root.descendants().forEach(d => {
        d.id = ++nodeId;
        d._children = d.children;
    });

    render(root);
}

function render(source) {

    const treeLayout = d3.tree()
        .nodeSize([42, 210]);

    treeLayout(root);

    const nodes = root.descendants();
    const links = root.links();

    let left = root;
    let right = root;

    root.eachBefore(node => {
        if (node.x < left.x) left = node;
        if (node.x > right.x) right = node;
    });

    const marginTop = 40;
    const marginLeft = 120;

    root.eachBefore(d => {
        d.drawX = d.y + marginLeft;
        d.drawY = d.x + height / 2;
    });

    const link = container.append("g")
        .attr("fill", "none")
        .attr("stroke", "#999")
        .attr("stroke-width", 2)
        .selectAll("path")
        .data(links)
        .enter()
        .append("path")
        .attr("class", "link")
        .attr("d", d3.linkHorizontal()
            .x(d => d.drawX)
            .y(d => d.drawY)
        );

    const node = container.append("g")
        .selectAll("g")
        .data(nodes)
        .enter()
        .append("g")
        .attr("class", "node")
        .attr("transform", d => `translate(${d.drawX},${d.drawY})`)
        .on("click", function(event, d) {
            if (d.children) {
                d._children = d.children;
                d.children = null;
            } else {
                d.children = d._children;
                d._children = null;
            }
            container.selectAll("*").remove();
            render(d);
        })
        .on("mouseover", function(event, d) {
            tooltip
                .style("display", "block")
                .text(
                    d.data.name +
                    "\n접속 횟수: " + d.data.count +
                    "\n최초 접속: " + formatTime(d.data.firstTime) +
                    "\n마지막 접속: " + formatTime(d.data.lastTime)
                );
        })
        .on("mousemove", function(event) {
            tooltip
                .style("left", (event.pageX + 15) + "px")
                .style("top", (event.pageY + 15) + "px");
        })
        .on("mouseout", function() {
            tooltip.style("display", "none");
        });

    node.append("circle")
        .attr("r", d => {
            if (d.data.type === "server") return 26;
            if (d.data.type === "group") return 20;
            return 10 + Math.min(d.data.count, 30) * 0.5;
        })
        .attr("fill", d => {
            if (d.data.type === "server") return "#222";
            return colorScale(d.data.count);
        });

    node.append("text")
        .attr("x", d => d.children || d._children ? -32 : 20)
        .attr("text-anchor", d => d.children || d._children ? "end" : "start")
        .attr("fill", "#111")
        .text(d => d.data.name);

    node.append("title")
        .text(d =>
            d.data.name +
            "\n접속 횟수: " + d.data.count +
            "\n최초 접속: " + formatTime(d.data.firstTime) +
            "\n마지막 접속: " + formatTime(d.data.lastTime)
        );
}

function drawBrush() {

    const margin = { left: 50, right: 30, top: 20, bottom: 30 };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = brushHeight - margin.top - margin.bottom;

    const x = d3.scaleTime()
        .domain([allStart, allEnd])
        .range([0, innerWidth]);

    const g = brushSvg.append("g")
        .attr("transform", `translate(${margin.left},${margin.top})`);

    g.append("g")
        .attr("transform", `translate(0,${innerHeight})`)
        .call(d3.axisBottom(x));

    g.append("text")
        .attr("x", 0)
        .attr("y", -5)
        .text("시간 선택 브러시");

    const brush = d3.brushX()
        .extent([[0, 0], [innerWidth, innerHeight]])
        .on("end", event => {
            if (!event.selection) return;

            const [x0, x1] = event.selection;
            const start = x.invert(x0);
            const end = x.invert(x1);

            updateTree(start, end);
        });

    g.append("g")
        .call(brush)
        .call(brush.move, [x(allStart), x(allEnd)]);
}

function formatTime(d) {
    const date = new Date(d);

    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const h = String(date.getHours()).padStart(2, "0");
    const min = String(date.getMinutes()).padStart(2, "0");
    const s = String(date.getSeconds()).padStart(2, "0");

    return `${y}-${m}-${day} ${h}:${min}:${s}`;
}
</script>

</body>
</html>
