@extends('layouts.dashboard')

@section('css')
<style>
    .favourite-wrapper {
        position: absolute;
    }
</style>
@endsection

@section('content')
<section class="jumbotron text-center">
    <div class="container">
        <h1>Content</h1>
        <p class="lead text-muted">This page displays list of all user contents. Click on below "Add Content" button to
            store new content. Click on heart icon in top right of each card to toggle favorite content.</p>
        <p>
            <a href={{ route('contents.create') }} class="btn btn-primary my-2">Add Content</a>
        </p>
    </div>
</section>
<div class="alert d-none" role="alert">
</div>
<div class="album py-5 bg-light">
    <div class="container">
        <div id="content-data">
            @include('content.pagination-cards')
        </div>

    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/content/index.js') }}" defer></script>
@endsection