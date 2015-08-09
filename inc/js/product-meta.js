jQuery(document).ready(function ($) {

    $('#product_image')
        .data('orig-width', $('#product_image').width());

    if ($('#product_section .inside').width() < $('#product_image').width()) {
        $('#product_image')
            .width($('#product_section .inside').width());
    }

    if($('#product_image').length){
        $('#delete-btn').attr('type', 'button');
        $('#upload-btn').attr('type', 'hidden');
    }

    $('#upload-btn').click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
            .on('select', function (e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                var prod_img = $('#product_image');

                if (prod_img.length) {
                    prod_img.attr('src', image_url);
                } else {
                    $('#product_image_url').before(
                        $('<div id="product_img_wrapper">').append(
                            $('<img>').attr({
                                id: 'product_image',
                                src: image_url,
                                alt: 'Product Image'
                            })
                        )
                    );

                    $('#product_image')
                        .data('orig-width', $('#product_image').width());

                    if ($('#product_section .inside').width() < $('#product_image').width()) {
                        $('#product_image')
                            .width($('#product_section .inside').width());
                    }
                }


                $('#delete-btn').attr('type', 'button');
                $('#upload-btn').attr('type', 'hidden');
                $('#product_image_url').val(image_url);
            });
    });

    $('#delete-btn').click(function (e) {
        $('#product_image_url').val('');
        $('#delete-btn').attr('type', 'hidden');
        $('#upload-btn').attr('type', 'button');
        $('#product_img_wrapper').remove();

        e.preventDefault();
    });

    $(".meta-box-sortables").on("sortreceive", function (e, ui) {
        var itemWidth = ui.item.find('.inside').width();

        if (itemWidth > $('#product_image').width()) {
            $('#product_image').width($('#product_image').data('orig-width'));
        } else {
            $('#product_image').width(itemWidth);
        }
    });

});