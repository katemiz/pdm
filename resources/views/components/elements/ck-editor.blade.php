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

        cktype = '{{$cktype}}'

        //console.log(cktype)

        switch (cktype) {

            case 'MIN':

                ck_toolbar = [
                    'undo', 'redo', '|','link','|',
                    'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]

                break;


            case 'STANDARD':

                ck_toolbar = {
                    items: [
                        'undo', 'redo', '|',
                        'bold', 'italic', 'strikethrough','Underline','subscript', 'superscript','code','|','numberedList', 'bulletedList','|',
                        'link', 'blockQuote','|',
                        'outdent','indent','alignment','|','insertTable','insertImage'
                    ],
                }

                break;

            case 'FULL':

                ck_toolbar = {
                    items: [
                        'undo', 'redo', '|',
                        'bold', 'italic', 'strikethrough','Underline','subscript', 'superscript','code','|','numberedList', 'bulletedList','|',
                        'link', 'blockQuote','|',
                        'outdent','indent','alignment','|','insertTable','insertImage','|','SpecialCharacters','-','fontSize','fontColor','fontBackgroundColor','|','selectAll','pageBreak','removeFormat','sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                }
                break;

            default:

        }


        //console.log(ck_toolbar)


        if ( !IsCkUploadAdapterDefined ) {

            IsCkUploadAdapterDefined = true

            class MyUploadAdapter {
                constructor( loader ) {
                    // The file loader instance to use during the upload.
                    this.loader = loader;
                }

                // Starts the upload process.
                upload() {
                    return this.loader.file
                        .then( file => new Promise( ( resolve, reject ) => {
                            this._initRequest();
                            this._initListeners( resolve, reject, file );
                            this._sendRequest( file );
                        } ) );
                }

                // Aborts the upload process.
                abort() {
                    if ( this.xhr ) {
                        this.xhr.abort();
                    }
                }

                // Initializes the XMLHttpRequest object using the URL passed to the constructor.
                _initRequest() {
                    const xhr = this.xhr = new XMLHttpRequest();

                    // Note that your request may look different. It is up to you and your editor
                    // integration to choose the right communication channel. This example uses
                    // a POST request with JSON as a data structure but your configuration
                    // could be different.
                    xhr.open( 'POST', ' {{ route('ckimages') }} ', true );
                    xhr.setRequestHeader('x-csrf-token','{{ csrf_token() }}');
                    xhr.responseType = 'json';
                }

                // Initializes XMLHttpRequest listeners.
                _initListeners( resolve, reject, file ) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                    xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                    xhr.addEventListener( 'abort', () => reject() );
                    xhr.addEventListener( 'load', () => {
                        const response = xhr.response;

                        // This example assumes the XHR server's "response" object will come with
                        // an "error" which has its own "message" that can be passed to reject()
                        // in the upload promise.
                        //
                        // Your integration may handle upload errors in a different way so make sure
                        // it is done properly. The reject() function must be called when the upload fails.
                        if ( !response || response.error ) {
                            return reject( response && response.error ? response.error.message : genericErrorText );
                        }

                        // If the upload is successful, resolve the upload promise with an object containing
                        // at least the "default" URL, pointing to the image on the server.
                        // This URL will be used to display the image in the content. Learn more in the
                        // UploadAdapter#upload documentation.
                        resolve( {
                            default: response.url
                        } );
                    } );

                    // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                    // properties which are used e.g. to display the upload progress bar in the editor
                    // user interface.
                    if ( xhr.upload ) {
                        xhr.upload.addEventListener( 'progress', evt => {
                            if ( evt.lengthComputable ) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        } );
                    }
                }

                // Prepares the data and sends the request.
                _sendRequest( file ) {
                    // Prepare the form data.
                    const data = new FormData();

                    data.append( 'upload', file );

                    // Important note: This is the right place to implement security mechanisms
                    // like authentication and CSRF protection. For instance, you can use
                    // XMLHttpRequest.setRequestHeader() to set the request headers containing
                    // the CSRF token generated earlier by your application.

                    // Send the request.
                    this.xhr.send( data );
                }
            }

            function MyCustomUploadAdapterPlugin( editor ) {
                editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new MyUploadAdapter( loader );
                };
            }

        }










        ClassicEditor
            .create(document.querySelector('#{{$edId}}'), {
                toolbar:ck_toolbar,
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
            })
            .then(editor => {

                // Prints all available plugins : DO NOT REMOVE
                // console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ));

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
