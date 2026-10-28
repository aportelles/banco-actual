<?php
require_once __DIR__ . '/simulador_paths.php';
?>
<section class="banco-simulador banco-simulador-credito" aria-labelledby="titulo-simulador-credito">
    <h2 id="titulo-simulador-credito">Simulador de crédito al consumo</h2>
    <p class="banco-simulador-intro">Estime el plazo, la cuota mensual y el total a pagar según el importe solicitado.</p>

    <div class="banco-simulador-grid">
        <div class="banco-simulador-panel">
            <label for="importe_credito">¿Qué importe necesita?</label>
            <div class="banco-simulador-control">
                <input id="importe_credito" type="number" min="1000" max="100000" step="1" inputmode="numeric" placeholder="Entre 1 000 y 100 000" required>
                <button type="button" onclick="calcularCredito()">Calcular</button>
            </div>
            <p class="banco-simulador-help">Importe mínimo: 1 000. Importe máximo: 100 000.</p>
            <p id="credito_estado" class="banco-simulador-status" role="status" aria-live="polite"></p>
        </div>

        <div class="banco-simulador-results" aria-live="polite">
            <div class="banco-simulador-result">
                <span>Plazo</span>
                <output id="meses_credito">—</output>
                <span>meses</span>
            </div>
            <div class="banco-simulador-result">
                <span>Cuota mensual estimada</span>
                <output id="cuota_consumo">—</output>
            </div>
            <div class="banco-simulador-result banco-simulador-result-primary">
                <span>Total a pagar estimado</span>
                <output id="interes_credito">—</output>
            </div>
        </div>
    </div>

    <p class="banco-simulador-disclaimer">Este simulador es orientativo. El otorgamiento y las condiciones definitivas del crédito se confirman en las sucursales.</p>
</section>

<script>
    // Evita depender de rutas relativas al directorio de la página.
    var creditoRatesUrl = <?php echo wp_json_encode(simulador_asset_url('auxiliar1.php')); ?>;

    function calcularCredito() {
        var input = document.getElementById('importe_credito');
        var amount = Number(input.value);
        var status = document.getElementById('credito_estado');
        var monthsOutput = document.getElementById('meses_credito');
        var monthlyOutput = document.getElementById('cuota_consumo');
        var totalOutput = document.getElementById('interes_credito');

        monthsOutput.value = '—';
        monthlyOutput.value = '—';
        totalOutput.value = '—';
        status.textContent = '';

        if (!input.value || !Number.isFinite(amount) || amount < 1000 || amount > 100000) {
            status.textContent = 'Introduzca un importe entre 1 000 y 100 000.';
            input.focus();
            return;
        }

        // Los tramos y plazos conservan la tabla de condiciones del simulador original.
        var months = amount <= 5000 ? 36 :
            amount <= 10000 ? 48 :
            amount <= 20000 ? 60 :
            amount <= 50000 ? 72 : 120;

        jQuery.getJSON(creditoRatesUrl)
            .done(function (rates) {
                if (!Array.isArray(rates)) {
                    status.textContent = 'La tabla de tasas recibida no tiene el formato esperado.';
                    return;
                }

                var rateRow = rates.find(function (row) {
                    return Array.isArray(row) && Number(row[0]) === months;
                });
                var annualRate = rateRow ? Number(rateRow[1]) : NaN;

                if (!Number.isFinite(annualRate) || annualRate < 0) {
                    status.textContent = 'No hay una tasa válida para el plazo seleccionado.';
                    return;
                }

                var monthlyPayment = calcularCuota(amount, months, annualRate);
                if (!Number.isFinite(monthlyPayment)) {
                    status.textContent = 'No se pudo calcular la cuota. Verifique la tasa configurada.';
                    return;
                }

                monthsOutput.value = String(months);
                monthlyOutput.value = monthlyPayment.toFixed(2);
                totalOutput.value = (monthlyPayment * months).toFixed(2);
            })
            .fail(function () {
                status.textContent = 'No se pudieron cargar las tasas. Inténtelo nuevamente.';
            });
    }

    function calcularCuota(principal, periods, annualRate) {
        // La hoja contiene una tasa anual; la fórmula de cuota requiere una tasa mensual.
        var monthlyRate = annualRate / 100 / 12;
        if (monthlyRate === 0) {
            return principal / periods;
        }

        var factor = Math.pow(1 + monthlyRate, periods);
        return principal * monthlyRate * factor / (factor - 1);
    }
</script>
