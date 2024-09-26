
<div>


<div class="flex flex-col gap-2"   wire:ignore>

    <label class="" for="{{ $quillId }}">{{$label}}</label>

    <!-- Create the editor container -->

    <div id="{{ $quillId }}"></div>

 
    <!-- Initialize Quill editor -->
    <script>

        const quill{{ $quillId }} = new Quill('#{{ $quillId }}', {
            theme: 'snow'
        });

        quill{{ $quillId }}.on('text-change', function () {
            let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
            @this.set('value', value)
        })




    </script>


</div>

<h2>VALUE in Livewire Componet= {{ $value }}</h2>


</div>

