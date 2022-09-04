document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#postal_code').addEventListener('keyup', (e) => {
        e.stopPropagation()
        if (e.target.value.length == 9) {
            console.log('buscar o cep', e.target.value)

            getAddressByPostalCode(e.target.value)
        }
    })
})

function getAddressByPostalCode(postal_code) {
    const fields = [
        { 'formField': 'street', 'apiField': 'logradouro' },
        { 'formField': 'city', 'apiField': 'localidade' },
        { 'formField': 'district', 'apiField': 'bairro' },
        { 'formField': 'state', 'apiField': 'uf' },
    ]

    fetch (`https://viacep.com.br/ws/${postal_code}/json/`)
        .then(res => res.json())
        .then(data => {
            fields.forEach(field => document.querySelector(`#${field['formField']}`).value = data[field['apiField']])
            document.querySelector('#number').focus()
        })
        .catch(e => console.log('erro ao carregar os dados', e))

}