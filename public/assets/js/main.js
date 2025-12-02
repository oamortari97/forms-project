$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');
    
    $('#table-dt').DataTable({
        language: {
            "sEmptyTable": "Nenhum dado disponível na tabela",
            "sInfo": "Mostrando _END_ de _TOTAL_ itens",
            "sInfoEmpty": "Mostrando 0 de 0 itens",
            "sInfoFiltered": "(filtrado de _MAX_ itens no total)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Mostrar _MENU_ entradas",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sSearch": "Pesquisar:",
            "sZeroRecords": "Nenhum item encontrado",
            "oPaginate": {
                "sFirst": "Primeira",
                "sLast": "Última",
                "sNext": ">",
                "sPrevious": "<"
            },
            "oAria": {
                "sSortAscending": ": ativar para classificar a coluna em ordem crescente",
                "sSortDescending": ": ativar para classificar a coluna em ordem decrescente"
            }
        },
        pageLength: 10,
        lengthChange: false,
        layout: {
            topEnd: null,
            topStart: {
                search: {
                    placeholder: ''
                }
            }
        }
    });

    const $menuToggle = $('.menu-toggle');
    const $sidebar = $('.sidebar');
    const $backDivBar = $('.mobile-button');

    $menuToggle.on('click', function () {
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');

        $sidebar.toggleClass('d-flex');

        if ($sidebar.hasClass('d-flex')) {
            $backDivBar.css('background-color', '#f8f8f8');
        } else {
            $backDivBar.css('background-color', '#fff');
        }
    });

    $('[data-bs-toggle="tooltip"]').each(function () {
        new bootstrap.Tooltip(this);
    });

    $('#changePassword').on('click', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();
        $('#defaultModalLabel').text('Alterar senha');
        $('#modalContent').load(`${baseUrl}alterar-senha`, function (response, status, xhr) {
            if (status == "error") {
                $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
            }
        });
    });
});
