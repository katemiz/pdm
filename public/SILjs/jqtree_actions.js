
$(document).ready(function () {


    //console.log(typeof doctree)

    $('#toc').tree({
        data: doctree,
        selectable:true,
        dragAndDrop: true,
        onCreateLi: function(node, $li) {
            // Append a link to the jqtree-element div.
            // The link has an url '#node-[id]' and a data property 'node-id'.
            $li.find('.jqtree-element').append(
                '<a href="#node-'+ node.id +'" class="edit mx-1 has-text-danger" data-node-id="'+ node.id +'"> +</a>'
            );
        }
    });



    // ON NODE SELECT
    $('#toc').on(
        'tree.select',
        function(event) {

            if (event.node) {
                // node was selected
                let node = event.node;

                let pnode_id = 0;
                let nnode_id = 0;

                if (node.getPreviousNode()) {
                    pnode_id = node.getPreviousNode().id
                }

                if (node.getNextNode()) {
                    nnode_id = node.getNextNode().id
                }

                Livewire.dispatch('viewPage', { pid: node.id,pnode_id:pnode_id,nnode_id:nnode_id });

            } else {
                // event.node is null
                // a node was deselected
                // e.previous_node contains the deselected node
            }
        }
    );

    // On click of MB3
    $('#toc').on('tree.contextmenu', function(event) {
        // The clicked node is 'event.node'
        var node = event.node;
        alert(node.id);
    });


    // Handle a click on the ADDITIONAL link (based on class name)
    $('#toc').on( 'click', '.edit', function(e) {
        // Get the id from the 'node-id' data property
        var node_id = $(e.target).data('node-id');

        // Get the node from the tree
        var node = $('#toc').tree('getNodeById', node_id);

        console.log("+ tıklandı",node)
    })



    $('#toc').on(
        'tree.move',
        function(event) {
            console.log('moved_node', event.move_info.moved_node);
            console.log('target_node', event.move_info.target_node);
            console.log('position', event.move_info.position);
            console.log('previous_parent', event.move_info.previous_parent);

            $('#toc').tree('refresh');

            event.move_info.do_move();

            Livewire.dispatch('updateTocInDB', { toc: $('#toc').tree('toJson')});

            console.log($('#toc').tree('toJson'))

        }
    );


});


// window.addEventListener('addNode',function(e) {


//     let node = e.detail.node
//     let parent_id = e.detail.parent_id

//     if (parent_id) {

//         console.log('yes parent')
//         let parentNode = $('#toc').tree('getNodeById',parent_id)

//         $('#toc').tree('appendNode', node, parentNode)
//     } else {

//         console.log('no parent',$('#toc').tree())

//         $('#toc').tree('appendNode', node)

//         $('#toc').tree('refresh');

//         console.log($('#toc').tree('toJson'))


//         Livewire.dispatch('updateTocInDB', { toc: $('#toc').tree('toJson')});


//     }

// })


window.addEventListener('updateTreeOnBrowser',function(e) {

    let node = e.detail.node
    let parent_node_id = e.detail.parent_node_id
    let is_update = e.detail.is_update

    if (is_update) {

        // UPDATE EXISTING NODE
        let toBeUpdatedNode = $('#toc').tree('getNodeById',node.id)
        $('#toc').tree('updateNode',toBeUpdatedNode,node);

    } else {

        // ADD NEW NODE
        if (parent_node_id > 0) {

            let parentNode = $('#toc').tree('getNodeById',parent_node_id)
            $('#toc').tree('appendNode', node, parentNode)

        } else {

            $('#toc').tree('appendNode', node)
            $('#toc').tree('refresh');
        }
    }

    Livewire.dispatch('updateTocInDB', { toc: $('#toc').tree('toJson')});
})




function viewPreviuosNext(current_page_id) {

    let node = $('#toc').tree('getNodeById',current_page_id)

    let pnode_id = 0;
    let nnode_id = 0;

    if (node.getPreviousNode()) {
        pnode_id = node.getPreviousNode().id
    }

    if (node.getNextNode()) {
        nnode_id = node.getNextNode().id
    }

    Livewire.dispatch('viewPage', { pid: node.id,pnode_id:pnode_id,nnode_id:nnode_id });




}



