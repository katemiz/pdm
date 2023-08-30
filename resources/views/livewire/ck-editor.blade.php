<div class="field">

    <div class="field">
      <label class="label">{{ $label }}</label>
      <div wire:ignore class="control">
        <textarea wire:model="content" class="textarea ckeditor"
            id="content"
            name="content"
            placeholder="{{ $placeholder }}">
        </textarea>
      </div>
    </div>


    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {

                editor.setData( document.getElementById('{{$varname}}').value );

                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                    document.getElementById('{{$varname}}').value = editor.getData()
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
