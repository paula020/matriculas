<?php require_once 'db_con.php'; 
session_start();
if(isset($_SESSION['user_login'])){
	header('Location: index.php');
}
	if (isset($_POST['login'])) {
		$username= $_POST['username'];
		$password= $_POST['password'];


		$input_arr = array();

		if (empty($username)) {
			$input_arr['input_user_error']= "Username Is Required!";
		}

		if (empty($password)) {
			$input_arr['input_pass_error']= "Password Is Required!";
		}

		if(count($input_arr)==0){
			$query = "SELECT * FROM `users` WHERE `username` = '$username';";
			$result = mysqli_query($db_con, $query);
			if (mysqli_num_rows($result)==1) {
				$row = mysqli_fetch_assoc($result);
				if ($row['password']==sha1(md5($password))) {
					if ($row['status']=='activo') {
						$_SESSION['user_login']=$username;

                        // cookies

                        $cookie_options = array(
                            'expires' => time() + 3600, // Tiempo de expiración en segundos
                            'path' => '/', // Ruta de la cookie
                            'domain' => '', // Dominio (puedes especificar un dominio si es necesario)
                            'secure' => true, // Establecer a true para habilitar cookies seguras (HTTPS)
                            'httponly' => true, // Establecer a true para cookies HTTP Only
                            'samesite' => 'Strict' // Puedes usar 'Strict', 'Lax', o 'None' según tus necesidades
                        );
                        setcookie("username_cookie", $username, $cookie_options);


						header('Location: index.php');
					}else{
						$status_inactive = "Su estado está inactivo, póngase en contacto con el administrador o el soporte";
					}
				}else{
					$worngpass= "Contraseña o Usurario Incorrectos!";	
				}
			}else{
				$usernameerr= "Nombre de usuario no existe";
			}
		}
		
	}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
	 <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        .fondo-login {
    background: 
.icon .dog-icon {
    font-size: 50px;
    margin-bottom: 10px;
    color: white;
}

.box-eye {
    margin-top: -10px; /* Ajusta el valor según sea necesario para mover el botón hacia arriba o abajo */
	/* Ajusta el valor según sea necesario para mover el botón hacia la derecha */
}
.box {
	margin-left: 50px; /* Ajusta el valor según sea necesario para mover el botón hacia arriba o abajo */
	/* Ajusta el valor según sea necesario para mover el botón hacia la derecha */
}

.error-text {
    color: #57EE52; /* Puedes cambiar "red" al color que desees */
}

    </style>
    <title>Inicia sesion en ArtTrack</title>
</head>
<body class="fondo-login">


<div class="container">
    <br>
    <div class="text-center icon">
           <i class="fa-solid fa-palette fa-fade dog-icon" style="color: rgb(54, 75, 114);"></i>
        </a>
    </div>
    <h1 class="text-center"> Inicia sesion en ArtTrack</h1>
    <hr>
    <br>
    <div class="d-flex justify-content-center">
        <?php if(isset($usernameerr)){ ?> <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade hide" data-delay="2000"><?php echo $usernameerr; ?></div><?php };?>
        <?php if(isset($worngpass)){ ?> <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade hide" data-delay="2000"><?php echo $worngpass; ?></div><?php };?>
        <?php if(isset($status_inactive)){ ?> <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade hide" data-delay="2000"><?php echo $status_inactive; ?></div><?php };?>
    </div>
<!-- 
    cookies -->

    <?php
$username_cookie = isset($_COOKIE['username_cookie']) ? $_COOKIE['username_cookie'] : '';
?>


    <div class="row animate__animated animate__pulse">
        <div class="col-md-4 offset-md-4">
            <form method="POST" action="">
                <div class="form-group row">
                    <div class="col-sm-12">
                        
					<label for="exampleInputEmail1" class="form-label">Usuario</label>
					<input type="text" class="form-control" name="username" value="<?= isset($username)? $username: ''; ?>" placeholder="" id="inputEmail3"> 
                    <?php echo isset($input_arr['input_user_error'])? '<label>'.$input_arr['input_user_error'].'</label>':''; ?>
                    </div>
                </div>
				<div class="form-group row">
                    <div class="col-sm-12">
						
                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                        <div class="box-eye ">
						<div class="box">

						<button type="button" onclick="mostrarContraseña('inputPassword3', 'eyepassword')">
                                <i id="eyepassword" class="fa-solid fa-eye changePassword"></i>
                            </button>
							</div>
                            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Contraseña">
                            
                        </div>
                        <label><?php echo isset($input_arr['input_pass_error'])? '<label>'.$input_arr['input_pass_error'].'</label>':''; ?>
                    </div>
                </div>

				<div class="d-flex justify-content-center">
    <?php if(isset($usernameerr)){ ?>
        <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade show">
            <?php echo $usernameerr; ?>
        </div>
    <?php };?>
    <!-- Resto de tus mensajes de error existentes -->
</div>



<div class="d-flex justify-content-center">
    <?php if(isset($worngpass)){ ?>
        <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade show">
            <?php echo $worngpass; ?>
        </div>
    <?php };?>
    <!-- Resto de tus mensajes de error existentes -->
</div>


			

                <div class="text-center">
                    <button type="submit" name="login" class="btn btn-primary">Ingresar</button>
                </div>
                <br><br>
                <div class="text-center">
                    <p>¿Nuevo en ArtTrack? <a href="register.php">Crea una cuenta</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Optional JavaScript -->


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
function mostrarContraseña(idPassword, idIcon) {
  let inputPassword = document.getElementById(idPassword);
  let icon = document.getElementById(idIcon);
  if (inputPassword.type == "password" && icon.classList.contains("fa-eye")) {
    inputPassword.type = "text";
    icon.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    inputPassword.type = "password";
    icon.classList.replace("fa-eye-slash", "fa-eye");
  }
}

</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
    crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="/login_copiaa/asset/css/estilos.css">
    <script src="https://kit.fontawesome.com/e1d55cc160.js" crossorigin="anonymous"></script>

    </script>
  </body>
</html>