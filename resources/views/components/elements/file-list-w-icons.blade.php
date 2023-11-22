
<div class="box">
    @if (count($attachments) > 0)


        <p class="subtitle">{{ $files_header }}</p>
        <article class="media">
            @foreach ($attachments as $key => $attachment)
                <figure class="image is-64x64">
                    <a wire:click="downloadFile('{{ $attachment->id }}')">
                        <img src="{{ asset('/images/'.$icon_name) }}" alt="Image">
                    </a>
                </figure>
            @endforeach
        </article>

@endif
</div>

