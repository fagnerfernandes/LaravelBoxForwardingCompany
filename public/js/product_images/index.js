$(function () {
    var productId = $('#product_id').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $('#fileuploader').uploadFile({
        url: '/product-images/' + productId,
        multiple: true,
        method: 'POST',
        enctype: 'multipart/form-data',
        fileName: "image",
        showPreview: true,
        previewHeight: "100px",
        previewWidth: "100px",
        returnType: "json",
        afterUploadAll: function (response) {
            $('.ajax-file-upload-container').empty();
            window.location.reload();
            /* if (imageReloadPage === true) {
                console.log('resposta', response.responses[0].image);
                addNewImageBox(response.responses[0].image);
            } else $('#image-list').load(APP + '/admin/images/'+ productId +' #image-list'); */
        }
    });
});
