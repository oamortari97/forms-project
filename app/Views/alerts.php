<?php if (null !== (session()->get('alerta')) && !empty(session()->get('alerta'))) {
    echo session()->get('alerta');
    session()->remove('alerta');
}
?>

<script src="<?= base_url('assets/js/alerts.js') ?>"></script>