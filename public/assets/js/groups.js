$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#addGroupBtn').on('click', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();
        $('#defaultModalLabel').text('Novo grupo');
        $('#modalContent').load(`${baseUrl}admin/grupos/novo`, function (response, status, xhr) {
            if (status == "error") {
                $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.editGroupBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Editar grupo');

            var groupId = $(this).data('group-id');

            $.ajax({
                url: `${baseUrl}admin/grupos/editar`,
                type: 'POST',
                data: { grupo_id: groupId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function (xhr, status, error) {
                    $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.deleteGroupBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Excluir grupo');

            var groupId = $(this).data('group-id');

            $.ajax({
                url: `${baseUrl}admin/grupos/apagar`,
                type: 'POST',
                data: { grupo_id: groupId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function (xhr, status, error) {
                    $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
                }
            });
        });
    });
});

