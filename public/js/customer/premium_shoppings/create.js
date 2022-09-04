$(function() {
    $('.item').on('change', function() {
        const item = $(this)
        const packageItemId = item.val()
        const quantity = item.attr('data-amount')

        console.log(`Item: ${packageItemId}\nQuantity: ${quantity}`)

        $('#quantity').val('1').attr('max', quantity)
    })

    $('#premium_service_id').on('change', function() {
        if ($(this).val() == "") return;

        const description = $('#service_description')
        const descriptionService = $('#service_description_info')

        const info = JSON.parse($('#premium_service_id option:selected').attr('data-info'))
        console.log('Info', info)

        descriptionService.html(info.description)

        $('#need_description').addClass('d-none').find('textarea').attr('disabled', true)
        if (info.need_description == 1) $('#need_description').removeClass('d-none').find('textarea').removeAttr('disabled').val('')
    })
})
