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
<script src="{{ asset('js/content/create.js') }}" defer></script>
@stop