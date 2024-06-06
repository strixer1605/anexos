<?php
    session_start();

    if (isset($_SESSION['dni_profesor'])) {
        $dni_profesor = $_SESSION['dni_profesor'];
        echo $dni_profesor;
    }
?>
