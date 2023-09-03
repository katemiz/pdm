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

    <input type="hidden" id="{{$edId}}" value="{{ $content }}">

    <script>

        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {

                window.ck5editor = editor

                //console.log('ddddd',document.getElementById('{{$varname}}'))

                editor.setData( document.getElementById('{{$edId}}').value );

                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                    //document.getElementById('{{$varname}}').value = editor.getData()
                })
            })
            .catch(error => {
                console.error(error);
            });

    </script>

    {{-- @error('content')
    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror --}}

</div>
