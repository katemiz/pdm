
<div>


    <div class="flex flex-col gap-2"   wire:ignore>
    

        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">{{ $label }}</h3>

    
        <!-- Create the editor container -->
    
        <div id="{{ $qid }}">{{ $value }}</div>
    
     
        <!-- Initialize Quill editor -->
        <script>
    
            const quill{{ $qid }} = new Quill('#{{ $qid }}', {
                theme: 'snow'
            });
    
            quill{{ $qid }}.on('text-change', function () {

                //let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
                //@this.set('value', document.getElementsByClassName('ql-editor')[0].innerHTML)
                @this.set('form.{{ $name }}', document.getElementsByClassName('ql-editor')[0].innerHTML)


                //@this.set('count', 5)

            })
    
    
    
    
        </script>
    
    
    </div>
    
    <h2>VALUE in Livewire Componet= {{ $value }}</h2>
    
    
</div>
    