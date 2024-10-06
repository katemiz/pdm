window.addEventListener('ConfirmModal',function(e) {

    let sa_title, sa_text, confirmText, cancelText
    let dispatchRoute, dispatchData

    switch (e.detail.type) {



        case 'assy_release':

            sa_title = 'Assembly Release ?'
            sa_text = 'This assembly and its children shall be released and PDM users shall be informed by email. Do you want to continue?'
            confirmText = 'Release'
            cancelText ='Cancel'

            dispatchRoute = 'onReleaseConfirmed'
            dispatchData = {type:e.detail.type}
            break;






        case 'doc_release':

            sa_title = 'Document Release ?'
            sa_text = 'This document shall be released and PDM users shall be informed by email. Do you want to continue?'
            confirmText = 'Release'
            cancelText ='Cancel'

            dispatchRoute = 'onReleaseConfirmed'
            dispatchData = {type:e.detail.type}
            break;




        case 'delete':

            sa_title = 'Do you really want to delete this item?'
            sa_text = 'Once deleted, there is no reverting back!'
            confirmText = 'Delete'
            cancelText ='Oops ...'

            dispatchRoute = 'onDeleteConfirmed'
            dispatchData = {type:e.detail.type}
            break;



        case 'mirror':

            sa_title = 'Add Mirror Part?'
            sa_text = 'Mirror part of this product shall be added.'
            confirmText = 'Add'
            cancelText ='Oops ...'

            dispatchRoute = 'onMirrorConfirmed'
            dispatchData = {type:e.detail.type}
            break;



        case 'replicate':

            sa_title = 'Add Replicate Part?'
            sa_text = 'A new part replicating this part shall be added.'
            confirmText = 'Add'
            cancelText ='Oops ...'

            dispatchRoute = 'onReplicateConfirmed'
            dispatchData = {type:e.detail.type}
            break;




        case 'freeze':

            sa_title = 'Document will be frozen!'
            sa_text = 'Once frozen, no editing is possible.'
            confirmText = 'Freeze'
            cancelText ='Cancel'

            dispatchRoute = 'onFreezeConfirmed'
            dispatchData = {}

            break;

        case 'revise':

            sa_title = 'Do you want revise this document?'
            sa_text = 'New revision will be editable.'
            confirmText = 'Revise'
            cancelText ='Cancel'

            dispatchRoute = 'onReviseConfirmed'
            dispatchData = {}
            break;

        case 'attach':

            sa_title = 'Delete attached file?'
            sa_text = 'Once deleted, there is no reverting back!'
            confirmText = 'Delete File'
            cancelText ='Cancel'

            dispatchRoute = 'deleteAttach'
            dispatchData = {}
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

    }).then((result) => {
        if (result.isConfirmed) {
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
