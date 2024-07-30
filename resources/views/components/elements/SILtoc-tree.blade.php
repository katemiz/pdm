<div>
    <div id="toc" class="notification mt-4" ></div>
{{--
    {{ $doctree }} --}}
</div>












@script

<script>


let doctree = '{{$doctree}}'


let doctree = JSON.parse("{{$doctree}}")
console.log('KKKKKKKKKKKK')


initializeTree('doctree =', doctree)

</script>

@endscript





<script>

    // let doctree




    function initializeTree(doctree) {

        console.log("initilizing", JSON.parse(doctree))

        console.log("initilizing", typeof doctree)

        // doctree = [
        //     {id:44,name:"jhfjfr"},
        //     {id:56,name:"yyy"}
        // ]


        $('#toc').tree({
            data: doctree,
            selectable:true,
            onCreateLi: function(node, $li) {
                // Append a link to the jqtree-element div.
                // The link has an url '#node-[id]' and a data property 'node-id'.
                $li.find('.jqtree-element').append(
                    '<a href="#node-'+ node.id +'" class="edit mx-1 has-text-danger" data-node-id="'+ node.id +'"> +</a>'
                );
            }
        });

        console.log('Jqtree Initialized',$('#toc').tree())
    }



    window.addEventListener('childTriggered',function(e) {

        console.log("childTriggered")

        doctree = [
            {id:44,name:"jhfjfr"},
            {id:56,name:"yyy"}
        ]

        $('#toc').tree('refresh');


        //initializeTree(doctree)
    })






    // $(document).ready(function () {


    //     console.log(typeof doctree)

    //     $('#toc').tree({
    //         data: doctree,
    //         selectable:true,
    //         onCreateLi: function(node, $li) {
    //             // Append a link to the jqtree-element div.
    //             // The link has an url '#node-[id]' and a data property 'node-id'.
    //             $li.find('.jqtree-element').append(
    //                 '<a href="#node-'+ node.id +'" class="edit mx-1 has-text-danger" data-node-id="'+ node.id +'"> +</a>'
    //             );
    //         }
    //     });



    //     // if (doctree.length > 0) {
    //     //     initializeTree(doctree)
    //     //     console.log('BBBBB',doctree.length)

    //     // } else {

    //     //     console.log('document ready doctree boş. jqtree not initialized')
    //     // }


    // });












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

        console.log('Eklenecek node',node)

        // if ( $('#toc').tree('getTree') ) {

        //     alert('VAR')

        // } else {

        //     doctree = [ node ]

        //     console.log('RRRRRRRRRRR', doctree)


        //     initializeTree(doctree)


        //     console.log('YOK idi eklenmiş olmalı')
        // }

        if (e.detail.parentId) {

            console.log('yes parent')
            let parentNode = $('#toc').tree('getNodeById',e.detail.parentId)

            $('#toc').tree('appendNode', node, parentNode)
        } else {

            console.log('no parent',$('#toc').tree())

            $('#toc').tree('appendNode', node)
            $('#toc').tree('refresh');
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

