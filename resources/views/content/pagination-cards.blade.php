<div class="row">
    @foreach($data as $row)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">

            @if ($row->content_category->name === 'Images')
            <a href="{{$row->file_path}}" target="_blank">
                <img class="card-img-top" src="{{$row->file_path}}" style="max-height: 232px;">
            </a>
            @elseif ($row->content_category->name === 'Documents')
            <a href="{{$row->file_path}}" target="_blank">
                <svg class="bi bi-file-richtext p-4" width="100%" height="100%" style="max-height: 232px;"
                    viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z" />
                    <path fill-rule="evenodd"
                        d="M4.5 11.5A.5.5 0 0 1 5 11h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 9h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm1.639-3.708l1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V7.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V7s1.54-1.274 1.639-1.208zM6.25 5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z" />
                </svg>
            </a>
            @elseif ($row->content_category->name === 'Audio')
            <a href="{{$row->file_path}}" target="_blank">
                <svg class="bi bi-music-note-beamed p-4" width="100%" height="100%" style="max-height: 232px;"
                    viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2zm9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2z" />
                    <path fill-rule="evenodd" d="M14 11V2h1v9h-1zM6 3v10H5V3h1z" />
                    <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4V2.905z" />
                </svg>
            </a>
            @else
            <a href="{{$row->file_path}}" target="_blank">
                <svg class="bi bi-camera-video" width="100%" height="100%" style="max-height: 232px;"
                    viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M2.667 3.5c-.645 0-1.167.522-1.167 1.167v6.666c0 .645.522 1.167 1.167 1.167h6.666c.645 0 1.167-.522 1.167-1.167V4.667c0-.645-.522-1.167-1.167-1.167H2.667zM.5 4.667C.5 3.47 1.47 2.5 2.667 2.5h6.666c1.197 0 2.167.97 2.167 2.167v6.666c0 1.197-.97 2.167-2.167 2.167H2.667A2.167 2.167 0 0 1 .5 11.333V4.667z" />
                    <path fill-rule="evenodd"
                        d="M11.25 5.65l2.768-1.605a.318.318 0 0 1 .482.263v7.384c0 .228-.26.393-.482.264l-2.767-1.605-.502.865 2.767 1.605c.859.498 1.984-.095 1.984-1.129V4.308c0-1.033-1.125-1.626-1.984-1.128L10.75 4.785l.502.865z" />
                </svg>
            </a>
            @endif

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="{{route('contents.edit', $row->id)}}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <a href="{{route('contents.destroy', $row->id)}}"
                            class="btn btn-sm btn-outline-secondary delete-content">Delete</a>
                    </div>
                    <small class="text-muted">{{$row->created_at}}</small>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    @if (count($data)>0)
    {!! $data->links() !!}
    @else
    <p>No content.</p>
    @endif
</div>