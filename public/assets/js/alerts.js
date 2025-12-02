$(document).ready(function () {
    function displayAlerts() {
        let $alertDisplay = $('#alert-display');
        let timer = '';

        if ($alertDisplay.length) {
            $('#close-alert').on('click', function () {
                closeAlert();
            });

            timer = setTimeout(function () {
                closeAlert();
            }, 4000);
        }

        function closeAlert() {
            clearTimeout(timer);
            $alertDisplay.addClass('alert-closening');

            timer = setTimeout(function () {
                $alertDisplay.hide();
            }, 1000);
        }
    }

    displayAlerts();
});