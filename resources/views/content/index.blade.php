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
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator,
            etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
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
<script type="text/javascript">
    $(document).ready(function(){
    
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var href = $(this).attr('href');
            fetch_data(href);
        });
    
        
    
        $(document).on('click', '.delete-content', function(event){
            event.preventDefault();
            $('.alert').removeClass('d-block alert-success alert-danger');
            var href = $(this).attr('href');

            $.ajax({
            url:href,
            method:'DELETE',
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success:function(data)
            {
                $('.alert').addClass('d-block alert-success');
                $('.alert').text(data.message);
                fetch_data(window.location.href);
            },
            error: function(xhr, ajaxOptions, thrownError){
                $('.alert').addClass('d-block alert-danger');
                $('.alert').text(thrownError);
            }
            
            });
        });

        
    });

    function fetch_data(href)
    {
        $.ajax({
            url:href,
            success:function(data)
            {
                $('#content-data').html(data);
            }
        });
    }

    function toggleFavourite(id, favorite){
    
    $.ajax({
        url: 'contents/'+id+'/toggle-favorite',
        method: 'POST',
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function(data){
            fetch_data(window.location.href);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('.alert').addClass('d-block alert-danger');
            $('.alert').text(thrownError);
        }
    });
    }
</script>
@endsection