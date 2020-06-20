$(document).ready(function () {

    // on click of pagintion elements
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var href = $(this).attr('href');
        fetchData(href);
    });


    // on click of delete content button
    $(document).on('click', '.delete-content', function (event) {
        event.preventDefault();
        // handle html elements
        $('.alert').removeClass('d-block alert-success alert-danger');
        var href = $(this).attr('href');

        // make ajax call
        $.ajax({
            url: href,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (data) {
                // handle html elements
                $('.alert').addClass('d-block alert-success');
                $('.alert').text(data.message);
                fetchData(window.location.href);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.alert').addClass('d-block alert-danger');
                $('.alert').text(thrownError);
            }

        });
    });


});

/**
 * function to make ajax call to get data from the give url
 * @param {url} href url of the page to get data
 */
function fetchData(href) {
    $.ajax({
        url: href,
        success: function (data) {
            $('#content-data').html(data);
        }
    });
}

/**
 * function to make ajax call to toggle favourite of a content
 * @param {url} url toggle favourite url of the content
 */
function toggleFavourite(url) {
    $.ajax({
        url: url,
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (data) {
            fetchData(window.location.href);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('.alert').addClass('d-block alert-danger');
            $('.alert').text(thrownError);
        }
    });
}