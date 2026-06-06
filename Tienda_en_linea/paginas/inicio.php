
<?php

/*
=========================================
INICIAR SESIÓN
=========================================
*/

if(isset($_POST["enviar"]))
{
	$aviso = "";

	$usuario = htmlspecialchars(
		$_POST["usuario"]
	);

	$contrasena = htmlspecialchars(
		$_POST["contrasena"]
	);

	try{

		/*
		=========================================
		BUSCAR EMPLEADO
		=========================================
		*/

		$sql = "

		SELECT * FROM empleados

		WHERE usuario = ?

		";

		$stmt = $conexion->prepare($sql);

		$stmt->execute([$usuario]);

		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

		/*
		=========================================
		VALIDAR USUARIO
		=========================================
		*/

		if($resultado)
		{
			$contrasenaBD =
			$resultado["contraseña"];

			/*
			=========================================
			VALIDAR CONTRASEÑA
			=========================================
			*/

			if($contrasena == $contrasenaBD)
			{
				/*
				=========================================
				CREAR SESIÓN
				=========================================
				*/

				$_SESSION["ID"] =
				$resultado["id_empleado"];

				$_SESSION["USUARIO"] =
				$resultado["usuario"];

				$_SESSION["NOMBRE"] =
				$resultado["nombre"];

				$_SESSION["STATUS"] =
				"ACTIVA";

				/*
				=========================================
				ROL
				0 = EMPLEADO
				1 = ADMIN
				=========================================
				*/

				if(
					$resultado["puesto"]
					== "Administrador"
				){
					$_SESSION["ROL"] = 1;
				}else{
					$_SESSION["ROL"] = 0;
				}

				/*
				=========================================
				REDIRECCIÓN
				=========================================
				*/

				echo "

				<script>

					location.href=
					'index.php?pagina=tienda';

				</script>

				";
			}
			else
			{
				$aviso .= "
				Contraseña incorrecta
				<br>";
			}
		}
		else
		{
			$aviso .= "
			Usuario no encontrado
			<br>";
		}

	}catch(PDOException $e){

		echo $e->getMessage();
	}
}

?>

<!-- =====================================
     FORMULARIO LOGIN
===================================== -->

<div class="contenido">

	<form

	method="POST"

	enctype="multipart/form-data"

	action=""

	style="

		background:white;
		padding:30px;
		border-radius:10px;
		box-shadow:0px 0px 15px rgba(0,0,0,0.2);

	"

	>

		<p id="titulo_de_pagina">

			Iniciar Sesión

		</p>

		<input

		required

		type="text"

		name="usuario"

		placeholder="
		Introduzca su usuario"

		/>

		<input

		required

		type="password"

		name="contrasena"

		placeholder="
		Introduzca su contraseña"

		/>

		<div class="contenedorIcon">

			<input

			type="submit"

			class="icon"

			id="enviar"

			name="enviar"

			value="→"

			style="

				cursor:pointer;
				border:none;

			"

			/>

		</div>

		<br>

		<a href="index.php?pagina=registrar">

			Registrarse

		</a>

		<br><br>

		<a href="index.php?pagina=recuperar">

			Olvidé mi contraseña

		</a>

		<br><br>

		<?php

		if(isset($aviso))
		{
			echo "

			<div id='aviso'>

				".$aviso."

			</div>

			";
		}

		?>

	</form>

</div>

