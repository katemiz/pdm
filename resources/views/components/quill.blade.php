<div class="mt-4">

    <div class="flex flex-col gap-2" wire:ignore>

        <h3 class="mb-1 font-semibold text-gray-900 text-md">{{ $label }}</h3>

        <!-- Create the editor container -->
        <div id="{{ $qid }}">{!! $value !!}</div>

        <!-- Initialize Quill editor -->
        <script>
            const quill{{ $qid }} = new Quill('#{{ $qid }}', {
                theme: 'snow'
            });

            quill{{ $qid }}.on('text-change', function() {
                let parent = document.getElementById('{{ $qid }}')
                @this.set('form.{{ $name }}', parent.getElementsByClassName('ql-editor')[0].innerHTML)
            })
        </script>

    </div>

    <div class="text-red-600 my-1 font-bold">
        @error('form.' . $name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

</div>
