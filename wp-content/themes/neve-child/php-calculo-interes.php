<?php
/**
 *  Simulador " Cálculo de Interés segun Modalidad de Ahorro"
 *
 * This is the template that displays the offers block.
 */
?>
   <?php
                require_once __DIR__ . '/vendor/autoload.php';
                require_once __DIR__ . '/simulador_paths.php';

                $objPHPExcel1 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('AHORRO-VISTA.xls'));
                $objPHPExcel2 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('FORMACION.xls'));
                
                /**  Obtener todas las celdas con datos y devolverlas en un array * */
                $sheetDataHahorroVista = $objPHPExcel1->getActiveSheet()->toArray(null, true, false, true);
                $sheetDataFormacion = $objPHPExcel2->getActiveSheet()->toArray(null, true, false, true);
               
                 //var_dump($sheetData);
            
            ?>






<div class="col_simulador_interes banco-simulador banco-simulador-interes">  

<div class="container_interes" >
    <div class="ctaform_interes">
      <h2>Modalidad de Ahorro</h2> 
      <div  class="column_inner">
      <select id="modalidad" onchange="armar_form()" class="fselect" aria-label="Modalidad de ahorro">
                     <option value="ahorro">Ahorro a la vista</option>
                    <option value="formacion">Formaci&oacute;n de fondo</option>
                    <option value="deposito">Dep&oacute;sito a plazo fijo</option>
                    <option value="certificado">Certificado de dep&oacute;sito</option>
        </select>
       </div>    
      <p class="banco-simulador-intro">Conozca el interés estimado según la modalidad de ahorro seleccionada.</p>
    </div>
        
        
        <div id="form1">
                    <div id="conten">
                        <label for="saldo">Saldo (mínimo 200)</label>
                        <input id="saldo" type="number" min="200" step="0.01" inputmode="decimal" placeholder="0.00" class="col_21">
                        <label for="tipo_moneda">Moneda</label>
                        <select id="tipo_moneda" class="col_3">
<!--                        <option selected="">Tipo de Moneda</option>-->
                        <?php
                        echo '<option value="' . esc_attr((string) $sheetDataHahorroVista[2]["A"]) . '">CUP</option>';
                        echo '<option value="' . esc_attr((string) $sheetDataHahorroVista[2]["C"]) . '">USD</option>';
                        ?>

                    </select>
                    
                  </div>
                    <label>Fecha inicio</label>
                    <div id="time_in">
                        <select id="dia_in" class="col_3">
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                if ($i == date('j'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="mes_in" class="col_3">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                if ($i == date('m'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="ano_in" class="col_3">
                            <?php
                            for ($i = (int) date('Y') + 8; $i >= 1920; $i--) {
                                if ($i == (int) date('Y'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <label>Fecha de vencimiento</label>
                    <div id="time_out">
                        <select id="dia_out" class="col_3">
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                if ($i == date('j'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="mes_out" class="col_3">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                if ($i == date('m'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="ano_out" class="col_3">
                            <?php
                            for ($i = (int) date('Y') + 8; $i >= 1920; $i--) {
                                if ($i == (int) date('Y'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button  onclick="calcularAhorro()" class="col_1">Calcular</button>
                    <label for="interes_r">Interés estimado</label>
                    <input type="text" readonly="readonly" id="interes_r" placeholder="—" class="col_1">
                    

        </div>
        <div id="form2">
                    <div class="column_inner">
                        <label for="saldo_formacion">Saldo inicial (mínimo 30)</label>
                        <input id="saldo_formacion" type="number" min="30" step="0.01" inputmode="decimal" placeholder="0.00" class="col_21">
<!--                     <label>Extracciones:</label>-->
                        <label for="modo">Modalidad del fondo</label>
                        <select id="modo" class="col_3">
                           <?php
                            echo '<option value="' . esc_attr((string) $sheetDataFormacion[2]["A"]) . '">Extracciones</option>';
                            echo '<option value="' . esc_attr((string) ($sheetDataFormacion[2]["B"] + $sheetDataFormacion[2]["A"])) . '">1 A&ntilde;o</option>';
                            echo '<option value="' . esc_attr((string) ($sheetDataFormacion[2]["C"] + $sheetDataFormacion[2]["B"] + $sheetDataFormacion[2]["A"])) . '">3 A&ntilde;o</option>';
                            ?>
                        </select>
                    </div>
                    <label>Fecha inicio</label>
                    <div id="time_in_f">
                       <select id="dia_in_f" class="col_3">
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                if ($i == date('j'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="mes_in_f" class="col_3">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                if ($i == date('m'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="ano_in_f" class="col_3">
                            <?php
                            for ($i = (int) date('Y') + 8; $i >= 1920; $i--) {
                                if ($i == (int) date('Y'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                   <label>Fecha de vencimiento</label>
                    <div id="time_out_f">
                         <select id="dia_out_f" class="col_3">
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                if ($i == date('j'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="mes_out_f" class="col_3">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                if ($i == date('m'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                        <select id="ano_out_f" class="col_3">
                            <?php
                            for ($i = (int) date('Y') + 8; $i >= 1920; $i--) {
                                if ($i == (int) date('Y'))
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                else
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button class="col_1" onclick="calcularFormacion()">Calcular</button>
                    <label for="interes_r_formacion">Interés estimado</label>
                    <input type="text" class="col_1" readonly="readonly" id="interes_r_formacion" size="10" placeholder="—">
                    

                </div>
       <div id="form3">
                    <label for="saldo_deposito">Saldo inicial</label>
                    <input id="saldo_deposito" type="number" min="100" step="0.01" inputmode="decimal" placeholder="Saldo inicial" class="col_21" aria-label="Saldo inicial">
                    <label for="tipo_moneda_deposito">Moneda</label>
                    <select id="tipo_moneda_deposito" class="col_3">
<!--                        <option selected="">Tipo de Moneda</option>-->
                        <option value="0">CUP</option>
                        <option value="1">USD</option>
                    </select>
                    <label for="meses">Plazo</label>
                    <select id="meses" class="col_1">
                        <option value="" selected disabled>Seleccione el plazo</option>
                        <option value="0">3</option>
                        <option value="1">6</option>
                        <option value="2">12</option>
                        <option value="3">24</option>
                        <option value="4">36</option>
                        <option value="5">60</option>
                        <option value="6">72</option>
                    </select>
                    <button class="col_1" onclick="calcularDeposito()">Calcular</button>
                    <label for="interes_r_deposito">Interés estimado</label>
                    <input type="text" readonly="readonly" id="interes_r_deposito" size="10" placeholder="Interés" class="col_1" aria-label="Interés estimado">
                    
       </div>
       <div id="form4">
                    <label for="saldo_certificado">Saldo inicial</label>
                    <input id="saldo_certificado" type="number" min="100" step="0.01" inputmode="decimal" placeholder="Saldo inicial" class="col_21" aria-label="Saldo inicial">
                    <label for="tipo_moneda_certificado">Moneda</label>
                    <select id="tipo_moneda_certificado" class="col_3">
<!--                        <option selected="">Tipo de Moneda</option>-->
                        <option value="0">CUP</option>
                        <option value="1">USD</option>
                    </select>
                    <label for="meses_certificado">Plazo</label>
                    <select id="meses_certificado" class="col_1">
                        <option value="" selected disabled>Seleccione el plazo</option>
                        <option value="0">3</option>
                        <option value="1">6</option>
                        <option value="2">12</option>
                        <option value="3">24</option>
                        <option value="4">36</option>
                        <option value="5">60</option>
                    </select>
                    <button onclick="calcularCertificado()" class="col_1">Calcular</button>
                    <label for="interes_r_certificado">Interés estimado</label>
                    <input type="text" readonly="readonly" id="interes_r_certificado" size="10" placeholder="Interés" class="col_1" aria-label="Interés estimado">
                    
       </div>


            
        </div>
 
</div>    
     

<script>
    // La URL se genera desde WordPress para que funcione aunque cambie la ruta de instalación.
    var interesRatesUrl = <?php echo wp_json_encode(simulador_asset_url('auxiliar.php')); ?>;

    function armar_form() {
        var forms = {
            ahorro: document.getElementById('form1'),
            formacion: document.getElementById('form2'),
            deposito: document.getElementById('form3'),
            certificado: document.getElementById('form4')
        };
        var selected = document.getElementById('modalidad').value;

        Object.keys(forms).forEach(function (key) {
            forms[key].hidden = key !== selected;
        });
    }

    function leerSaldo(id, minimo) {
        var input = document.getElementById(id);
        var saldo = Number(input.value);

        // Validar también en JavaScript, además de los atributos HTML, evita cálculos con entradas vacías o inválidas.
        if (input.value.trim() === '' || !Number.isFinite(saldo) || saldo < minimo) {
            alert('Introduzca un saldo válido igual o superior a ' + minimo + '.');
            return null;
        }

        return saldo;
    }

    function calcularDias(prefix) {
        var startYear = Number(document.getElementById('ano_in' + prefix).value);
        var startMonth = Number(document.getElementById('mes_in' + prefix).value);
        var startDay = Number(document.getElementById('dia_in' + prefix).value);
        var endYear = Number(document.getElementById('ano_out' + prefix).value);
        var endMonth = Number(document.getElementById('mes_out' + prefix).value);
        var endDay = Number(document.getElementById('dia_out' + prefix).value);
        // Los meses del selector son 1-12; Date.UTC espera meses indexados desde cero.
        var startDate = new Date(Date.UTC(startYear, startMonth - 1, startDay));
        var endDate = new Date(Date.UTC(endYear, endMonth - 1, endDay));

        // Date normaliza fechas imposibles; comparar los componentes detecta, por ejemplo, 31 de febrero.
        if (startDate.getUTCFullYear() !== startYear || startDate.getUTCMonth() !== startMonth - 1 ||
            startDate.getUTCDate() !== startDay || endDate.getUTCFullYear() !== endYear ||
            endDate.getUTCMonth() !== endMonth - 1 || endDate.getUTCDate() !== endDay) {
            alert('Seleccione fechas válidas.');
            return null;
        }

        var days = Math.floor((endDate.getTime() - startDate.getTime()) / 86400000);
        if (days < 0) {
            alert('La fecha de vencimiento no puede ser anterior a la fecha de inicio.');
            return null;
        }

        return days;
    }

    function calcularAhorro() {
        document.getElementById('interes_r').value = '';
        var saldo = leerSaldo('saldo', 200);
        if (saldo === null) {
            return;
        }
        var dias = calcularDias('');
        if (dias === null) {
            return;
        }

        var tasa = Number(document.getElementById('tipo_moneda').value);
        document.getElementById('interes_r').value = ((saldo * tasa / 100) * dias / 360).toFixed(2);
    }

    function calcularFormacion() {
        document.getElementById('interes_r_formacion').value = '';
        var saldo = leerSaldo('saldo_formacion', 30);
        if (saldo === null) {
            return;
        }
        var dias = calcularDias('_f');
        if (dias === null) {
            return;
        }

        var tasa = Number(document.getElementById('modo').value);
        document.getElementById('interes_r_formacion').value = ((saldo * tasa / 100) * dias / 360).toFixed(2);
    }

    function calcularInteresPlazo(kind) {
        var isCertificate = kind === 'certificado';
        var suffix = isCertificate ? '_certificado' : '_deposito';
        var balanceId = 'saldo' + suffix;
        var currencyId = 'tipo_moneda' + suffix;
        var termId = isCertificate ? 'meses_certificado' : 'meses';
        var resultId = 'interes_r' + suffix;
        var balance = leerSaldo(balanceId, isCertificate ? 100 : 100);
        var currency = Number(document.getElementById(currencyId).value);
        var termSelect = document.getElementById(termId);
        var termIndex = Number(termSelect.value);
        document.getElementById(resultId).value = '';

        if (balance === null) {
            return;
        }
        if (termSelect.value === '' || !Number.isInteger(termIndex)) {
            alert('Seleccione un plazo válido.');
            return;
        }
        if (currency === 1 && balance < (isCertificate ? 500 : 200)) {
            alert('El saldo mínimo para esta moneda es ' + (isCertificate ? 500 : 200) + '.');
            return;
        }

        // La misma tabla de tasas sirve para depósitos y certificados; el índice del plazo coincide con la fila del JSON.
        jQuery.getJSON(interesRatesUrl)
            .done(function (rates) {
                var row = Array.isArray(rates) ? rates[termIndex] : null;
                var rawRate = row ? row[currency] : null;
                var rate = rawRate === null || rawRate === '' ? NaN : Number(rawRate);
                var months = Number(termSelect.options[termSelect.selectedIndex].text);

                if (!Number.isFinite(rate) || rate < 0 || !Number.isFinite(months) || months <= 0) {
                    alert('No fue posible obtener la tasa para el plazo seleccionado.');
                    return;
                }

                // La hoja publica tasa anual; prorratear por meses evita tratarla como una tasa para todo el plazo.
                var interest = balance * rate / 100 * months / 12;
                document.getElementById(resultId).value = interest.toFixed(2);
            })
            .fail(function () {
                alert('No se pudieron cargar las tasas. Inténtelo nuevamente.');
            });
    }

    function calcularDeposito() {
        calcularInteresPlazo('deposito');
    }

    function calcularCertificado() {
        calcularInteresPlazo('certificado');
    }

    document.addEventListener('DOMContentLoaded', armar_form);
</script>