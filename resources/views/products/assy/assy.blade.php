<section class="section container">

    <script>

        window.addEventListener('ConfirmModal',function(e) {

            let sa_title, sa_text, confirmText, cancelText
            let dispatchRoute, dispatchData

            switch (e.detail.type) {

                case 'delete':

                    sa_title = 'Do you really want to delete this Sellable Product?'
                    sa_text = 'Once deleted, there is no reverting back!'
                    confirmText = 'Delete'
                    cancelText ='Oops ...'

                    dispatchRoute = 'onDeleteConfirmed'
                    dispatchData = {type:e.detail.type}
                    break;

                case 'freeze':

                    sa_title = 'Sellable Product will be frozen!'
                    sa_text = 'Once frozen, no editing is possible.'
                    confirmText = 'Freeze'
                    cancelText ='Cancel'

                    dispatchRoute = 'onFreezeConfirmed'
                    dispatchData = {}

                    break;

                case 'revise':

                    sa_title = 'Do you want revise this requirement?'
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


        window.addEventListener('saveTree',function(e) {

            console.log('saveTree is running')
            console.log($('#tree').tree('toJson'))

            alert(e.detail.idAssy)

            Livewire.dispatch('addTreeToDB', { idAssy:e.detail.idAssy, bomData: $('#tree').tree('toJson')});

        })


        function addNodeJS(idAssy,idPartSelected,partNumber) {

            let qty
            let node = $('#tree').tree('getNodeById',idPartSelected)

            if (node === null) {
                qty = 1

                $('#tree').tree('appendNode', {
                    name: partNumber.toString(),
                    id: idPartSelected,
                    qty:qty
                });

            } else {

                qty = node.qty +1

                $('#tree').tree('updateNode',node, {
                        name: partNumber.toString(),
                        id: idPartSelected,
                        qty:qty
                    }
                );
            }

            console.log('addNodeJS function',$('#tree').tree('toJson'))
            //Livewire.dispatch('addTreeToDB', $('#tree').tree('toJson'))

            Livewire.dispatch('addTreeToDB', { idAssy:idAssy, bomData: $('#tree').tree('toJson')});

        }


    </script>

    @switch($action)

        @case('FORM')
            @include('products.assy.assy-form')
            @break

        @case('VIEW')
            @include('products.assy.assy-view')
            @break

        {{-- @case('LIST')
        @default
            @include('products.assy.assy-list')
            @break --}}

    @endswitch

</section>
