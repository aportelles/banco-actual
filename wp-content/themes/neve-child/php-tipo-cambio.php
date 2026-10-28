<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/simulador_paths.php';

$nombreMonedas = array(
    'Dólar canadiense', 'Franco suizo', 'Corona danesa', 'Euro',
    'Libra esterlina', 'Yen japonés(*)', 'Peso mexicano',
    'Corona noruega', 'Corona sueca', 'Dólar estadounidense'
);

$rateSheets = array(
    'sucursal' => array(
        'label' => 'Cambio de efectivo en sucursal',
        'file' => 'tasa-sucursales.xls',
    ),
    'transferencia' => array(
        'label' => 'Cambio para transferencia',
        'file' => 'tasa-transferencia.xls',
    ),
    'mlc' => array(
        'label' => 'Depósito y extracción de efectivo MLC en cuentas MLC',
        'file' => 'tasa-MLC.xls',
    ),
);

// Cargar las tres hojas una vez permite reutilizar el mismo renderizado de tabla en cada pestaña.
foreach ($rateSheets as $key => $sheet) {
    $workbook = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path($sheet['file']));
    $rateSheets[$key]['rows'] = $workbook->getActiveSheet()->toArray(null, true, false, true);
}
?>
<section class="banco-simulador banco-tipo-cambio" aria-label="Tasas de cambio">
    <div class="banco-tabs" role="tablist" aria-label="Modalidad del tipo de cambio">
        <?php foreach ($rateSheets as $key => $sheet) : ?>
            <button type="button"
                    class="banco-tab-button<?php echo $key === 'sucursal' ? ' is-active' : ''; ?>"
                    id="tasa-tab-<?php echo esc_attr($key); ?>"
                    role="tab"
                    aria-selected="<?php echo $key === 'sucursal' ? 'true' : 'false'; ?>"
                    aria-controls="tasa-panel-<?php echo esc_attr($key); ?>"
                    onclick="cambiarPestanaTasa('<?php echo esc_attr($key); ?>')">
                <?php echo esc_html($sheet['label']); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <?php foreach ($rateSheets as $key => $sheet) : ?>
        <div class="banco-tab-panel" id="tasa-panel-<?php echo esc_attr($key); ?>"
             role="tabpanel" aria-labelledby="tasa-tab-<?php echo esc_attr($key); ?>"
             <?php echo $key === 'sucursal' ? '' : 'hidden'; ?>>
            <div class="banco-table-scroll">
                <table class="banco-rates-table">
                    <caption><?php echo esc_html($sheet['label']); ?></caption>
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
                        <?php foreach ($sheet['rows'] as $row) : ?>
                            <?php // Las filas sin código o con el encabezado no son tasas publicables. ?>
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
        </div>
    <?php endforeach; ?>

    <p class="banco-simulador-note">(*) CUP entre yen japonés. (**) Algunas tasas pueden no incluir margen comercial.</p>
</section>

<script>
    function cambiarPestanaTasa(name) {
        document.querySelectorAll('.banco-tipo-cambio [role="tabpanel"]').forEach(function (panel) {
            panel.hidden = panel.id !== 'tasa-panel-' + name;
        });
        document.querySelectorAll('.banco-tipo-cambio [role="tab"]').forEach(function (tab) {
            var active = tab.id === 'tasa-tab-' + name;
            tab.classList.toggle('is-active', active);
            tab.setAttribute('aria-selected', String(active));
        });
    }
</script>
