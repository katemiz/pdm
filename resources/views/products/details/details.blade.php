<section class="section container has-background-white">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>


    <script>

        window.addEventListener('show-select-approvers',function(e) {

            console.log(document.getElementById('m10').classList)

            document.getElementById('m10').classList.add('is-active')

            console.log('slfkslfgfkg')
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
            @include('products.details.details-form')
            @break

        @case('VIEW')
            @include('products.items-view')
        @break

    @endswitch

</section>
