<div class="field content">
    <label class="label">{{ $label }}</label>
    <div wire:ignore class="control">
        <textarea wire:model="content" class="textarea ckeditor"
            id="{{$edId}}"
            name="{{$edId}}"
            placeholder="{{ $placeholder }}">
        </textarea>
    </div>

    <input type="hidden" id="H{{$edId}}" value="{{ $content }}">

    <script>

        ed_type = '{{$ed_type}}'

        switch (ed_type) {
            case 'LIGHT':

                edconfig = {
                    removePlugins: [ 'Heading', 'Link' ],
                    toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
                }

                break;


            case 'STANDARD':

                edconfig = {
                    removePlugins: [ 'Heading', 'Link' ],
                    toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
                }

                break;

            case 'FULL':

                edconfig = {
                    //removePlugins: [ 'Heading', 'Link' ],
                    toolbar:
                        [ 'link','bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ,
                        'FontColor','bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]


                }

                break;

            default:

        }

        ClassicEditor
            .create(document.querySelector('#{{$edId}}'), edconfig )
            .then(editor => {

                // Prints all available plugins : DO NOT REMOVE
                console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ));

                editor.setData( document.getElementById('H{{$edId}}').value );
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

    </script>

</div>
