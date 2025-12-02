$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#addUserBtn').on('click', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();
        $('#defaultModalLabel').text('Novo usuário');
        $('#modalContent').load(`${baseUrl}admin/usuarios/novo`, function (response, status, xhr) {
            if (status == "error") {
                $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.editUserBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Editar usuário');

            var userId = $(this).data('user-id');

            $.ajax({
                url: `${baseUrl}admin/usuarios/editar`,
                type: 'POST',
                data: { usuario_id: userId },
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
        $(document).on('click', '.deleteUserBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Excluir usuário');

            var userId = $(this).data('user-id');

            $.ajax({
                url: `${baseUrl}admin/usuarios/apagar`,
                type: 'POST',
                data: { usuario_id: userId },
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
        $(document).on('click', '.toggleUserBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Alterar usuário');

            var userId = $(this).data('user-id');
            var value = $(this).data('user-value');

            $.ajax({
                url: `${baseUrl}admin/usuarios/toggle`,
                type: 'POST',
                data: { usuario_id: userId, valor: value },
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

