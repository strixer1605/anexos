<?php
    session_start();

    if (isset($_SESSION['dni_padre'])) {
        $dni_profesor = $_SESSION['dni_padre'];
        echo $dni_profesor;
    }
?>
