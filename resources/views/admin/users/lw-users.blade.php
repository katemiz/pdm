<section class="section container">

    <script>

        window.addEventListener('ConfirmDelete',function(e) {

            let sa_title, sa_text, lw_url

            console.log('e.detail.type',e.detail.type)

            if (e.detail.type === 'cr') {
                sa_title = 'Do you really want to delete this Change Request?'
                sa_text = 'Once deleted, there is no reverting back!'
                lw_url = 'deleteCR'
            }

            if (e.detail.type == 'attach') {
                sa_title = 'Do you really want to delete this file/attachment?'
                sa_text = 'Once deleted, there is no reverting back!'
                lw_url = 'deleteAttach'
            }

            console.log('lw_url',lw_url)


            Swal.fire({
                title: sa_title,
                text: sa_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Ooops ...',

            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(lw_url)
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

        function showModal(modalNo) {
            document.getElementById(modalNo).classList.add('is-active')
        }

        function hideModal(modalNo) {
            document.getElementById(modalNo).classList.remove('is-active')
        }

    </script>

    @switch($action)

        @case('FORM')
            @include('admin.users.lw-users-form')
            @break

        @case('VIEW')
            @include('admin.users.lw-users-view')
            @break

        @case('LIST')
        @default
            @include('admin.users.lw-users-list')
            @break

    @endswitch

</section>
