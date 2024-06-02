<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
              rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Alejandria Login</title>
    </head>
    <body style="background: #989898;">
        <div class="container mt-4 col-4">
            <div class="card col-sm-10">
                <div class="card-body">
                    <div class="form-group text-center">
                        <h3>Login</h3>
                        <img src="../img/logoBiblioteca.png" alt="70" width="170"/>
                        <label style="display: block"><br><b>Bienvenido a Alexandria</b></label>
                        <label style="display: block">Gestos de Biblioteca</label>

                        <label class="underline">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#horariosModal"><b>Horarios de la biblioteca</b></a>
                        </label>
                        <hr>
                    </div>
                    <form class="form-sign" method="POST" action='Validar_Login.php'>
                        <?php
                        // Mostrar mensaje de error si existe
                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo $_SESSION['error_message'];
                            echo '</div>';
                            // Eliminar el mensaje de error después de mostrarlo
                            unset($_SESSION['error_message']);
                        }
                        ?>
                        <div class="form-group">
                            <label>Tipo de cuenta:</label>
                            <select name="tipo_cuenta" class="form-control">
                                <option value="cliente">Cliente</option>
                                <option value="empleado">Empleado</option>
                                <option value="administrador">Administrador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Usuario:</label>
                            <input type="text" name="txtusuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" name="txtclave" class="form-control">
                            <a href="RecuperarContraseña.php" class="btn btn-link">Olvidé mi contraseña</a>
                        </div>
                        <label>
                            <input type="checkbox" name="terminos" id="terminos" required>
                            Al continuar, estás de acuerdo con los <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">Términos y Condiciones</a>
                            de la biblioteca.
                        </label><br><br>
                        <br>
                        <input type="submit" value="Login" id="btnIngresar" class="btn btn-primary" disabled>
                        <input type="reset" value="Limpiar"  id="btnCrearCuenta" class="btn btn-warning" disabled>
                        <input type="button" value="Atrás" class="btn btn-info" onclick="window.location.href = '../NoUser/IndexNoUser.php';">
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="terminosModalLabel">Términos y Condiciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>1. Registro y Membresía</h5>
                        <p>
                            Para poder utilizar los servicios de préstamo de la biblioteca, es necesario registrarse como miembro. 
                            El registro es gratuito y puede realizarse en línea o en persona en nuestras instalaciones. 
                            Al registrarse, el usuario acepta proporcionar información veraz y actualizada. La membresía es personal e intransferible.
                        </p>

                        <h5>2. Préstamo de Libros</h5>
                        <p>
                            Los miembros pueden tomar prestados un libro a la vez. 
                            El período de préstamo estándar es de 30 días, con la posibilidad de renovar el préstamo por otros 8 días, 
                            siempre y cuando el libro no haya sido reservado por otro miembro. Las renovaciones pueden realizarse en la biblioteca.
                        </p>

                        <h5>3. Devoluciones</h5>
                        <p>
                            Los libros deben ser devueltos en la fecha de vencimiento o antes. 
                            La devolución puede realizarse en cualquiera de nuestras sucursales durante el horario de atención. 
                            Los libros devueltos deben estar en buen estado, sin daños ni marcas.
                        </p>

                        <h5>6. Uso de las Instalaciones</h5>
                        <p>
                            Los miembros tienen acceso a todas las instalaciones de la biblioteca, incluyendo salas de lectura, áreas de estudio y recursos electrónicos. 
                            Se espera que todos los usuarios mantengan un comportamiento respetuoso y no perturben a otros usuarios. El uso de dispositivos electrónicos 
                            está permitido, siempre y cuando no interfiera con la tranquilidad del ambiente.
                        </p>

                        <h5>7. Privacidad y Protección de Datos</h5>
                        <p>
                            La biblioteca se compromete a proteger la privacidad de sus miembros. 
                            La información personal recopilada durante el proceso de registro será utilizada únicamente para la gestión de la membresía y los servicios de préstamo. 
                            No compartiremos su información con terceros sin su consentimiento.
                        </p>

                        <h5>8. Modificación de los Términos y Condiciones</h5>
                        <p>
                            La biblioteca se reserva el derecho de modificar estos términos y condiciones en cualquier momento. 
                            Las modificaciones serán publicadas en el sitio web de la biblioteca y entrarán en vigor inmediatamente después de su publicación. 
                            Se recomienda a los miembros revisar regularmente los términos y condiciones para estar informados de cualquier cambio.
                        </p>

                        <h5>9. Contacto</h5>
                        <p>
                            Si tiene alguna pregunta o inquietud sobre estos términos y condiciones, no dude en ponerse en contacto con nosotros 
                            a través del correo electrónico info@biblioteca.com o llamando al (123) 456-7890.
                            Estamos aquí para ayudarle.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="horariosModal" tabindex="-1" aria-labelledby="horariosModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="horariosModalLabel">Horarios de la Biblioteca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Horarios de Atención</h5>
                        <p>
                            Lunes a Viernes: 8:00 AM - 5:00 PM<br>
                            Sábados: 9:00 AM - 2:00 PM<br>
                            Domingos y Festivos: Cerrado
                        </p>
                        <h5>Horarios Especiales</h5>
                        <p>
                            PROXIMAMENTE...
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://kit.fontawesome.com/9dbadc2946.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <script>
                            document.getElementById('terminos').addEventListener('change', function () {
                                var ingresarButton = document.getElementById('btnIngresar');
                                var crearCuentaButton = document.getElementById('btnCrearCuenta');
                                ingresarButton.disabled = !this.checked;
                                crearCuentaButton.disabled = !this.checked;
                            });
        </script>

    </body>
</html>
