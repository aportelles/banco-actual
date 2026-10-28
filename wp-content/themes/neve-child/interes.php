<html>
    <head>
        <script type="text/javascript" src="jquery-3.1.1.min.js"></script>
    </head>
    <body>
        <?php
        require_once __DIR__ . '/vendor/autoload.php';
        require_once __DIR__ . '/simulador_paths.php';

        $objPHPExcel1 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('AHORRO-VISTA.xls'));
        $objPHPExcel2 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('FORMACION.xls'));
        /**  Obtener todas las celdas con datos y devolverlas en un array * */
        $sheetDataHahorroVista = $objPHPExcel1->getActiveSheet()->toArray(null, true, false, true);
        $sheetDataFormacion = $objPHPExcel2->getActiveSheet()->toArray(null, true, false, true);

       
        ?>
        <div id="c_interes" align="center" onloadstart="armar_form()">
            <label>Selecione la Modalidad de Ahorro</label>
            <select id="modalidad" onchange="armar_form()">
                <option value="ahorro">Ahorro a la Vista</option>
                <option value="formacion">Formaci&oacute;n de Fondo</option>
                <option value="deposito">Dep&oacute;sito a Plazo Fijo</option>
                <option value="certificado">Cerificado de Dep&oacute;sito</option>
            </select>
            <div id="form1" style="width: 400px;">
                <div id="conten">
                    <div id="left_conten">
                        <label>Saldo</label>
                        <input id="saldo" type="text" draggable="0" size="10">
                    </div>
                    <div id="rigth_conten" >
                        <label>Tipo de Moneda</label>
                        <select id="tipo_moneda">
                            <?php
                            echo '<option value="' . $sheetDataHahorroVista[2]["A"] . '">CUP</option>';
                            echo '<option value="' . $sheetDataHahorroVista[2]["B"] . '">CUC</option>';
                            echo '<option value="' . $sheetDataHahorroVista[2]["C"] . '">USD</option>';
                            ?>
                        </select>
                    </div>

                </div>
                <label>Fecha Inicio</label>
                <div id="time_in">
                    <select id="dia_in_a">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            if ($i == date('j'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="mes_in_a">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i == date('m'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="ano_in_a">
                        <?php
                        for ($i = date('o'); $i >= 1910; $i--) {
                            if ($i == date('o'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>

                </div>
                <label>Fecha Fin</label>
                <div id="time_out">
                    <select id="dia_out_a">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            if ($i == date('j'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="mes_out_a">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i == date('m'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="ano_out_a">
                        <?php
                        for ($i = date('o'); $i >= 1910; $i--) {
                            if ($i == date('o'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <label>Resultado</label>
                <input type="text" id="interes_r" size="10">
                <button onclick="calcularAhorro()">Calcular</button>

            </div>
            <div id="form2" style="width: 400px;">
                <div id="left_conten">
                    <label>Saldo</label>
                    <input id="saldo_formacion" type="text" draggable="0" size="10">
                </div>
                <div id="rigth_conten" >
                    <label>No realizar extraci&oacute;n en:</label>
                    <select id="modo">
                        <?php
                        echo '<option value="' . $sheetDataFormacion[2]["A"] . '">Ninguno..</option>';
                        echo '<option value="' . ($sheetDataFormacion[2]["B"] + $sheetDataFormacion[2]["A"]) . '">1 A&ntilde;o</option>';
                        echo '<option value="' . ($sheetDataFormacion[2]["C"] + $sheetDataFormacion[2]["B"] + $sheetDataFormacion[2]["A"]) . '">3 A&ntilde;o</option>';
                        ?>

                    </select>
                </div>
                <label>Fecha Inicio</label>
                <div id="time_in">
                    <select id="dia_in">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            if ($i == date('j'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="mes_in">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i == date('m'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="ano_in">
                        <?php
                        for ($i = date('o'); $i >= 1910; $i--) {
                            if ($i == date('o'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>

                </div>
                <label>Fecha Fin</label>
                <div id="time_out">
                    <select id="dia_out">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            if ($i == date('j'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="mes_out">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i == date('m'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select id="ano_out">
                        <?php
                        for ($i = date('o'); $i >= 1910; $i--) {
                            if ($i == date('o'))
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            else
                                echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <label>Resultado</label>
                <input type="text" id="interes_r_formacion" size="10">
                <button onclick="calcularFormacion()">Calcular</button>

            </div>
            <div id="form3" style="width: 400px;">
                <label>Saldo</label>
                <input id="saldo_deposito" type="text" draggable="0" size="10">
                <label>Tipo de moneda</label>
                <select id="tipo_moneda_deposito">
                    <option value="0">CUP</option>
                    <option value="1">CUC</option>
                    <option value="2">USD</option>
                </select>
                <label>Plazo en meses</label>
                <select id="meses">
                    <option value="0">3</option>
                    <option value="1">6</option>
                    <option value="2">12</option>
                    <option value="3">24</option>
                    <option value="4">36</option>
                    <option value="5">60</option>
                    <option value="6">72</option>
                </select>
                <label>Resultado</label>
                <input type="text" id="interes_r_deposito" size="10">
                <button onclick="calcularDeposito()">Calcular</button>
            </div>
            <div id="form4" style="width: 400px;">
                <label>Saldo</label>
                <input id="saldo_certificado" type="text" draggable="0" size="10">
                <label>Tipo de moneda</label>
                <select id="tipo_moneda_certificado">
                    <option value="0">CUP</option>
                    <option value="1">CUC</option>
                    <option value="2">USD</option>
                </select>
                <label>Plazo en meses</label>
                <select id="meses_certificado">
                    <option value="0">3</option>
                    <option value="1">6</option>
                    <option value="2">12</option>
                    <option value="3">24</option>
                    <option value="4">36</option>
                    <option value="5">60</option>
                </select>
                <label>Resultado</label>
                <input type="text" id="interes_r_certificado" size="10">
                <button onclick="calcularCertificado()">Calcular</button>
            </div>


        </div>
    </div>
</body>
<script>
    window.onload = armar_form;
    function armar_form() {
        var form1 = document.getElementById('form1');
        var form2 = document.getElementById('form2');
        var form3 = document.getElementById('form3');
        var form4 = document.getElementById('form4');
        switch (document.getElementById('modalidad').value) {
            case "ahorro":
                form1.hidden = false;
                form2.hidden = true;
                form3.hidden = true;
                form4.hidden = true;
                break;
            case "formacion":
                form1.hidden = true;
                form2.hidden = false;
                form3.hidden = true;
                form4.hidden = true;
                break;
            case "deposito":
                form1.hidden = true;
                form2.hidden = true;
                form3.hidden = false;
                form4.hidden = true;
                break;
            case "certificado":
                form1.hidden = true;
                form2.hidden = true;
                form3.hidden = true;
                form4.hidden = false;
                break;

            default:

                break;
        }
    }

    function calcularAhorro() {
        var saldo = parseFloat(document.getElementById('saldo').value);
        if (saldo >= 400) {
            var horas = Date.UTC(document.getElementById('ano_out_a').value, document.getElementById('mes_out_a').value, document.getElementById('dia_out_a').value) - Date.UTC(document.getElementById('ano_in_a').value, document.getElementById('mes_in_a').value, document.getElementById('dia_in_a').value);
            var dias = Math.floor(horas / (1000 * 60 * 60 * 24));
            var tasa = (saldo * document.getElementById('tipo_moneda').value) / 100;
            var result = (dias * tasa) / 360;
            var re = document.getElementById('interes_r');
            re.setAttribute("value", result.toFixed(5));
        } else {
            alert("El saldo debe ser mayo que 400.");
        }
    }

    function calcularFormacion() {
        var saldo = parseFloat(document.getElementById('saldo_formacion').value);
        if (saldo >= 30) {
            var horas = Date.UTC(document.getElementById('ano_out').value, document.getElementById('mes_out').value, document.getElementById('dia_out').value) - Date.UTC(document.getElementById('ano_in').value, document.getElementById('mes_in').value, document.getElementById('dia_in').value);
            var dias = Math.floor(horas / (1000 * 60 * 60 * 24));
            var tasa = (saldo * document.getElementById('modo').value) / 100;
            var result = (dias * tasa) / 360;
            var re = document.getElementById('interes_r_formacion');
            re.setAttribute("value", result.toFixed(5));
        } else {
            alert("El saldo debe ser mayo que 30.");
        }
    }

    function calcularDeposito() {
        var matriz_deposito;
        $.post("auxiliar.php", function (data) {
            matriz_deposito = JSON.parse(data);
            var tipo_moneda = document.getElementById('tipo_moneda_deposito').options[document.getElementById('tipo_moneda_deposito').selectedIndex].text;
            var saldo = parseFloat(document.getElementById('saldo_deposito').value);
            if (tipo_moneda === "CUP") {
                if (saldo >= 100) {
                    var meses = parseInt(document.getElementById('meses').options[document.getElementById('meses').selectedIndex].text);
                    var dias = meses * 30;

                    var tasa = (saldo * matriz_deposito[parseInt(document.getElementById('meses').value)][parseInt(document.getElementById('tipo_moneda_deposito').value)]) / 100;
                    document.getElementById('interes_r_deposito').value = (dias * tasa) / 360;
                } else {
                    alert("En el caso del CUP el monto minimo inicial es de 100.");
                }
            } else {
                if (saldo >= 200) {
                    var meses = parseInt(document.getElementById('meses').options[document.getElementById('meses').selectedIndex].text);
                    var dias = meses * 30;
                    var tasa = (saldo * matriz_deposito[parseInt(document.getElementById('meses').value)][parseInt(document.getElementById('tipo_moneda_deposito').value)]) / 100;
                    document.getElementById('interes_r_deposito').value = (dias * tasa) / 360;

                } else {
                    alert("En el caso del CUC y USD el monto minimo inicial es de 200");
                }

            }


        });


    }

    function calcularCertificado() {
        var matriz_certificado;
        $.post("auxiliar.php", function (data) {
            matriz_certificado = JSON.parse(data);
            var tipo_moneda = document.getElementById('tipo_moneda_certificado').options[document.getElementById('tipo_moneda_certificado').selectedIndex].text;
            var saldo = parseFloat(document.getElementById('saldo_certificado').value);
            if (tipo_moneda === "CUP") {
                if (saldo >= 100) {
                    var meses = parseInt(document.getElementById('meses_certificado').options[document.getElementById('meses_certificado').selectedIndex].text);
                    var dias = meses * 30;
                    var tasa = (saldo * matriz_certificado[parseInt(document.getElementById('meses_certificado').value)][parseInt(document.getElementById('tipo_moneda_certificado').value)]) / 100;
                    document.getElementById('interes_r_certificado').value = (dias * tasa) / 360;
                } else {
                    alert("En el caso del CUP el monto minimo inicial es de 100.");
                }
            } else {
                if (saldo >= 500) {
                    var meses = parseInt(document.getElementById('meses_certificado').options[document.getElementById('meses_certificado').selectedIndex].text);
                    var dias = meses * 30;
                    var tasa = (saldo * matriz_certificado[parseInt(document.getElementById('meses_certificado').value)][parseInt(document.getElementById('tipo_moneda_certificado').value)]) / 100;
                    document.getElementById('interes_r_certificado').value = (dias * tasa) / 360;

                } else {
                    alert("En el caso del CUC y USD el monto minimo inicial es de 500");
                }

            }

        });


    }

</script>

</html>
