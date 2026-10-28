<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/simulador_paths.php';

$nombreMonedas = array(
    'Dólar canadiense', 'Franco suizo', 'Corona danesa', 'Euro',
    'Libra esterlina', 'Yen japonés(*)', 'Peso mexicano',
    'Corona noruega', 'Corona sueca', 'Dólar estadounidense'
);
$workbook = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('tasa-transferencia.xls'));
$rates = $workbook->getActiveSheet()->toArray(null, true, false, true);
?>
<section class="banco-simulador banco-tabla-transferencia" aria-label="Tasas de cambio para transferencias">
    <div class="banco-table-scroll">
        <table class="banco-rates-table">
            <caption>Tasas de cambio para transferencias</caption>
            <thead>
                <tr>
                    <th scope="col">Siglas</th>
                    <th scope="col">Moneda</th>
                    <th scope="col">Canje</th>
                    <th scope="col">Recanje</th>
                </tr>
            </thead>
            <tbody>
                <?php $currencyIndex = 0; ?>
                <?php foreach ($rates as $row) : ?>
                    <?php // Se omite el encabezado para alinear cada fila de tasas con su nombre de moneda. ?>
                    <?php if (!isset($row['A']) || $row['A'] === 'MONEDA') { continue; } ?>
                    <?php
                    $code = (string) $row['A'];
                    $currencyName = $nombreMonedas[$currencyIndex] ?? $code;
                    $currencyIndex++;
                    ?>
                    <tr>
                        <td data-label="Siglas"><?php echo esc_html($code); ?></td>
                        <td data-label="Moneda"><?php echo esc_html($currencyName); ?></td>
                        <td data-label="Canje"><?php echo esc_html((string) ($row['B'] ?? '')); ?></td>
                        <td data-label="Recanje"><?php echo esc_html((string) ($row['C'] ?? '')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
