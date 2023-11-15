<div class="field">

    <div class="field">
      <label class="label">{{ $params['label'] }}</label>
      <div class="control">
        <textarea class="textarea ckeditor" 
            id="{{ $params['name']}}" 
            name="{{ $params['name']}}" 
            placeholder="{{ $params['placeholder'] }}">
            {!! $value !!}
        </textarea>
      </div>
    </div>
  
    <script>
        ClassicEditor
          .create( document.querySelector('#{{ $params['name'] }}') )
          .then( editor => {
        })
        .catch( error => {
          console.error(error);
        });
    </script>
  
    @error($params['name'])
    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror
  
</div>