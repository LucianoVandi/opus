<div style="border: 1px solid #eee; border-radius: 3px; margin-bottom: 20px; box-shadow: 0 1px 1px rgba(0,0,0,.05); padding: 12px 15px;">
    <div class="media" style="margin-bottom:10px;">
        <div class="pull-left" style="padding-right: 12px;">
            <p class="media-object"><i class="fa fa-tag fa-fw"></i> {{_i('Attachments')}}:</p>
        </div>
        <div class="media-body" style="line-height: 26px;">
            @if($attachments->count() > 0)
            <ul class="list-unstyled list-inline attachments pull-left">
                @foreach($attachments as $attachment)
                <li>
                    <a href="{{route('attachments.url', [$team->slug])}}?path={{ $attachment->path }}" target="_blank">
                        {{ $attachment->name }}
                    </a>
                    @if(Auth::user()->hasPermission('admin') || Auth::id() == $attachment->user_id)
                    <a href="#" id="delete-attachment" data-attachment-id="{{$attachment->id}}">
                        <i class="fa fa-trash-o fa-fw" style="font-size: 14px;"></i>&nbsp;
                    </a>
                    @endif
                </li>
                @endforeach
            </ul>
            @else
            <h1 class="nothing-found" style="margin: 0px; line-height: 20px;"><i class="fa fa-exclamation-triangle fa-fw icon"></i> {{_i('Nothing found')}}</h1>
            @endif
        </div>
    </div>
    <form id="upload-attachments" action="{{route('attachments.upload')}}" data-id="{{$attachable['id']}}" data-type="{{$attachable['type']}}" method="post" class="form form-inline" enctype="multipart/form-data">
        <input type="file" name="attachment[]" id="attachment">
        <button class="btn btn-primary" type="submit">{{_i('Upload File(s)')}}</button>
    </form>
</div>