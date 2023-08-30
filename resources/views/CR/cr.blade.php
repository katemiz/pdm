
<section class="section container">

    <script>

        window.addEventListener('runConfirmDialog',function(e) {

            Swal.fire({
                title: e.detail.title,
                text: e.detail.text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Ooops ...',

            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('runDelete')
                } else {
                    return false
                }
            })
        });

        window.addEventListener('infoDeleted11',function(e) {

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Item has been deleted',
                showConfirmButton: false,
                timer: 1500
            })
        })


        window.addEventListener('deleteFormDOM',function() {


            ck5editor.destroy()


        })






        

    </script>




    @switch($action)

        @case('FORM')
            @include('CR.form')
            @break

        @case('VIEW')
            @include('CR.view')
        @break

        @case('LIST')
        @default
            @include('CR.list')
            @break

    @endswitch

</section>


