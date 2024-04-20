<?php
require 'application_installer_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Instalar</title>
    <link rel="shortcut icon" type="image/x-icon" href="../storage/icon/favicon.ico">
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



        <?php if (isset($_GET['_error']) && $_GET['_error'] == '1') {
            echo '<hr><h4 style="color: red;"> Unable to Connect Database, Please make sure database info is correct and try again ! </h4><hr>';
        } elseif (isset($_GET['_error']) && $_GET['_error'] == '2') {
            echo '<hr><h4 style="color: red;"> Config File Already Exist, Application is already installed. If Not delete config.php in application folder. And try installing again. </h4><hr>';
        } elseif (isset($_GET['_error']) && $_GET['_error'] == '3') {
            echo '<hr><h4 style="color: red;"> Please provide database info correctly and try again. </h4><hr>';
        } else {
        } ?>
        <?php
        $http = @$_SERVER["HTTPS"] == "on" ? "https://" : "http://";
        $cururl = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $appurl = str_replace('/install/step3.php', '', $cururl);
        $appurl = str_replace('?_error=1', '', $appurl);
        $appurl = str_replace('?_error=2', '', $appurl);
        $appurl = str_replace('?_error=3', '', $appurl);
        $appurl = str_replace('/application', '', $appurl);
        ?>

        <form action="step4.php" method="post" id="ib_form">
            <fieldset>
                <legend>Conexao com banco de dados e config</legend>

                <div class="form-group">
                    <label for="appurl">URL da Aplicacao</label>
                    <input type="text" class="form-control" id="appurl" name="appurl" value="<?php echo $appurl; ?>">
                    <span class='help-block'>A url sem a barra no final (ex  http://examplo.com/app).</span>
                </div>
                <hr>
                <p>Insira as informacoes de conexao com o banco de dados que criou no seu painel para continuar</p>

                <hr>
                <div class="form-group">
                    <label for="dbhost">Host do banco de dados</label>
                    <input type="text" class="form-control" id="dbhost" name="dbhost" value="localhost">
                    <span class="help-block">Geralmente é <strong>localhost</strong>, mas pode mudar dependendo da sua hospedagem.</span>
                </div>
                <div class="form-group">
                    <label for="dbuser">Usuario do Banco</label>
                    <input type="text" class="form-control" id="dbuser" name="dbuser">
                    <span class="help-block">o nome do usuario do banco</span>
                </div>
                <div class="form-group">
                    <label for="dbpass">Senha</label>
                    <input type="text" class="form-control" id="dbpass" name="dbpass">
                    <span class="help-block">senha do usuario do banco.</span>
                </div>

                <div class="form-group">
                    <label for="dbname">Nome do Banco</label>
                    <input type="text" class="form-control" id="dbname" name="dbname">
                    <span class="help-block">nome do banco de dados</span>
                </div>

                <button type="submit" id="ib_submit" class="btn btn-primary">Enviar</button>
            </fieldset>
        </form>
    </div>
</div>

<script src="../../ui/theme/ibilling/js/jquery-1.10.2.js"></script>
<script src="../../ui/theme/ibilling/js/bootstrap.min.js"></script>
<script src="../../ui/lib/blockui.js"></script>
<script src="../../ui/theme/ibilling/lib/bootbox.min.js"></script>

<script type="text/javascript">

    var block_msg = '<div class="md-preloader"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="32" width="32" viewbox="0 0 75 75"><circle cx="37.5" cy="37.5" r="33.5" stroke-width="6"/></svg></div>';

    var ib_submit = $("#ib_submit");
    var ib_box = $("#main-container");

    ib_submit.on('click', function(e) {

        e.preventDefault();
        ib_box.block({message: block_msg});

        $.post("ajax_c.php", $('#ib_form').serialize())
            .done(function( data ) {

                if ($.isNumeric(data)) {


                    ib_box.block({message: '<h3 style="color: #fff">Config file created. Importing database....</h3>'});


                    $.get( "db_import.php", function( data ) {

                        if ($.isNumeric(data)) {

                            ib_box.block({message: '<h3 style="color: #fff">Database Imported. Redirecting.....</h3>'});

                            window.location = 'profile.php';

                        }
                        else{
                            window.location = '../../index.php';
                        }

                    });


                }

                else {
                    ib_box.unblock();
                    bootbox.alert(data);
                }





            });

    });

</script>

</body>
</html>

