<?php 
    $sql = "SELECT `idAnexoIV`, `estado`, `dniEncargado`, `cargo`, `fechaModificacion` FROM `anexoiv` WHERE dniEncargado = $dniDocente AND estado = 1";
?>