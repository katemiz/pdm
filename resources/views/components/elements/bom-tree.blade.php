<div>
    <div id="tree" class="notification mt-4" ></div>
</div>







<script>


    $(document).ready(function () {

        $(function() {
            $('#tree').tree({
                data: @json($treeData),
                selectable:true,

                onCreateLi: function(node, $li) {
                    // Append a link to the jqtree-element div.
                    // The link has an url '#node-[id]' and a data property 'node-id'.
                    $li.find('.jqtree-element').append(
                        '<span class="mx-1" data-node-id="'+ node.qty +'">['+ node.qty +']</span><a href="#node-'+ node.id +'" class="edit mx-1 has-text-danger" data-node-id="'+ node.id +'"> x</a>'
                    );
                }
            });

        });
    });






    // function deleteNode(idNode) {

    //     // Get the node from the tree
    //     var node = $('#tree').tree('getNodeById', idNode);

    //     $('#tree').tree('removeNode', node);
    // }





    // ON NODE SELECT
    $('#tree').on(
        'tree.select',
        function(event) {
            if (event.node) {
                // node was selected
                var node = event.node;
                //alert(node.name);
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

            console.log("selected node",node)

            console.log("selected node qty",node.qty)


            if (node.qty > 1) {

                let newqty = node.qty-1

                console.log("reducing qty",newqty)

                console.log('before update',node)

                let aaa = {
                    name: node.name,
                    id: node.id,
                    qty:newqty
                }

                console.log('aaa',aaa)


                $('#tree').tree('updateNode',node, aaa)



                console.log('after update',node)

            } else {
                $('#tree').tree('removeNode', node);
            }


            Livewire.dispatch('saveTree', {idAssy: "500"})



        }
    })




    $('#tree').on('tree.contextmenu', function(event) {
            // The clicked node is 'event.node'
            var node = event.node;
            alert(node.name);
        }
    );


    window.addEventListener('refreshTree',function(e) {

        data = e.detail.data




    })










</script>

