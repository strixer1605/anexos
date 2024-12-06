<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Desarrolladores</title>
    <style>
        body {
            background-color: #f4f4f4 !important;
        }

        .card {
            width: 300px;
            margin: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-top: 15px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            align-items: center;
        }

        .card-title {
            margin-top: 10px;
        }

        .card-text {
            flex-grow: 1;
        }

        .btn {
            margin-top: auto;
        }

        #card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        @media (max-width: 576px) {
            #card-container {
                flex-direction: column;
            }
        }

        footer {
            width: 100%;
            background-color: rgb(64, 165, 221);
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            color: white;
        }

        @media (max-width: 768px) {
            .btn-volver {
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="row" style="padding: 22px;">
        <div class="col-12 d-flex">
            <!-- Logo a la izquierda -->
            <div class="col-6 d-flex align-items-center">
                <a href="index.php">
                    <img src="../imagenes/eest.png" alt="logo" style="height: 100px;">
                </a>
            </div>
            <!-- Botón a la derecha en la parte superior -->
            <div class="col-6 d-flex" style="flex-direction: column; align-items: flex-end;">
                <a onclick="window.history.back();" style="width: 62px; margin: 0; color: white;" class="btn btn-warning btn-volver">Atrás</a>
            </div>
        </div>
    </div>


    <!-- Contenedor de los cards -->
    <div id="card-container">
        <?php
            include('../php/traerDesarrolladores.php');
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        function showInfo(title, description, linkedin) {
            Swal.fire({
                title: title,
                text: description,
                footer: `<a href="${linkedin}" target="_blank">Perfil de LinkedIn</a>`,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        }

    </script>
</body>
</html>
