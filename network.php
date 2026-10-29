<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    svg {
        width: 100vw;
        height: 100vh;
        background: #f8f9fa;
        cursor: default;
    }

    .node circle {
        fill: white;
        stroke: #333;
        stroke-width: 2px;
    }

    .node text {
        font-size: 14px;
        text-anchor: middle;
        dominant-baseline: middle;
        pointer-events: none;
    }

    .tooltip {
        position: absolute;
        padding: 8px 12px;
        background: #333;
        color: white;
        border-radius: 5px;
        font-size: 14px;
        display: none;
        pointer-events: none;
    }
</style>



<div class="tooltip" id="tooltip"></div>
<svg id="network"></svg>

<script>
const graph = {
    nodes: [
        { id: "신사임당" },
        { id: "이율곡" },
        { id: "홍대감" },
        { id: "홍길동" },
        { id: "이순신" },
        { id: "유성룡" },
        { id: "선조" }
    ],
    links: [
        { source: "신사임당", target: "이율곡", relation: "아들" },
        { source: "홍대감", target: "홍길동", relation: "아들" },
        { source: "이율곡", target: "홍길동", relation: "친구" },
        { source: "이순신", target: "유성룡", relation: "친구" },
        { source: "이순신", target: "이율곡", relation: "선생님" },
        { source: "이순신", target: "선조", relation: "선생님" }
    ]
};

const width = window.innerWidth;
const height = window.innerHeight;

const svg = d3.select("#network");

const container = svg.append("g");

const tooltip = d3.select("#tooltip");

const zoom = d3.zoom()
    .filter(function(event) {
        return event.type === "wheel" || event.button === 2;
    })
    .scaleExtent([0.3, 5])
    .on("zoom", function(event) {
        container.attr("transform", event.transform);
    });

svg.call(zoom);

function linkColor(d) {
    if (d.relation === "아들") return "red";
    if (d.relation === "친구") return "blue";
    if (d.relation === "선생님") return "black";
    return "#999";
}

function linkDash(d) {
    if (d.relation === "선생님") return "8,6";
    return "none";
}

const simulation = d3.forceSimulation(graph.nodes)
    .force("link", d3.forceLink(graph.links)
        .id(d => d.id)
        .distance(180)
    )
    .force("charge", d3.forceManyBody().strength(-600))
    .force("center", d3.forceCenter(width / 2, height / 2));

const link = container.append("g")
    .selectAll("line")
    .data(graph.links)
    .enter()
    .append("line")
    .attr("stroke", d => linkColor(d))
    .attr("stroke-width", 4)
    .attr("stroke-dasharray", d => linkDash(d))
    .on("mouseover", function(event, d) {
        tooltip
            .style("display", "block")
            .html(`${d.source.id} - ${d.relation} - ${d.target.id}`);
    })
    .on("mousemove", function(event) {
        tooltip
            .style("left", (event.pageX + 15) + "px")
            .style("top", (event.pageY + 15) + "px");
    })
    .on("mouseout", function() {
        tooltip.style("display", "none");
    });

const node = container.append("g")
    .selectAll("g")
    .data(graph.nodes)
    .enter()
    .append("g")
    .attr("class", "node");

node.append("circle")
    .attr("r", 40);

node.append("text")
    .text(d => d.id);

simulation.on("tick", function() {
    link
        .attr("x1", d => d.source.x)
        .attr("y1", d => d.source.y)
        .attr("x2", d => d.target.x)
        .attr("y2", d => d.target.y);

    node
        .attr("transform", d => `translate(${d.x}, ${d.y})`);
});
</script>
