document.addEventListener('DOMContentLoaded', () => {
    console.log('iniciado tudo')

    const items = document.querySelectorAll('#table-items tbody tr')
    items.forEach(item => {
        item.querySelector('.item-amount').addEventListener('change', e => {
            e.stopPropagation()

            // const amount = parseFloat(e.target.value)
            // const weight = parseFloat(e.target.closest('tr').querySelector('.item-weight').textContent)

            // totalWeight += (weight * amount)

            // console.log('peso total', totalWeight)

            const totalWeight = calculateTotalWeight(items)
            document.querySelector('#weight-total').innerHTML = totalWeight

            const addressId = document.querySelector('#address_id').value
            console.log(totalWeight > 0 && addressId != "")
            if (totalWeight > 0 && addressId != "") {
                console.log(`Peso total: ${totalWeight} -> Address ID: ${addressId}`)
                calculateShipping(totalWeight, addressId)
            }
        })
    })

    const address = document.querySelector('#address_id')
    address.addEventListener('change', e => {
        const addressId = e.target.value
        const weight = document.querySelector('#weight-total').textContent

        if (weight > 0 && addressId != "") {
            console.log(`Peso total: ${weight} -> Address ID: ${addressId}`)
            calculateShipping(weight, addressId)
        }
    })

})

const calculateTotalWeight = (items) => {
    let totalWeight = 0
    items.forEach(item => {
        const amount = parseFloat(item.querySelector('.item-amount').value)
        const weight = parseFloat(item.querySelector('.item-weight').textContent)

        totalWeight += (weight * amount)
    })
    return totalWeight
}

const calculateShipping = (weight, addressId) => {
    const paymentForm = document.querySelector('#payment_form')
    paymentForm.classList.remove('hide')
    const options = paymentForm.querySelector('#options')
    options.innerHTML = `<p class="text-center"><small>calculando o frete...</small></p>`

    // Manda pro backend calcular o frete

}