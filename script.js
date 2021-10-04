$(document).ready(() => {

    $('#documentacao').on('click', () => {
        //$('#pagina').load('documentacao.html')
        $.post('documentacao.html', data => {
            $('#pagina').html(data)
        })
    })
    $('#suporte').on('click', () => {
        //$('#pagina').load('suporte.html')

    })


})