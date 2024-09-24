<?php
    session_start();

    if (!isset($_SESSION['dniProfesor'], $_SESSION['dniPadre'])) {
        header("Location: ../../index.php");

    } else if (!isset($_SESSION['dniPadre'])) {
        header("Location: ../../index.php");

    } else {
        include('../../php/conexion.php');

        $dniPadre = $_SESSION['dniPadre'];
        $dniHijo = $_GET['dniHijo'];
        $_SESSION['dniHijo'] = $dniHijo;
        
        $sqlAnexoV = "
        SELECT aiv.idAnexoIV, aiv.denominacionProyecto 
        FROM anexoiv aiv
        JOIN anexov av ON av.fkAnexoIV = aiv.idAnexoIV
        WHERE av.dni = $dniHijo AND aiv.estado = 2";

        $resultado = mysqli_query($conexion, $sqlAnexoV);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: white;
                text-align: center;
            }

            .btn {
                display: inline-block; /* Hace que se comporte como un bloque para respetar el ancho */
                width: 50%; /* Ancho del 50% de la pantalla */
                font-size: 16px;
                margin: 10px auto; /* Centra los botones y añade espacio vertical */
                text-decoration: none;
                color: #000;
                background-color: #f8f9fa;
                border: 1px solid #ccc;
                border-radius: 5px;
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }

            .btn:hover,
            .btn:focus,
            .btn:active {
                background-color: #e2e6ea; /* Cambio de color al pasar el ratón */
                outline: none; /* Elimina el borde de enfoque */
            }

            hr {
                border: 1px solid #D6D0D0;
                margin: 20px 0;
            }

            .container-center {
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            ul {
                padding-left: 0;
                list-style-type: none;
                width: 100%; /* Asegura que la lista ocupe el 100% del contenedor */
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            ul li {
                width: 100%; /* Asegura que cada ítem de la lista ocupe el 100% del ancho */
                display: flex;
                justify-content: center; /* Centra los botones */
            }
        </style>
    </head>
    <body>
        <div class="container-center">
            <h3>Documentos (PDF)</h3>
            <hr style="width: 100%;">
            <ul>
                <?php
                    while ($filaAnexoIV = $fila = $resultado->fetch_assoc()) {  
                        echo "<li><a href='hijoSalida.php' class='btn border-bottom border-top form-control'> " . $fila['denominacionProyecto'] . "</a></li>";
                    }
                ?>
            </ul>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
