@extends('layouts.dashboard')

@section('css')
<style>
</style>
@endsection

@section('content')
<section class="jumbotron text-center">
    <div class="container">
        <h1>Add Content</h1>
    </div>
</section>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="alert d-none" role="alert">
        </div>
        <div class="row">
            <div class="col">
                <form id="content-create-form"
                    action="{{ ( @$content ? route('contents.update', @$content->id) : route('contents.store')) }}"
                    method="{{ ( @$content ? 'PUT' : 'POST') }}">
                    <input type="hidden" id="file-name" value="{{(@$content?$content->file_name:'')}}" />
                    <input type="hidden" id="original-file-name"
                        value="{{(@$content?$content->original_file_name:'')}}" />
                    <input type="hidden" id="file-path" value="{{(@$content?$content->file_path:'')}}" />
                    <div class="form-group custom-select-form-group">
                        <label for="content-category-id">Content Category</label>
                        <select class="custom-select" id="content-category-id" name="content_category_id">
                            <option value="">Select Category</option>
                            @foreach ($content_categories as $content_category)
                            <option value="{{$content_category->id}}"
                                {{ ( @$content && @$content->content_category_id == $content_category->id) ? 'selected' : '' }}>
                                {{$content_category->name}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                    </div>
                    <div class="form-group custom-link-form-group d-none">
                        <label for="content-link">Youtube or Vimeo Link</label>
                        <input type="text" class="form-control" id="content-link"
                            placeholder="http://www.youtube.com/watch?v=-wtIMTCHWuI"
                            value="{{ ( @$content && @$content->content_category->name == 'YouTube or Vimeo Link') ? @$content->file_path : '' }}">
                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                    </div>
                </form>
                <form class="{{ (@$content && @$content->original_file_name?'':'d-none')}}" id="upload-file-form"
                    enctype="multipart/form-data" action="{{ route('file-upload.store') }}">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file"
                                value="{{ (@$content && @$content->original_file_name?@$content->original_file_name:'')}}">
                            <label class="custom-file-label"
                                for="customFile">{{ (@$content && @$content->original_file_name?@$content->original_file_name:'Choose file')}}</label>
                            <div class="progress d-none">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                    </div>
                </form>
                <button id="button-save" class="btn btn-primary" type="submit"><span
                        class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    {{  @$content  ? 'Update' : 'Save' }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        bsCustomFileInput.init()

        // var file=null;

        // on content category change
        $('#content-category-id').on('change', function() {
            $('#upload-file-form').addClass('d-none');
            $('.custom-link-form-group').addClass('d-none');
            $('.invalid-feedback').removeClass('d-block');
            if(this.value){
                if(this.options[this.selectedIndex].text === 'YouTube or Vimeo Link'){
                    $('.custom-link-form-group').removeClass('d-none');
                } else {
                    $('#upload-file-form').removeClass('d-none');
                }
            }
        });

        // on file input change
        $("#file").change(function(event){
            $('.alert').removeClass('d-block');
            $('.invalid-feedback').removeClass('d-block');
            var serializeArray = $('#upload-file-form').serializeArray();
            var formData = new FormData();
            formData.append('file', this.files[0], this.files[0].name);
            $.ajax({
                url: $('#upload-file-form').attr('action'),
                method: 'POST',
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: formData,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                xhr: function(params) {
                    var xhr = new window.XMLHttpRequest();
                    // Handle progress
                    //Upload progress
                    xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                    var percentComplete = Math.round((evt.loaded / evt.total)*100);
                    //Do something with upload progress
                    $('.progress .progress-bar').css('width', percentComplete+'%');
                    $('.progress .progress-bar').text(percentComplete+'%');
                    }
                    }, false);

                    return xhr;
                },
                beforeSend: function(XMLHttpRequest){
                    $('.progress').removeClass('d-none');
                    $('.progress .progress-bar').removeClass('bg-success');
                },
                success: function(data){
                    $('.progress').removeClass('d-none');
                    $('.progress .progress-bar').addClass('bg-success');
                    $('.progress .progress-bar').css('width', '100%');
                    $('.progress .progress-bar').text('100%');
                    $('#file-name').val(data.data.file_name);
                    $('#original-file-name').val(data.data.original_file_name);
                    $('#file-path').val(data.data.file_path);
                },
                error: function(xhr, ajaxOptions, thrownError){
                    $('.progress').addClass('d-none');
                    var response = xhr.responseJSON;
                    if(response){
                        if(response.errors){
                            var errors = response.errors;
                            if(errors.file){
                                $('.custom-file .invalid-feedback').addClass('d-block');
                                $('.custom-file .invalid-feedback').text(errors.file[0]);
                            }
                        }
                    } else {
                        $('.alert').addClass('d-block alert-danger');
                        $('.alert').text(thrownError);
                    }
                }
            });
        });

        // on file input change
        $("#button-save").click(function(event){
            event.preventDefault();
            $('.alert').removeClass('d-block');
            $('.invalid-feedback').removeClass('d-block');
            $('#button-save .spinner-border').removeClass('d-none');
            $('#button-save').prop('disabled', true);
            var serializeArray = $('#content-create-form').serializeArray();
            var formData = new FormData();
            if($('#content-create-form').attr('method') === 'PUT'){
                formData.append('_method', 'PUT');    
            }
            formData.append('content_category_id', $('#content-category-id').find(":selected").val());
            if($('#file-name').val() && $('#file-path').val() && $('#original-file-name').val()){
                formData.append('file_name', $('#file-name').val());
                formData.append('file_path', $('#file-path').val());
                formData.append('original_file_name', $('#original-file-name').val());
            } else {
                var filePath = $('#content-link').val();
                if(!filePath.match("^(http:\/\/|https:\/\/)(vimeo\.com|youtu\.be|www\.youtube\.com)\/([\w\/]+)([\?].*)?$"))
                {
                    $('.custom-link-form-group .invalid-feedback').addClass('d-block');
                    $('.custom-link-form-group .invalid-feedback').text('Invalid youtube or vimeo url.');
                }
                formData.append('file_path', filePath);
            }
            $.ajax({
                url: $('#content-create-form').attr('action'),
                method: 'POST',
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: formData,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                beforeSend: function(XMLHttpRequest){
                },
                success: function(data){
                    $('#button-save .spinner-border').addClass('d-none');
                    $('#button-save').prop('disabled', false);
                    window.location.href = data.redirect_to;
                },
                error: function(xhr, ajaxOptions, thrownError){
                    $('#button-save .spinner-border').addClass('d-none');
                    $('#button-save').prop('disabled', false);
                    var response = xhr.responseJSON;
                    if(response){
                        if(response.errors){
                            var errors = response.errors;
                            if(errors.file_name){
                                $('.custom-file .invalid-feedback').addClass('d-block');
                                $('.custom-file .invalid-feedback').text(errors.file_name[0]);
                            }
                            if(errors.content_category_id){
                                $('.custom-select-form-group .invalid-feedback').addClass('d-block');
                                $('.custom-select-form-group .invalid-feedback').text(errors.content_category_id[0]);
                            }
                        }
                    } else {
                        $('.alert').addClass('d-block alert-danger');
                        $('.alert').text(thrownError);
                    }
                }
            });
        });
    })
</script>
@stop