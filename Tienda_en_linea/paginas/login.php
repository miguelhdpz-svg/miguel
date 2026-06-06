<?php

if(isset($_POST["enviar"]))
{
    $usuario = $_POST["usuario"];
    $pass = $_POST["contrasena"];

    try{

        $sql = "SELECT * FROM empleados
                WHERE usuario = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuario]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user)
        {
            if($pass == $user["contraseña"])
            {
                /* SESIONES */

                $_SESSION["ID"] = $user["id_emplado"];

                $_SESSION["USUARIO"] =
                $user["usuario"];

                $_SESSION["STATUS"] =
                "ACTIVA";

                if($user["puesto"] == "Administrador")
                {
                    $_SESSION["ROL"] = 1;
                }
                else
                {
                    $_SESSION["ROL"] = 0;
                }

                echo "
                <script>
                    location.href='index.php?pagina=tienda';
                </script>
                ";

            }
            else
            {
                echo "
                <div id='aviso'>
                    Contraseña incorrecta
                </div>
                ";
            }
        }
        else
        {
            echo "
            <div id='aviso'>
                Usuario no encontrado
            </div>
            ";
        }

    }catch(PDOException $e){

        echo $e->getMessage();
    }
}

?>

<div class="contenido">

<form method="POST">

<h2 id="titulo_de_pagina">
Iniciar Sesión
</h2>

<input
type="text"
name="usuario"
placeholder="Usuario"
required>

<input
type="password"
name="contrasena"
placeholder="Contraseña"
required>

<input
type="submit"
name="enviar"
value="Entrar">

</form>

</div>