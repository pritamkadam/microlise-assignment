<div class="row">
    @foreach($contents as $row)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <div class="p-2 align-self-end favourite-wrapper"
                onclick="toggleFavourite('{{route('contents.toggle-favorite',$row->id)}}')">
                @if ($row->favorite === '0')
                @include('assets.svg.heart-outline')
                @else
                @include('assets.svg.heart-red')
                @endif
            </div>
            @if ($row->content_category->name === 'Images')
            <a href="{{$row->file_path}}" target="_blank">
                <img class="card-img-top" src="{{$row->file_path}}" style="max-height: 232px;">
            </a>
            @elseif ($row->content_category->name === 'Documents')
            <a href="{{$row->file_path}}" target="_blank">
                @include('assets.svg.file-richtext')
            </a>
            @elseif ($row->content_category->name === 'Audio')
            <a href="{{$row->file_path}}" target="_blank">
                @include('assets.svg.music-note')
            </a>
            @else
            <a href="{{$row->file_path}}" target="_blank">
                @include('assets.svg.camera-video')
            </a>
            @endif

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="{{route('contents.edit', $row->id)}}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        {{-- href="" --}}
                        <button class="btn btn-sm btn-outline-secondary"
                            data-href="{{route('contents.destroy', $row->id)}}" data-toggle="modal"
                            data-target="#deleteConfirmationModal">Delete</a>
                    </div>
                    <small class="text-muted">{{$row->created_at}}</small>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    @if (count($contents)>0)
    {!! $contents->links() !!}
    @else
    <p>No content.</p>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteConfirmationModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this content?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-delete">Delete</button>
            </div>
        </div>
    </div>
</div>