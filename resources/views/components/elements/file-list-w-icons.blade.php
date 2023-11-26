<div>
    @if (count($attachments) > 0)

    <div class="card">

        <div class="card-content has-background-white-ter">
          <div class="media ">
            <div class="media-left">
              <figure class="image is-48x48">
                <img src="{{ asset('/images/'.$icon_name) }}" alt="Type of Files">
              </figure>
            </div>
            <div class="media-content">
              <p class="subtitle is-6">{{ $files_header }}</p>
            </div>
          </div>

          <div class="content">

            @foreach ($attachments as $key => $attachment)
                {{-- <a wire:click="downloadFile('{{ $attachment->id }}')" class="is-size-7 is-block">
                  
                  <span class="icon is-small is-left"><x-carbon-dot-mark /></span>
                  
                  {{ $attachment->original_file_name }}</a> --}}



                  <a wire:click="downloadFile('{{ $attachment->id }}')" class="button is-ghost is-block  has-text-left">
                    <span class="icon"><x-carbon-document-blank /></span>
                    <span>{{ $attachment->original_file_name }}</span>
                  </a>


            @endforeach

          </div>
        </div>
    </div>

@endif
</div>

