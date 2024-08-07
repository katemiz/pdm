<div class="field">

    <label class="label" for="{{ $quillId }}">{{$label}}</label>

    <!-- Create the editor container -->
    <div class="control" id="{{ $quillId }}" wire:ignore></div>

 



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

