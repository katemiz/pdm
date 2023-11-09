<div>
    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Create the editor container -->
    <div id="editor" wire:ignore></div>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        quill.pasteHTML("{!! $value !!}");

        quill.on('text-change', function () {
        let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
        @this.set('value', value)
    })
    </script>    
</div>


