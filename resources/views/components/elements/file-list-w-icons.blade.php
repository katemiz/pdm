<div>
    @if (count($attachments) > 0)

    <div class="card">

        <div class="card-content">
          <div class="media">
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
                <a wire:click="downloadFile('{{ $attachment->id }}')" class="is-size-7 is-block">{{ $attachment->original_file_name }}</a>
            @endforeach

          </div>
        </div>
    </div>

@endif
</div>

