<?php
require 'application_installer_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Instalar</title>
    <link rel="shortcut icon" type="image/x-icon" href="../storage/icon/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../ui/theme/ibilling/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../ui/theme/ibilling/lib/fa/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../ui/theme/ibilling/lib/icheck/skins/all.css" rel="stylesheet">
    <link href="../../ui/lib/css/animate.css" rel="stylesheet">
    <link href="../../ui/lib/toggle/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="../../ui/theme/ibilling/css/style.css?ver=2.0.1" rel="stylesheet">
    <link href="../../ui/theme/ibilling/css/component.css?ver=2.0.1" rel="stylesheet">
    <link href="../../ui/theme/ibilling/css/custom.css" rel="stylesheet">
    <link href="../../ui/lib/icons/css/ibilling_icons.css" rel="stylesheet">
    <link href="../../ui/theme/ibilling/css/material.css" rel="stylesheet">
    <link type='text/css' href='style.css' rel='stylesheet'/>

</head>
<body style='background-color: #FBFBFB;'>
<div id='main-container'>
    <div class='header'>
        <div class="header-box wrapper">
            <div class="hd-logo"><a href="#"><img src="../storage/system/logo.png" alt="Logo"/></a></div>
        </div>

    </div>
    <!--  contents area start  -->
    <div class="col-md-12">
       <hr>
        <?php
        $passed = '';
        $ltext = '';
        if (version_compare(PHP_VERSION, '7.1.3') >= 0) {
            $ltext .=
                'Para rodar' .
                'o script' .
                ' voce precisa de no minimo a versao do PHP 7.1.3, a sua versao do PHP e: ' .
                PHP_VERSION .
                " Testado <strong>---PASSOU---</strong><br/>";
            $passed .= '1';
        } else {
            $ltext .=
                'Para rodar' .
                'o script' .
                ' voce precisa de no minimo a versao do PHP 7.1.3, a sua versao do PHP e: ' .
                PHP_VERSION .
                " Testado <strong>---FALHOU---</strong><br/>";
            $passed .= '0';
        }

        if (extension_loaded('PDO')) {
            $ltext .=
                'PDO está ativo: ' .
                "Testado <strong>---PASSOU---</strong><br/>";
            $passed .= '1';
        } else {
            $ltext =
                'PDO nao esta ativo: ' .
                "Testado <strong>---FALHOU---</strong><br/>";
            $passed .= '0';
        }

        if (extension_loaded('pdo_mysql')) {
            $ltext .=
                'PDO MySQL driver esta ativo: ' .
                "Testado <strong>---PASSOU---</strong><br/>";
            $passed .= '1';
        } else {
            $ltext .=
                'PDO MySQL driver nao esta ativo: ' .
                "Testadoo <strong>---FALHOU---</strong><br/>";
            $passed .= '0';
        }
        if ($passed == '111') {
            echo "<br/> $ltext <br/> OTIMO! Teste do sistema completo. Voce pode rodar o script no seu servidor. Clique em contiuar.
 <br><br>
 <a href=\"step3.php\" class=\"btn btn-primary\">Continuar</a> 
 ";
        } else {
            echo "<br/> $ltext <br/> Deu Ruim. Os requerimentos para rodar o script não estão disponíveis no seu servidor, verifique os requisitos faltantes e habilites e tente novamente.
 ";
        }
        ?>
    </div>


    <!--  contents area end  -->
</div>

<script src="../../ui/theme/ibilling/js/jquery-1.10.2.js"></script>
<script src="../../ui/theme/ibilling/js/bootstrap.min.js"></script>
<script src="../../ui/lib/blockui.js"></script>

</body>
</html>

