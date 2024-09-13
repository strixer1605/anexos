<?php
    session_start();
    include '../../php/conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: white;
                color: #fff;
                text-align: center;
            }
            .container {
                max-width: 900px;
                margin-top: 50px;
                padding: 30px;
                background-color: white;
                color: #000;
            }

            .form-control {
                display: block;
                width: 100%;
                height: 34px;
                padding: 6px 12px;
                font-size: 13px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }

            .navbar-custom {
                background-color: white;
                padding: 10px;
            }
            ul {
                padding-left: 0;
                list-style-type: none;
            }
            hr {
                border: 1px solid #D6D0D0;
                margin: 20px 0;
            }
            .botones {
                margin-bottom: 5px;
                max-width: 100%;
                height: auto !important;
                text-decoration: none !important;
                cursor: pointer;
                font-size: 16px;
                color: #000;
                /* border: 1px solid transparent; Establece un borde transparente */
                transition: background-color 0.3s ease, border-color 0.3s ease; /* Transición suave para los cambios */
            }

            .botones:focus,
            .botones:hover,
            .botones:active {
                border-color: transparent; /* Asegúrate de que el borde no cambie */
                outline: none; /* Elimina el contorno del enfoque */
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid d-flex align-items-center">
                <a href="menuAdministrarSalidas.php" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
            </div>
        </nav>

        <div class="container">
            <h1>
                <?php
                    echo $_SESSION['denominacionProyecto'];
                ?>
            </h1>
            <div class="row mt-5">
                <div class="col-md-6">
                    <h3>Formularios</h3>
                    <hr>
                    <ul>
                        <li><a href="formularioAnexosCompletos.php" class="btn form-control botones w-100 mb-3">Anexos 5/8/9/10</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Documentos (PDF)</h3>
                    <hr>
                    <ul>
                        <li><a href="../pdf/plantillaAnexoIV/plantillaAnexoIV.php" class="btn form-control botones w-100 mb-3">Anexo 4</a></li>
                        <li><a href="../pdf/plantillaAnexoV/plantillaAnexoV.php" class="btn form-control botones w-100 mb-3">Anexo 5</a></li>
                        <li><a href="../pdf/plantillaAnexoVIII/plantillaAnexoVIII.php" class="btn form-control botones w-100 mb-3">Anexo 8</a></li>
                        <li><a href="../pdf/plantillaAnexoIX/" class="btn form-control botones w-100 mb-3">Anexo 9</a></li>
                        <li><a href="../pdf/plantillaAnexoX/plantillaAnexoX.php" class="btn form-control botones w-100 mb-3">Anexo 10</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
