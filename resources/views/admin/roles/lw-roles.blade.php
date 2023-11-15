<section class="section container">

    <script>

        window.addEventListener('ConfirmDelete',function(e) {

            let sa_title = 'Do you really want to delete this Role?'
            let sa_text = 'Once deleted, there is no reverting back!'

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
                    Livewire.dispatch('onDeleteConfirmed')
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
            @include('admin.roles.lw-roles-form')
            @break

        @case('VIEW')
            @include('admin.roles.lw-roles-view')
            @break

        @case('LIST')
        @default
            @include('admin.roles.lw-roles-list')
            @break

    @endswitch

</section>
