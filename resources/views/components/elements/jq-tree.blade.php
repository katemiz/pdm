<div>
    <div id="tree" class="notification mt-4" ></div>
</div>







<script>


    $(document).ready(function () {


        $(function() {
            $('#tree').tree({
                data: @json($treeData),
                selectable:true,

                icons: {
                    'leaf': {
                        'icon': '<x-carbon-dot-mark />'
                    },
                },

                // render: function(item) {
                //     return `${item.name} <span class="qty">${item.qty}</span>`;
                // },

                onCreateLi: function(node, $li) {
                    // Append a link to the jqtree-element div.
                    // The link has an url '#node-[id]' and a data property 'node-id'.
                    $li.find('.jqtree-element').append(
                        '<a href="#node-'+ node.id +'" class="edit mx-1 has-text-danger" data-node-id="'+ node.id +'"> x</a><a href="javascript:removeNode('+ node.id +')" data-node-id="'+ node.id +'">   -   </a><a href="#node-'+ node.id +'" class="mx-1" data-node-id="'+ node.qty +'">['+ node.qty +']</a>'
                    );
                }
            });

        });
    });






    function removeNode(idNode) {

        console.log(idNode)

        // var node_id = $(e.target).data('node-id');



        // Get the node from the tree
        var node = $('#tree').tree('getNodeById', idNode);

        $('#tree').tree('removeNode', node);
    }





    // ON NODE SELECT
    $('#tree').on(
        'tree.select',
        function(event) {
            if (event.node) {
                // node was selected
                var node = event.node;
                alert(node.name);
            }
            else {
                // event.node is null
                // a node was deselected
                // e.previous_node contains the deselected node
            }
        }
    );

    // Handle a click on the edit link
    $('#tree').on( 'click', '.edit', function(e) {
        // Get the id from the 'node-id' data property
        var node_id = $(e.target).data('node-id');



        // Get the node from the tree
        var node = $('#tree').tree('getNodeById', node_id);

        if (node) {
            // Display the node name
            alert(node.name);
        }
    })




    $('#tree').on(
        'tree.contextmenu',
        function(event) {
            // The clicked node is 'event.node'
            var node = event.node;
            alert(node.name);
        }
    );


    window.addEventListener('refreshTree',function(e) {

        data = e.detail.data


        // var treeData = $('#tree1').tree('getTree');

        // console.log(e.detail)

        // console.log('root node',treeData)


        // console.log($('#tree').tree('toJson'));

        //$('#tree').tree('refresh');




        // $('#tree').tree(
        //     'appendNode',
        //     {
        //         name: 'new_node',
        //         id: 456
        //     }
        // );



        // let new_data = $('#tree').tree('toJson')

        // $('#tree').tree('loadData', new_data);


        // console.log($('#tree').tree('toJson'));


        //tree.tree('refresh')

    })

    function addNodeJS(idPartSelected) {

        // console.log(idPartSelected)

        //         console.log($('#tree').tree('toJson'));

        let qty
        let node = $('#tree').tree('getNodeById',idPartSelected)

        console.log("idPartSelected",idPartSelected)
        console.log("Node check",node)


        if (node === null) {
            qty = 1

            console.log("Node check",node)

            $('#tree').tree(
            'appendNode',
            {
                name: idPartSelected.toString(),
                id: idPartSelected,
                qty:qty
            }
        );


        } else {
            qty = node.qty +1



            $('#tree').tree(
                'updateNode',
                node,
                {
                    name: idPartSelected.toString(),
                    id: idPartSelected,
                    qty:qty
                }
            );






        }







}




</script>

