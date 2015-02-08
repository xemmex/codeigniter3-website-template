jQuery(document).ready(function ($) {

    // Gallery container
    var $container = $('#gallery-container').imagesLoaded(function () {
        $container.shuffle();

        // Caption
        $container.on('mouseenter', '.thumbnail', function () {
            $(this).find('.caption').fadeIn();
        }).on('mouseleave', '.thumbnail', function () {
            $(this).find('.caption').fadeOut();
        });

        // Gallery categories
        $('#gallery-categories').on('click', 'button', function () {

            $(this).addClass("active").siblings().removeClass("active");

            var category = $(this).attr('data-category');

            $container.shuffle('shuffle', function ($el) {

                if (category === 'all' || $.inArray(category, $el.attr('data-categories').split(',')) >= 0) {
                    return true;
                }

                return false;
            });

        });

        $('#add-images').fileupload({
            url: $('#add-images').attr('data-url'),
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000
        }).on('fileuploaddone', function (e, data) {
            if (data.result.status === true) {
                var $image = $(data.result.image);
                $('#gallery-container').append($image);
                $('#gallery-container').shuffle('appended', $image);
            }
            else {
                show_growl(data.result.message, "danger");
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            if (progress > 0 && progress < 100) {
                $('#add-images-progress').fadeIn();
                $('#add-images-progress .progress-bar').css('width', progress + '%');
            }
            else {
                $('#add-images-progress').fadeOut();
                $('#filter-no-category').trigger("click");
            }
        }).on('fileuploadprocessalways', function (e, data) {
            if (data.files[data.index].error) {
                show_growl(data.files[data.index].error, "danger");
            }
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                show_growl('File upload failed', "danger");
            });
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
});

