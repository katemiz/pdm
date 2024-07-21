<section class="section container has-background-white">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    <script>

        window.addEventListener('saveTree',function(e) {
            Livewire.dispatch('addTreeToDB', { bomData: $('#tree').tree('toJson')});
        })


        function addNodeJS(idAssy,idSelected,partNumber,description,version,part_type) {

            let qty,full_part_number
            let node = $('#tree').tree('getNodeById',idSelected)

            if (part_type == 'Standard') {
                console.log('Standard',partNumber)
                full_part_number = partNumber

            } else {

                console.log('Standard Değil',description)
                full_part_number = description
            }


            if (node === null) {
                qty = 1

                $('#tree').tree('appendNode', {
                    name: partNumber.toString(),
                    id: idSelected,
                    description:full_part_number,
                    version:version,
                    part_type:part_type,
                    qty:qty
                });

            } else {

                qty = node.qty +1

                $('#tree').tree('updateNode',node, {
                        name: partNumber.toString(),
                        id: idSelected,
                        description:full_part_number,
                        version:version,
                        part_type:part_type,
                        qty:qty
                    }
                );
            }

            Livewire.dispatch('addTreeToDB', { bomData: $('#tree').tree('toJson')});
        }


    </script>

    @switch($action)

        @case('FORM')
            @include('products.assy.assy-form')
            @break

        @case('VIEW')
            @include('products.items-view')
            @break

    @endswitch

</section>
