<?php
require_once __DIR__ . '/simulador_paths.php';
require_once __DIR__ . '/vendor/autoload.php';

$uploadMessage = '';
$uploadMessageType = 'error';
// Solo los administradores pueden reemplazar hojas que alimentan los simuladores públicos.
$canUploadRates = function_exists('current_user_can') && current_user_can('manage_options');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$canUploadRates) {
        $uploadMessage = 'No tiene permisos para actualizar las tasas.';
    } elseif (
        // El nonce impide aceptar formularios de carga originados desde una página externa.
        !isset($_POST['simulador_upload_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['simulador_upload_nonce'])), 'simulador_upload_rates')
    ) {
        $uploadMessage = 'La solicitud no pudo validarse. Recargue la página e inténtelo nuevamente.';
    } elseif (
        !isset($_FILES['myfile']) ||
        !is_array($_FILES['myfile']) ||
        !isset($_FILES['myfile']['error'], $_FILES['myfile']['name'], $_FILES['myfile']['tmp_name'], $_FILES['myfile']['size'])
    ) {
        $uploadMessage = 'Seleccione un archivo XLS para continuar.';
    } elseif ((int) $_FILES['myfile']['error'] !== UPLOAD_ERR_OK) {
        $uploadMessage = 'No se pudo recibir el archivo. Verifique el tamaño e inténtelo nuevamente.';
    } else {
        $uploadedFile = $_FILES['myfile'];
        $filename = sanitize_file_name(wp_unslash($uploadedFile['name']));
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $maxUploadSize = 10 * 1024 * 1024;

        if (
            $filename === '' ||
            !preg_match('/\A[a-zA-Z0-9][a-zA-Z0-9._-]*\.xls\z/i', $filename) ||
            $extension !== 'xls'
        ) {
            $uploadMessage = 'Solo se permiten archivos con extensión .xls y un nombre válido.';
        } elseif ((int) $uploadedFile['size'] > $maxUploadSize) {
            $uploadMessage = 'El archivo supera el tamaño máximo permitido de 10 MB.';
        } elseif (!is_uploaded_file($uploadedFile['tmp_name'])) {
            $uploadMessage = 'El archivo recibido no es una carga válida.';
        } else {
            // La extensión por sí sola no valida el archivo: se comprueba el formato real antes de guardarlo.
            try {
                $fileFormat = \PhpOffice\PhpSpreadsheet\IOFactory::identify($uploadedFile['tmp_name']);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $exception) {
                $fileFormat = '';
            }

            if ($fileFormat !== 'Xls') {
                $uploadMessage = 'El archivo no es una hoja de cálculo XLS válida.';
            } else {
                // El destino se limita a la carpeta de cargas de WordPress; el nombre se saneó previamente.
                $destination = simulador_upload_path($filename);
                if (!move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
                    $uploadMessage = 'No se pudo guardar el archivo. Verifique los permisos de la carpeta de cargas.';
                } else {
                    $uploadMessage = 'El archivo ' . $filename . ' se cargó correctamente.';
                    $uploadMessageType = 'success';
                }
            }
        }
    }
}
?>
<section class="banco-simulador banco-upload" aria-labelledby="titulo-subir-archivo">
    <h2 id="titulo-subir-archivo">Actualizar archivo de tasas</h2>
    <p class="banco-simulador-intro">Seleccione el archivo Excel que desea actualizar. Solo se admiten archivos .xls de hasta 10 MB.</p>

    <?php if ($uploadMessage !== '') : ?>
        <p class="banco-upload-notice banco-upload-notice-<?php echo esc_attr($uploadMessageType); ?>" role="status">
            <?php echo esc_html($uploadMessage); ?>
        </p>
    <?php endif; ?>

    <?php if ($canUploadRates) : ?>
        <form method="post" enctype="multipart/form-data" class="banco-upload-form">
            <?php wp_nonce_field('simulador_upload_rates', 'simulador_upload_nonce'); ?>
            <label for="myfile">Archivo XLS</label>
            <input type="file" id="myfile" name="myfile" accept=".xls,application/vnd.ms-excel" required>
            <button type="submit">Cargar archivo</button>
        </form>
    <?php else : ?>
        <p class="banco-simulador-status">Debe iniciar sesión como administrador para actualizar las tasas.</p>
    <?php endif; ?>
</section>
