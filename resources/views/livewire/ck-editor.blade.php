<div class="field">

    <div class="field">
      <label class="label">{{ $label }}</label>
      <div wire:ignore class="control">
        <textarea wire:model="message" class="textarea ckeditor"
            id="{{ $varname }}"
            name="{{ $varname }}"
            placeholder="{{ $placeholder }}">
            {!! $content !!}
        </textarea>
      </div>












    </div>


    <div>
        <span class="text-lg">You typed:</span>
        <div class="w-full min-h-fit h-48 border border-gray-200">{{ $message }}</div>
    </div>

    {{-- <script>
        ClassicEditor
          .create( document.querySelector('#{{ $varname }}') )
          .then( editor => {
        })
        .catch( error => {
          console.error(error);
        });
    </script> --}}




{{-- @push('scripts') --}}


    <script>
        ClassicEditor
            .create(document.querySelector('#{{ $varname }}'))
            .then(editor => {

                console.log("OLDU")
                editor.model.document.on('change:data', () => {
                @this.set('{{ $varname }}', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>



{{-- @endpush --}}














    @error($varname)
    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror

</div>
