<div>
    <div id="tree" class="notification mt-4" ></div>

    {{ $doctree }}
</div>







<script>

    let doctree


    function initializeTree(doctree) {

        $('#toc').tree({
            data: doctree,
            selectable:true,
            onCreateLi: function(node, $li) {
                // Append a link to the jqtree-element div.
                // The link has an url '#node-[id]' and a data property 'node-id'.
                $li.find('.jqtree-element').append(
                    '<span class="mx-1" data-node-id="'+ node.qty +'">['+ node.qty +']</span><a href="#node-'+ node.id +'" class="edit mx-1 has-text-danger" data-node-id="'+ node.id +'"> x</a>'
                );
            }
        });

        console.log('Jqtree Initialized',$('#toc').tree('toJson'))
    }










    $(document).ready(function () {

        doctree = @json($doctree)

        console.log('AAAAAAAAAA',doctree)

        if (doctree) {
            initializeTree(doctree)
            console.log('BBBBB',doctree)

        }
        

    });












    // ON NODE SELECT
    $('#toc').on(
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
    $('#toc').on( 'click', '.edit', function(e) {
        // Get the id from the 'node-id' data property
        var node_id = $(e.target).data('node-id');

        // Get the node from the tree
        var node = $('#toc').tree('getNodeById', node_id);

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


                $('#toc').tree('updateNode',node, aaa)



                console.log('after update',node)

            } else {
                $('#toc').tree('removeNode', node);
            }

        }
    })




    $('#toc').on('tree.contextmenu', function(event) {
            // The clicked node is 'event.node'
            var node = event.node;
            alert(node.name);
        }
    );


    window.addEventListener('refreshTree',function(e) {

        data = e.detail.data




        
    })







    window.addEventListener('nodeAddedUpdateTree',function(e) {

        console.log('javascripte ulaştık',e.detail)

        let node = {
            id: e.detail.id,
            name: e.detail.name
        }



        if ( $('#toc').tree('getTree') ) {

            alert('VAR')

        } else {

            doctree = [ node ]

            initializeTree(doctree)


            alert('YOK')
        }

        if (e.detail.parentId) {

            console.log('yes parent')


            let parentNode = $('#toc').tree('getNodeById',e.detail.parentId)

            $('#toc').tree('appendNode', {
                    name: e.detail.name,
                    id: e.detail.id,
                },
                parentNode
            )
        } else {

            console.log('no parent')

            $('#toc').tree('appendNode', {
                name: e.detail.name,
                id: e.detail.id,
            })
        }

    })






    
    function addNodeJS(idPartSelected) {

        // console.log(idPartSelected)

        //         console.log($('#tree').tree('toJson'));

        let qty
        let node = $('#toc').tree('getNodeById',idPartSelected)

        // console.log("idPartSelected",idPartSelected)
        // console.log("Node check",node)


        if (node === null) {
            qty = 1

            // console.log("Node check",node)

            $('#toc').tree('appendNode', {
                name: idPartSelected.toString(),
                id: idPartSelected,
                qty:qty
            }
        );


        } else {
            qty = node.qty +1



            $('#toc').tree('updateNode',node, {
                    name: idPartSelected.toString(),
                    id: idPartSelected,
                    qty:qty
                }
            );






        }








}




</script>

