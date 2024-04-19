<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Salud</title>
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <script src="../librerias/jquery.js?v=1"></script>
    <script src="../librerias/boostrap.js"></script>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<center>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-4">
            <img src="../imagenes/logoBA.png" width="20%">
        </div>
        <div class="col-4">
            <img src="../imagenes/logo.png" width="25%">
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-7">
            <h6>Corresponde al Expediente N° 5802-1701421/17</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h4><b>ANEXO VII</b></h4>
            <h5>PLANILLA DE SALUD PARA SALIDA EDUCATIVA</h5>
        </div>
        <div class="col-4"></div>
    </div>
</center>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <p class="flex-start">Fecha: <input type="date" id="fecha2" class="form-control-sm border-primary"><br>
            Apellido y nombres del: <input type="text" id="no_ap2" class="form-control-sm border-primary"><br>
            Apellido y nombres del Padre, Madre, Tutor o Representante Legal:<br>
            <input type="text" id="no_ap_fa2" class="form-control-sm border-primary"><br>
            Dirección: <input type="text" id="direc" class="form-control-sm border-primary"><br>
            Teléfono: <input type="number" id="telef" class="form-control-sm border-primary"><br>
            Lugar a Viajar: Villa La Angostura - San Carlos de Bariloche</p>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-11">
                <p><b>1.</b> ¿Es alérgico? 
                <select id="alerg" class="border-primary">
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select> (marcar la que corresponda)</p>
                <p>En caso de respuesta positiva: ¿A qué? 
                <input type="text" id="alergresp" class="form-control border-primary"></p>
                <p><b>2.</b> ¿Ha sufrido en los últimos 30 días? (marcar la que corresponda)</p>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-7">
                        <select class="border-primary form-control" id="sufer">
                            <option value="procesos inflamatorios">A. Procesos inflamatorios</option>
                            <option value="fracturas o esguinces">B. Fracturas o esguinces</option>
                            <option value="enfermedades infecto contagiosas">C. Enfermedades infecto-contagiosas</option>
                            <option value="otras">D. Otras</option>
                        </select>
                        <input type="text" class="form-control border-primary" id="suferresp">
                    </div>
                </div>
                <p><b>3.</b> ¿Está tomando alguna medicación?
                <select id="medic" class="border-primary">
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select> (marcar la que corresponda)</p>
                <p>En caso de respuesta positiva: ¿Cuál?
                <input type="text" id="medicresp" class="form-control border-primary"></p>
                <p><b>4.</b> Deje constancia de cualquier indicación que estime necesario deba conocer el personal médico y docente a cargo:
                <input type="text" id="cons" class="form-control border-primary"></p>
                <p><b>5.</b> ¿Tiene Obra Social?
                <select id="obras" class="border-primary">
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select> (marcar la que corresponda). En caso de respuesta positiva deberá acompañar la presente planilla con carnet o copia del carnet.</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <p>Dejo constancia de haber cumplimentado la planilla de salud de mi hijo/a <input type="text" id="www" class="form-control-sm border-primary">.
        en <input type="text" id="inst" class="form-control-sm border-primary" placeholder="institución">. a los <input type="text" id="prof" class="form-control-sm border-primary" placeholder="profesores">. días del mes de
        <input type="month" id="mes" class="form-control-sm border-primary">, autorizando por la presente a actuar en caso de emergencia, según lo dispongan profesionales médicos.
        La presente se realiza bajo forma de declaración jurada con relación a los datos consignados arriba.</p>
    </div>
    <div class="col-3"></div>
</div>
<center>
<div class="row">
    <div class="col-3"></div>
    <div class="col-3">
        <h5>Firma Padre, Madre, Tutor o Representante Legal</h5>
    </div>
    <div class="col-1"></div>
    <div class="col-2">
        <h5>Aclaración de Firma</h5>
    </div>
    <div class="col-3"></div>
</div>
</center>
<div class="row">
    <div class="col-3"></div>
    <div class="col-5">
        <p>-¿Confirma que los datos son verídicos? <input type="checkbox" class="form-check-input"></p>
    </div>
    <div class="col-1">
        <input type="button" id="enviar" value="Enviar">
        <br><br>
    </div>
</div>
</body>
</html>
<script>
$(document).ready(function(){
    $('#enviar').click(function(){
        let camposCompletos = true;

        $('input').each(function() {
            if ($(this).val().length === 0) {
                $(this).removeClass('border-primary');
                $(this).removeClass('input');
                $(this).addClass('border-danger');
                $(this).addClass('false');
                camposCompletos = false;
            } else {
                $(this).removeClass('border-primary');
                $(this).removeClass('input');
                $(this).removeClass('border-danger');
                $(this).removeClass('false');
                $(this).addClass('border-success');
                $(this).addClass('true');
            }
        });

        if (camposCompletos) {
            let fecha = $('#fecha2').val();
            let nombreyapellido = $('#no_ap2').val();
            let nombrepadre = $('#no_ap_fa2').val();
            let direccion = $('#direc').val();
            let telefono = $('#telef').val();
            let alergico = $('#alerg').val();
            let alergia = $('#alergresp').val();
            let malestares = $('#sufer').val();
            let otrmalestares = $('#suferresp').val();
            let medicacion = $('#medic').val();
            let quemedicacion = $('#medicresp').val();
            let constancia = $('#cons').val();
            let obrasocial = $('#obras').val();
            let institucion = $('#inst').val();
            let profesor = $('#prof').val();
            let meses = $('#mes').val();

            $.post('insert_vii.php', {
                fecha2: fecha, no_ap2: nombreyapellido, no_ap_fa2: nombrepadre, direc: direccion, telef: telefono,
                alerg: alergico, alergresp: alergia, sufer: malestares, suferresp: otrmalestares,
                medic: medicacion, medicresp: quemedicacion, cons: constancia, obras: obrasocial,
                inst: institucion, prof: profesor, mes: meses
            }, function (data) {
                alert(data);

                // Redirige solo después de procesar los datos y mostrar una alerta
                setTimeout(function() {
                    window.location.href = "../padres.php";
                }, 2000); // Redireccionar después de 2 segundos
                
            }); 
        }
    });
});

</script>
