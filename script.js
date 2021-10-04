$(document).ready(() => {

    $('#documentacao').on('click', () => {
        //$('#pagina').load('documentacao.html')
        $.post('documentacao.html', data => {
            $('#pagina').html(data)
        })
    })
    $('#suporte').on('click', () => {
        $('#pagina').load('suporte.html')

    })


    //ajax
    $('#competencia').on('change', e => {

        let competencia = $(e.target).val()

        $.ajax({
            type: 'GET',
            url: 'app.php',
            data: `competencia=${competencia}`, // x-www-fomr-urlencoded
            dataType: 'json',
            success: dados => {
                $('#numeroVendas').html(dados.numeroVendas)
                $('#totalVendas').html('R$ ' + dados.totalVendas)
            },
            error: erro => { console.log(erro) }
        })

        // Método, url, dados, erro
    })


})