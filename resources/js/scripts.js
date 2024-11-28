window.addEventListener('ConfirmModal',function(e) {

    let sa_title, sa_text, confirmText, cancelText
    let dispatchRoute, dispatchData

    // e.detail.type [Action Type]
    // e.detail.name [Data Name]

    let thirdButton = false;
    let thirdButtonText = false;

    // Colors
    let confirmButtonColor = "#3085d6";
    let denyButtonColor ="#3085d6";

    let cancelButtonColor ="#d33";


    switch (e.detail.type) {


        case 'freeze':

            sa_title = e.detail.name + ' will be frozen!'
            sa_text = 'Once frozen, no editing is possible.'
            confirmText = 'Freeze'
            cancelText ='Cancel'

            dispatchRoute = 'onFreezeConfirmed'

            break;

        case 'assy_release':

            sa_title = 'Assembly Release ?'
            sa_text = 'This assembly and its children shall be released and PDM users shall be informed by email. Do you want to continue?'
            confirmText = 'Release'
            cancelText ='Cancel'

            dispatchRoute = 'onReleaseConfirmed'
            break;

        case 'release':

            sa_title = e.detail.name +' Release ?'
            sa_text = 'This '+e.detail.name +' shall be released and PDM users shall be informed by email. Do you want to continue?'
            confirmText = 'Release'
            cancelText ='Cancel'

            dispatchRoute = 'onReleaseConfirmed'
            break;


        case 'delete':

            sa_title = 'Delete '+e.detail.name+' ? Really ?'
            sa_text = 'Once deleted, there is no reverting back!'
            confirmText = 'Delete'
            cancelText ='Oops ...'

            dispatchRoute = 'onDeleteConfirmed'
            break;

        case 'mirror':

            sa_title = 'Add Mirror Part?'
            sa_text = 'Mirror part of this product shall be added.'
            confirmText = 'Add'
            cancelText ='Oops ...'

            dispatchRoute = 'onMirrorConfirmed'
            break;



        case 'replicate':

            sa_title = 'Add Replicate Part?'
            sa_text = 'A new part replicating this part shall be added.'
            confirmText = 'Add'
            cancelText ='Oops ...'

            dispatchRoute = 'onReplicateConfirmed'
            break;






        case 'revise':

            thirdButton = true
            thirdButtonText = 'Revise without files'

            sa_title = 'Revise '+e.detail.name+'?'
            sa_text = 'New revision will be editable.'
            confirmText = 'Revise with files'
            cancelText ='Cancel'

            dispatchRoute = 'onReviseConfirmed'
            break;

        case 'attach':

            sa_title = 'Delete attached file?'
            sa_text = 'Once deleted, there is no reverting back!'
            confirmText = 'Delete File'
            cancelText ='Cancel'

            dispatchRoute = 'deleteAttach'
            break;
    }

    Swal.fire({
        title: sa_title,
        text: sa_text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,

        confirmButtonColor:confirmButtonColor,
        cancelButtonColor:cancelButtonColor,
        denyButtonColor:denyButtonColor,

        showDenyButton: thirdButton,
        denyButtonText: thirdButtonText

    }).then((result) => {

        if (result.isConfirmed) {

            // Revise with files

            dispatchData = {type:e.detail.type,withFiles:true}
            Livewire.dispatch(dispatchRoute, dispatchData)
        }

        if (result.isDenied) {

            // Revise without files

            dispatchData = {type:e.detail.type,withFiles:false}
            Livewire.dispatch(dispatchRoute, dispatchData)

        } else {
            return false
        }
    })











});





window.addEventListener('attachDeleted',function(e) {

    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'File/Attachment has been deleted',
        showConfirmButton: false,
        timer: 1500
    })
})



/*
This function is triggered when "+" Add Button in index (listing of items) is clicked [All index files]
*/

window.addEventListener('addTriggered', e => {
    window.location.href = e.detail.redirect
})


/*
This function is triggered when searching in tables (listing of items) [All index files]
*/

window.addEventListener('queryChanged', e => {
    Livewire.dispatch('startQuerySearch', {query:e.detail.query});
});







