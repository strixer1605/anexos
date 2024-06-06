<?php
    session_start();

    if (isset($_SESSION['dni_director'])) {
        $dni_profesor = $_SESSION['dni_director'];
        echo $dni_profesor;
    }
?>
