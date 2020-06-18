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
                <form id="upload-file-form" enctype="multipart/form-data" action="{{ route('file-upload.store') }}">
                    @csrf
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            <div class="progress d-none">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                    </div>
                </form>
                <form id="content-create-form" action="{{ route('contents.store')}}">
                    @csrf
                    <div class="form-group custom-select-form-group">
                        <select class="custom-select" name="content_category_id">
                            <option value="">Select Category</option>
                            @foreach ($content_categories as $content_category)
                            <option value="{{$content_category->id}}">{{$content_category->name}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                    </div>
                    <button id="button-save" class="btn btn-primary" type="submit"><span
                            class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        bsCustomFileInput.init()

        var file_name='';

        // on file input change
        $("#file").change(function(event){
            $('.alert').removeClass('d-block');
            $('.invalid-feedback').removeClass('d-block');
            var serializeArray = $('#upload-file-form').serializeArray();
            var formData = new FormData();
            formData.append('file', this.files[0], this.files[0].name);
            $.each(serializeArray, function(key, element){
                formData.append(element.name, element.value);
            });
            $.ajax({
                url: $('#upload-file-form').attr('action'),
                method: 'POST',
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
                    file_name = data.data.file_name;
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
        $("#content-create-form").submit(function(event){
            event.preventDefault();
            $('.alert').removeClass('d-block');
            $('.invalid-feedback').removeClass('d-block');
            $('#button-save .spinner-border').removeClass('d-none');
            $('#button-save').prop('disabled', true);
            var serializeArray = $('#content-create-form').serializeArray();
            var formData = new FormData();
            formData.append('file_name', file_name);
            $.each(serializeArray, function(key, element){
                formData.append(element.name, element.value);
            });
            $.ajax({
                url: $('#content-create-form').attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                beforeSend: function(XMLHttpRequest){
                },
                success: function(data){
                    $('#button-save .spinner-border').addClass('d-none');
                    $('#button-save').prop('disabled', false);
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