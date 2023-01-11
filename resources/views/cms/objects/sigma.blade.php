
<style type="text/css">
    #graph-container {
        max-width: 100%;
        height: 500px;
        margin: auto;
    }
</style>
<script src="/js/jquery.min.js"></script>

<script src="/js/sigma/build/sigma.min.js"></script>
<script src="/js/sigma/build/plugins/sigma.layout.forceAtlas2.min.js"></script>
<script src="/js/sigma/build/plugins/sigma.renderers.edgeLabels.min.js"></script>
<script src="/js/sigma/build/plugins/sigma.renderers.edgeDots.min.js"></script>
<script>
    var g = {
        nodes: [],
        edges: []
    };

    sigma.canvas.nodes.border = function (node, context, settings) {
        var prefix = settings('prefix') || '';
        context.fillStyle = node.color || settings('defaultNodeColor');
        context.beginPath();
        context.arc(
            node[prefix + 'x'],
            node[prefix + 'y'],
            node[prefix + 'size'],
            0,
            Math.PI * 2,
            true
        );
        context.closePath();
        context.fill();

        context.lineWidth = node.borderWidth || 1;
        context.strokeStyle = node.color || '#ec5148'; //'#fff';
        context.stroke();
    };

    s = new sigma({
        graph: g,
        container: 'graph-container',
        renderer: {
            type: 'canvas',
            container: document.getElementById('graph-container')
        },
        settings: {
            minNodeSize: 8,
            maxNodeSize: 40,
            defaultNodeColor: '#ec5148',
            doubleClickEnabled: false,
            defaultNodeType: 'border',
            autoRescale: true,
            maxEdgeSize: 2,
            enableEdgeHovering: true,
            edgeHoverColor: 'edge',
            defaultEdgeHoverColor: '#000',
            edgeHoverSizeRatio: 1,
            edgeHoverExtremities: true
        }
    });

    function refreshGraph() {
        var i = 0;
        s.graph.nodes().forEach(function (node) {
            node.x = Math.cos(i); //Math.random();
            node.y = Math.sin(i); //Math.random();
            node.size = s.graph.degree(node.id);
            node.color = '#ec5148';
            node.type = 'border';
            i += 0.1;

        });

        s.graph.edges().forEach(function (edge) {
            edge.type = 'arrow';
            edge.size = 10;
            edge.dotOffset = 4;
            edge.dotSize = 2;
            edge.sourceDotColor = '#F0F0F0';
            edge.targetDotColor = '#F0F0F0';

        });

        s.refresh();
        s.startForceAtlas2();
    }

    $(document).ready(function () {
        $.ajax({
            url: "/cms/objects/relations", dataType: "json", success: function (result) {

                var g = s.graph;
                g.clear();
                g.read(result);
                refreshGraph();
                console.log('Nodes: ', g.nodes().length, 'Edges: ', g.edges().length);
            }
        });
    });

</script>