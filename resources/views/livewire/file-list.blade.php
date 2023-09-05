<div class="column">
@if ($attachments->count() > 0)
<table class="table is-fullwidth is-size-7">

    @foreach ($attachments as $key => $attachment)
    <tr class="my-0">
        <td class="is-narrow">
            {{ ++$key }}
        </td>
        <td>
            <a wire:click="downloadFile('{{ $attachment->id }}')">{{ $attachment->original_file_name }}</a>
        </td>
        <td class="is-narrow">{{ $attachment->mime_type }}</td>
        <td class="is-narrow">{{ $attachment->file_size }}</td>

        @if ($canDelete)
        <td class="is-narrow has-text-right">
            <a wire:click="startAttachDelete('{{$attachment->id}}')">
                <span class="icon is-small has-text-danger"><x-carbon-trash-can /></span>
            </a>
        </td>
        @endif
    </tr>
    @endforeach

</table>
@endif
</div>

