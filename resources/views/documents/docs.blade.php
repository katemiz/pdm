<section class="section container">

    <script>

        window.addEventListener('ConfirmModal',function(e) {

            let sa_title, sa_text, confirmText, cancelText
            let dispatchRoute, dispatchData

            switch (e.detail.type) {

                case 'document':

                    sa_title = 'Do you really want to delete this document?'
                    sa_text = 'Once deleted, there is no reverting back!'
                    confirmText = 'Delete'
                    cancelText ='Oops ...'

                    dispatchRoute = 'onDeleteConfirmed'
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

                    sa_title = 'Do you want delete attached file?'
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

        // window.addEventListener('done-file-upload',function(e) {

        //     console.log('doneFileUpload')

        //     alert(e.detail)
        // })


        document.addEventListener('livewire:initialized', () => {
            @this.on('done-file-upload', (event) => {
                console.log('doneFileUpload')

                alert(event.detail)
            });
        });












    </script>

    @switch($action)

        @case('FORM')
            @include('documents.docs-form')
            @break

        @case('VIEW')
            @include('documents.docs-view')
            @break

        @case('LIST')
        @default
            @include('documents.docs-list')
            @break

    @endswitch

</section>
