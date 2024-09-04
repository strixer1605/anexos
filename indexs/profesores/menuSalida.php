<?php
include '../../php/conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verificar si el idAnexoIV está presente en la solicitud POST
if (isset($_POST['idAnexoIV'])) {
    $idSalida = $_POST['idAnexoIV'];

    // Preparar la consulta SQL
    $sql = "SELECT denominacionProyecto FROM anexoiv WHERE idAnexoIV = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $idSalida); // Suponiendo que idAnexoIV es un entero

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        // Verificar si se encontró un resultado
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $denominacionProyecto = $row['denominacionProyecto'];
        } else {
            echo ('error');
        }
    } else {
        echo ('error');
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
} else {
    echo ('error');
}

$conexion->close();
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
                    echo $row['denominacionProyecto'];
                ?>
            </h1>
            <div class="row mt-5">
                <div class="col-md-6">
                    <h3>Formularios</h3>
                    <hr>
                    <ul>
                        <li><a href="#" class="btn form-control botones w-100 mb-3" onclick = "submitForm('formularioAnexosCompletos.php', <?php echo $idSalida ?>)">Anexos 5/8/9/10</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Documentos (PDF)</h3>
                    <hr>
                    <ul>
                        <li><button class="btn form-control botones w-100 mb-3" onclick = "submitForm('#', <?php echo $idSalida ?>)">Anexo 4</button></li>
                        <li><button class="btn form-control botones w-100 mb-3" onclick = "submitForm('#', <?php echo $idSalida ?>)">Anexo 5</button></li>
                        <li><button class="btn form-control botones w-100 mb-3" onclick = "submitForm('#', <?php echo $idSalida ?>)">Anexo 8</button></li>
                        <li><button class="btn form-control botones w-100 mb-3" onclick = "submitForm('#', <?php echo $idSalida ?>)">Anexo 9</button></li>
                        <li><button class="btn form-control botones w-100 mb-3" onclick = "submitForm('#', <?php echo $idSalida ?>)">Anexo 10</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <form id="hiddenForm" method="POST" action="" style="display: none;">
            <input type="hidden" name="idAnexoIV" id="idAnexoIV" value="">
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function submitForm(action, idAnexoIV) {
                document.getElementById('hiddenForm').action = action;
                document.getElementById('idAnexoIV').value = idAnexoIV;
                document.getElementById('hiddenForm').submit();
            }
        </script>
    </body>
</html>
