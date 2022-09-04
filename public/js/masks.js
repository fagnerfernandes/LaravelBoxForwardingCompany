$(function() {
    $('.date').mask('00/00/0000');
    $('.hour').mask('00:00');
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.telefone').mask('(00) 0000-0000');
    $('.money').mask('000.000.000.000.000,00', { reverse: true });

    // Marcara de CPF/CNPJ
    var CpfCnpjMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
    },
        cpfCnpjOptions = {
            onKeyPress: function(val, e, field, options) {
            field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
        }
    };
    $('.cpf-cnpj').mask(CpfCnpjMaskBehavior, cpfCnpjOptions);

    // Marcara de Telefone Fixo/Movel
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.celular').mask(SPMaskBehavior, spOptions);
});
