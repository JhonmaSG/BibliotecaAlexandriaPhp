<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
              integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <title>Alejandria Login Recuperar contraseña</title>
    </head>
    <body style="background: #989898;">
        <div class="container mt-4 col-4">
            <div class="card col-sm-10">
                <div class="card-body">
                    
                    <form class="form-sign" action="controlador?menu=Usuario&accion=CambiarContraseña" method="POST">
                        <div class="form-group text-center">
                            <h3>Recuperar contraseña</h3>
                            <img src="img/logoBiblioteca.png" alt="70" width="170"/>
                            
                            <label style="display: block">Gestos de Biblioteca</label>
                        </div>
                        <div class="form-group">
                            <label>Digite usuario</label>
                            <input type="text" name="txtuser" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Digite Correo:</label>
                            <input type="email" name="txtcorreo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Digite Dni:</label>
                            <input type="number" name="txtdni" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Respuesta a pregunta de seguridad:</label>
                            <input type="text" name="txtrespuesta" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Digite contraseña nueva:</label>
                            <input type="text" name="txtcontraNueva" class="form-control">
                        </div>
                        
                        <input type="submit" name="accion" value="EnviarRecuperacion" class="btn btn-primary">
                        <input type="reset" name="accion" value="Limpiar" class="btn btn-warning">
                        
                    </form><br>
                    <form>
                        <input type="submit" name="accion" value="Atras" class="btn btn-primary">
                    </form>
                    
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" 
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" 
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    </body>
</html>