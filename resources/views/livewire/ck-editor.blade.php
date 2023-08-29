<div class="field">

    <div class="field">
      <label class="label">{{ $label }}</label>
      <div wire:ignore class="control">
        <textarea wire:model="content" class="textarea ckeditor"
            id="content"
            name="content"
            placeholder="{{ $placeholder }}">
            {!! $content !!}
        </textarea>
      </div>
    </div>

    <div>
        <span class="text-lg">You typed: {{ $content }}</span>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                    console.log(editor.getData())
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    @error($varname)
    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror

</div>
