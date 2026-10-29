<?php
// visual.php

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

$events = [];

while ($row = mysqli_fetch_array($result)) {
    $events[] = [
        "ip" => $row["ip"],
        "time" => $row["time"]
    ];
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
<title>Log Network Visualization</title>

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

.node text {
    font-size: 12px;
    text-anchor: middle;
    dominant-baseline: middle;
    pointer-events: none;
}

.link {
    stroke: #999;
    stroke-width: 2px;
}

.info {
    position: absolute;
    left: 15px;
    top: 15px;
    background: rgba(255,255,255,0.9);
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 13px;
}
</style>
</head>

<body>

<div class="info" id="info"></div>

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

d3.json("data.json?t=" + Date.now()).then(data => {

    rawEvents = data.events.map(d => ({
        ip: d.ip,
        time: new Date(d.time)
    }));

    allStart = new Date(data.startTime);
    allEnd = new Date(data.endTime);

    drawBrush();
    updateNetwork(allStart, allEnd);
});

function buildGraph(startTime, endTime) {

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
                id: ip,
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
                id: group,
                type: "group",
                count: 0,
                firstTime: d.time,
                lastTime: d.time
            };
        }

        groupMap[group].count++;

        if (d.time < groupMap[group].firstTime) groupMap[group].firstTime = d.time;
        if (d.time > groupMap[group].lastTime) groupMap[group].lastTime = d.time;
    });

    const nodes = [
        {
            id: "Server",
            type: "server",
            count: filtered.length,
            firstTime: startTime,
            lastTime: endTime
        }
    ];

    Object.values(groupMap).forEach(g => nodes.push(g));
    Object.values(ipMap).forEach(ip => nodes.push(ip));

    const links = [];

    Object.values(groupMap).forEach(g => {
        links.push({
            source: "Server",
            target: g.id
        });
    });

    Object.values(ipMap).forEach(ip => {
        links.push({
            source: ip.group,
            target: ip.id
        });
    });

    return { nodes, links, total: filtered.length };
}

function updateNetwork(startTime, endTime) {

    container.selectAll("*").remove();

    const graph = buildGraph(startTime, endTime);

    document.getElementById("info").innerHTML =
        "선택 구간<br>" +
        formatTime(startTime) + " ~ " + formatTime(endTime) +
        "<br>접속 수 : " + graph.total;

    const simulation = d3.forceSimulation(graph.nodes)
        .force("link", d3.forceLink(graph.links).id(d => d.id).distance(120))
        .force("charge", d3.forceManyBody().strength(-450))
        .force("center", d3.forceCenter(width / 2, height / 2));

    const link = container.append("g")
        .selectAll("line")
        .data(graph.links)
        .enter()
        .append("line")
        .attr("class", "link");

    const node = container.append("g")
        .selectAll("g")
        .data(graph.nodes)
        .enter()
        .append("g")
        .attr("class", "node");

    node.append("circle")
        .attr("r", d => {
            if (d.type === "server") return 45;
            if (d.type === "group") return 35;
            return 20 + Math.min(d.count, 30);
        })
        .attr("fill", d => {
            if (d.type === "server") return "#222";
            return colorScale(d.count);
        })
        .attr("stroke", "#333")
        .attr("stroke-width", 2);

    node.append("text")
        .attr("fill", d => d.type === "server" ? "white" : "black")
        .text(d => d.id);

    node.append("title")
        .text(d =>
            d.id +
            "\n접속 횟수: " + d.count +
            "\n최초 접속: " + formatTime(d.firstTime) +
            "\n마지막 접속: " + formatTime(d.lastTime)
        );

    simulation.on("tick", () => {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("transform", d => `translate(${d.x},${d.y})`);
    });
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

            updateNetwork(start, end);
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