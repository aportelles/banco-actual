<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/simulador_paths.php';

$nombreMonedas = array(
    'Dólar canadiense', 'Franco suizo', 'Corona danesa', 'Euro',
    'Libra esterlina', 'Yen japonés(*)', 'Peso mexicano',
    'Corona noruega', 'Corona sueca', 'Dólar estadounidense'
);
$workbook = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('tasa-sucursales.xls'));
$rates = $workbook->getActiveSheet()->toArray(null, true, false, true);
// Se excluye la fila de encabezado para que el índice coincida con el nombre de cada moneda.
$currencyRows = array_values(array_filter($rates, function ($row) {
    return isset($row['A']) && $row['A'] !== 'MONEDA';
}));
?>
<section class="banco-simulador banco-simulador-canje" aria-label="Simulador de canje y recanje de monedas">
    <div class="banco-tabs" role="tablist" aria-label="Operación de cambio">
        <button type="button" class="banco-tab-button is-active" role="tab" aria-selected="true" aria-controls="canje-panel" id="canje-tab" onclick="cambiarPestanaMoneda('canje')">Canje</button>
        <button type="button" class="banco-tab-button" role="tab" aria-selected="false" aria-controls="recanje-panel" id="recanje-tab" onclick="cambiarPestanaMoneda('recanje')">Recanje</button>
    </div>

    <div id="canje-panel" class="banco-tab-panel" role="tabpanel" aria-labelledby="canje-tab">
        <h2>Canje de monedas</h2>
        <p class="banco-simulador-intro">Conozca el equivalente aproximado en CUP.</p>
        <div class="banco-conversion-row">
            <div class="banco-simulador-field">
                <label for="moneda_canje">Divisa que tiene</label>
                <select id="moneda_canje" onchange="calcularCanje()" required>
                    <option value="">Seleccione una divisa</option>
                    <?php foreach ($currencyRows as $index => $row) :
                        $code = (string) $row['A'];
                        $name = $nombreMonedas[$index] ?? $code;
                        $rate = isset($row['B']) && is_numeric($row['B']) ? (float) $row['B'] : '';
                    ?>
                        <option value="<?php echo esc_attr((string) $rate); ?>"><?php echo esc_html($name . ' (' . $code . ')'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="banco-simulador-field">
                <label for="cant_canje">Cantidad</label>
                <input type="number" id="cant_canje" min="0" step="0.01" inputmode="decimal" placeholder="0.00" oninput="calcularCanje()">
            </div>
            <div class="banco-conversion-equals" aria-hidden="true">=</div>
            <div class="banco-simulador-field">
                <label for="resultado_canje">Equivalente en CUP</label>
                <output id="resultado_canje">—</output>
            </div>
        </div>
        <p id="canje_estado" class="banco-simulador-status" role="status" aria-live="polite"></p>
    </div>

    <div id="recanje-panel" class="banco-tab-panel" role="tabpanel" aria-labelledby="recanje-tab" hidden>
        <h2>Recanje de monedas</h2>
        <p class="banco-simulador-intro">Calcule el equivalente aproximado de CUP en la divisa seleccionada.</p>
        <div class="banco-conversion-row">
            <div class="banco-simulador-field">
                <label for="moneda_recanje">Divisa que desea recibir</label>
                <select id="moneda_recanje" onchange="calcularRecanje()" required>
                    <option value="">Seleccione una divisa</option>
                    <?php foreach ($currencyRows as $index => $row) :
                        $code = (string) $row['A'];
                        $name = $nombreMonedas[$index] ?? $code;
                        $rate = isset($row['C']) && is_numeric($row['C']) ? (float) $row['C'] : '';
                    ?>
                        <option value="<?php echo esc_attr((string) $rate); ?>"><?php echo esc_html($name . ' (' . $code . ')'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="banco-simulador-field">
                <label for="cant_recanje">Cantidad en CUP</label>
                <input type="number" id="cant_recanje" min="0" step="0.01" inputmode="decimal" placeholder="0.00" oninput="calcularRecanje()">
            </div>
            <div class="banco-conversion-equals" aria-hidden="true">=</div>
            <div class="banco-simulador-field">
                <label for="resultado_recanje">Equivalente en divisa</label>
                <output id="resultado_recanje">—</output>
            </div>
        </div>
        <p id="recanje_estado" class="banco-simulador-status" role="status" aria-live="polite"></p>
    </div>

    <p class="banco-simulador-note">(*) Consulte las observaciones aplicables a las tasas publicadas.</p>
</section>

<script>
    function cambiarPestanaMoneda(name) {
        var canje = name === 'canje';
        document.getElementById('canje-panel').hidden = !canje;
        document.getElementById('recanje-panel').hidden = canje;
        document.getElementById('canje-tab').classList.toggle('is-active', canje);
        document.getElementById('recanje-tab').classList.toggle('is-active', !canje);
        document.getElementById('canje-tab').setAttribute('aria-selected', String(canje));
        document.getElementById('recanje-tab').setAttribute('aria-selected', String(!canje));
    }

    function convertirMoneda(amountId, rateId, resultId, statusId, divide) {
        var amountInput = document.getElementById(amountId);
        var rate = Number(document.getElementById(rateId).value);
        var result = document.getElementById(resultId);
        var status = document.getElementById(statusId);
        var amount = Number(amountInput.value);

        result.textContent = '—';
        status.textContent = '';
        if (!amountInput.value || !Number.isFinite(amount) || amount <= 0) {
            if (amountInput.value) {
                status.textContent = 'Introduzca una cantidad mayor que cero.';
            }
            return;
        }
        if (!Number.isFinite(rate) || rate <= 0) {
            status.textContent = 'Seleccione una divisa con una tasa válida.';
            return;
        }

        // Canje multiplica por la tasa; recanje convierte CUP a divisa dividiendo por la tasa de recanje.
        var converted = divide ? amount / rate : amount * rate;
        result.textContent = Number.isFinite(converted) ? converted.toFixed(2) : '—';
    }

    function calcularCanje() {
        convertirMoneda('cant_canje', 'moneda_canje', 'resultado_canje', 'canje_estado', false);
    }

    function calcularRecanje() {
        convertirMoneda('cant_recanje', 'moneda_recanje', 'resultado_recanje', 'recanje_estado', true);
    }
</script>
