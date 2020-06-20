$(document).ready(function () {
    bsCustomFileInput.init()

    // on content category change
    $('#content-category-id').on('change', function () {
        // hide all required fields and error messages
        $('#upload-file-form').addClass('d-none');
        $('.custom-link-form-group').addClass('d-none');
        $('.invalid-feedback').removeClass('d-block');

        // reset hidden fields
        $('#file-name').val(null);
        $('#file-path').val(null);
        $('#original-file-name').val(null);

        // handle on select value change
        if (this.value) {
            if (this.options[this.selectedIndex].text === 'YouTube or Vimeo Link') {
                $('.custom-link-form-group').removeClass('d-none');
            } else {
                $('#upload-file-form').removeClass('d-none');
            }
        }
    });

    // on file input change
    $("#file").change(function (event) {
        // hide all required fields and error messages
        $('.alert').removeClass('d-block');
        $('.invalid-feedback').removeClass('d-block');

        // if no file selected
        if (this.files.length === 0)
            return;

        // validate file size
        if (this.files[0].size > 8192000) {
            $('.custom-file .invalid-feedback').addClass('d-block');
            $('.custom-file .invalid-feedback').text('File size should be less than 8mb.');
            return;

        }
        // create form data
        var formData = new FormData();
        formData.append('file', this.files[0], this.files[0].name);

        // make ajax api call
        $.ajax({
            url: $('#upload-file-form').attr('action'),
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            xhr: function (params) {
                var xhr = new window.XMLHttpRequest();
                // Handle progress
                //Upload progress
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        //Do something with upload progress
                        $('.progress .progress-bar').css('width', percentComplete + '%');
                        $('.progress .progress-bar').text(percentComplete + '%');
                    }
                }, false);

                return xhr;
            },
            beforeSend: function (XMLHttpRequest) {
                // handle html elements before sending file
                $('.progress').removeClass('d-none');
                $('.progress .progress-bar').removeClass('bg-success');
            },
            success: function (data) {
                // update html elements after success
                $('.progress').removeClass('d-none');
                $('.progress .progress-bar').addClass('bg-success');
                $('.progress .progress-bar').css('width', '100%');
                $('.progress .progress-bar').text('100%');

                // update hidden input values to store file details
                $('#file-name').val(data.data.file_name);
                $('#original-file-name').val(data.data.original_file_name);
                $('#file-path').val(data.data.file_path);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // handle errors
                $('.progress').addClass('d-none');
                var response = xhr.responseJSON;
                if (response) {
                    if (response.errors) {
                        var errors = response.errors;
                        if (errors.file) {
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
    $("#button-save").click(function (event) {
        event.preventDefault();

        // hide all required fields and error messages
        $('.alert').removeClass('d-block');
        $('.invalid-feedback').removeClass('d-block');


        // create form data
        var formData = new FormData();
        // this is a work around for laravels PUT/PATCH routes
        if ($('#content-create-form').attr('method') === 'PUT') {
            formData.append('_method', 'PUT');
        }
        formData.append('content_category_id', $('#content-category-id').find(":selected").val());

        formData.append('file_name', $('#file-name').val());
        formData.append('original_file_name', $('#original-file-name').val());

        // if file details exist else add content link
        if ($('#file-path').val()) {
            formData.append('file_path', $('#file-path').val());
        } else {
            var filePath = $('#content-link').val();
            if (!filePath.match(/^(http:\/\/|https:\/\/)(vimeo\.com|youtu\.be|www\.youtube\.com)\/([\w\/]+)([\?].*)?$/i)) {
                $('.custom-link-form-group .invalid-feedback').addClass('d-block');
                $('.custom-link-form-group .invalid-feedback').text('Invalid youtube or vimeo url.');
                return;
            }
            formData.append('file_path', filePath);
        }

        // display loader
        $('#button-save .spinner-border').removeClass('d-none');
        $('#button-save').prop('disabled', true);

        // make ajax api calls
        $.ajax({
            url: $('#content-create-form').attr('action'),
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (data) {
                // update html elements after success and redirect to link
                $('#button-save .spinner-border').addClass('d-none');
                $('#button-save').prop('disabled', false);
                window.location.href = data.redirect_to;
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // handle errors
                $('#button-save .spinner-border').addClass('d-none');
                $('#button-save').prop('disabled', false);
                var response = xhr.responseJSON;
                if (response) {
                    if (response.errors) {
                        var errors = response.errors;
                        if (errors.file_name) {
                            $('.custom-file .invalid-feedback').addClass('d-block');
                            $('.custom-file .invalid-feedback').text(errors.file_name[0]);
                        }
                        if (errors.content_category_id) {
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
});