window.addEventListener('saveTree',function(e) {




    Livewire.dispatch('addTreeToDB', { bomData: $('#tree').tree('toJson')});
})


window.addEventListener('saveResult',function(e) {
    Swal.fire({
        position: 'bottom-left',
        icon: 'success',
        title: 'Product Tree has been saved',
        showConfirmButton: false,
        timer: 1000
    })
})













function addNodeJS(idAssy,idSelected,partNumber,description,version,part_type) {

    let full_part_number
    let node = $('#tree').tree('getNodeById',idSelected)

    if (part_type == 'Standard') {
        full_part_number = partNumber
    } else {
        full_part_number = description
    }

    // console.log("node",node)

    let new_node = {
        name: partNumber.toString(),
        id: idSelected,
        description:full_part_number,
        version:version,
        part_type:part_type,
        qty:1
    }

    if (node === null) {

        // console.log({
        //     "idAssy":idAssy,
        //     "idSelected":idSelected,
        //     "partNumber":partNumber,
        //     "description":description,
        //     "version":version,
        //     "part_type":part_type,
        //     "node":node
        // })

        $('#tree').tree('appendNode', new_node);

        // console.log($('#tree').tree('toJson'))

    } else {

        new_node.qty = node.qty +1
        $('#tree').tree('updateNode',node, new_node);
    }

    Livewire.dispatch('addTreeToDB', { bomData: $('#tree').tree('toJson')});
}
