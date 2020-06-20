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
        <h1>Favorites</h1>
        <p class="lead text-muted">This page displays list of all user favorite contents. Click on heart icon on top
            right to remove content from favorites.</p>
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