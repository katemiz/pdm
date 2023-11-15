<section class="section container">

    <script>

        window.addEventListener('ConfirmDelete',function(e) {

            let sa_title = 'Do you really want to delete this Company?'
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

    </script>

    @switch($action)

        @case('FORM')
            @include('admin.companies.lw-companies-form')
            @break

        @case('VIEW')
            @include('admin.companies.lw-companies-view')
            @break

        @case('LIST')
        @default
            @include('admin.companies.lw-companies-list')
            @break

    @endswitch

</section>
