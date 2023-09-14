<?php require_once 'db_con.php'; 
	session_start();
	if (isset($_POST['register'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$c_password = $_POST['c_password'];

		$photo = explode('.', $_FILES['photo']['name']);
		$photo= end($photo);
		$photo_name= $username.'.'.$photo;

		$input_error = array();
		if (empty($name)) {
			$input_error['name'] = "Es necesario diligenciar el campo de Nombre";
		}
		if (empty($email)) {
			$input_error['email'] = "Es necesario diligencia el campo de Correo";
		}
		if (empty($username)) {
			$input_error['username'] = "Debes diligenciar el campo de usuario";
		}
		if (empty($password)) {
			$input_error['password'] = "Debes diligenciar el campo de contraseña";
		}
		if (empty($photo)) {
			$input_error['photo'] = "La fotografía es un campo requerido";
		}

		if (!empty($password)) {
			if ($c_password!==$password) {
				$input_error['notmatch']="Has ingresado mal la contraseña!";
			}
		}

		if (count($input_error)==0) {
			$check_email= mysqli_query($db_con,"SELECT * FROM `users` WHERE `email`='$email';");

			if (mysqli_num_rows($check_email)==0) {
				$check_username= mysqli_query($db_con,"SELECT * FROM `users` WHERE `username`='$username';");
				if (mysqli_num_rows($check_username)==0) {
					if (strlen($username)>5) {
						if (strlen($password) > 7) {
							// Verificar que la contraseña contiene al menos una mayúscula, una minúscula y un símbolo
							if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-])/", $password)) {
								$password = sha1(md5($password));
								$query = "INSERT INTO `users`(`name`, `email`, `username`, `password`, `photo`, `status`) VALUES ('$name', '$email', '$username', '$password','$photo_name','activo');";
								$result = mysqli_query($db_con, $query);
								
								if ($result) {
									move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo_name);
									header('Location: register.php?insert=sucess');
								} else {
									header('Location: register.php?insert=error');
								}
							} else {
								$passlan = "La contraseña debe contener mínimo 1 minúscula, 1 mayúscula, 1 número y un símbolo.";
							}
						} else {
							$passlan = "La contraseña debe contener al menos 8 caracteres";
						}
					}else{
						$usernamelan= 'Este nombre de usuario debe contener al menos 8 caracteres';
					}
				}else{
					$username_error="Este usuario ya fue utilizado, intenta con uno diferente";
				}
			}else{
				$email_error= "El correo existe actualmente";
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
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
    min-height: 100vh;
    padding-top: 50px;
}
@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

</style>


    <title>Registro de Usuarios</title>
  </head>
  <body class="fondo-login">
    <div class="container"><br>
          <h1 class="text-center">Registro de Usuarios</h1><hr><br>
          <div class="d-flex justify-content-center">
          	<?php 
          		if (isset($_GET['insert'])) {
          			if($_GET['insert']=='sucess'){ echo '<div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-success fade hide" data-delay="2000">Tus datos han sido ingresados exitósamente</div>';}
          		}
          	;?>
          </div>
          <div class="row animate__animated animate__pulse">
            <div class="col-md-8 offset-md-2">
             	<form method="POST" enctype="multipart/form-data">
				  <div class="form-group row">
				
				  <div class="col-sm-6">
  				  <label for="exampleInputPassword1" class="form-label">Nombre</label>
  				  <input type="text" class="form-control" value="<?= isset($name)? $name:'' ?>" name="name" placeholder="" id="inputEmail3" pattern="[A-Za-z\s]+" title="Ingrese solo letras y espacios">
  				  <?= isset($input_error['name'])? '<label for="inputEmail3" class="error">'.$input_error['name'].'</label>':'';  ?>
				</div>

				    

					<div class="col-sm-4">
					<label for="exampleInputPassword1" class="form-label">usuario</label>
				      <input type="text" name="username" value="<?= isset($username)? $username:'' ?>" class="form-control" id="inputPassword3" placeholder=""><?= isset($input_error['usrname'])? '<label class="error">'.$input_error['username'].'</label>':'';  ?><?= isset($username_error)? '<label class="error">'.$username_error.'</label>':'';  ?><?= isset($usernamelan)? '<label class="error">'.$usernamelan.'</label>':'';  ?>
				    </div>

			
				  </div> 
			
				  <div class="form-group row">
				  <div class="col-sm-6">
				  <label for="exampleInputPassword1" class="form-label">Correo electronico</label>
				      <input type="email" class="form-control" value="<?= isset($email)? $email:'' ?>" name="email" placeholder="artTrack@gmail.com" id="inputEmail3"aria-describedby="emailHelp"><?= isset($input_error['email'])? '<label class="error">'.$input_error['email'].'</label>':'';  ?>
				      <?= isset($email_error)? '<label class="error">'.$email_error.'</label>':'';  ?>
				    </div>

					

					</div>

				  <div class="form-group row ">
				  <div class="col-auto">
    <i id="exampleInputPassword1" class="form-text" style="color:  rgb(65, 90, 173);">
        8 caracteres mínimo, minúsculas y mayúsculas, 1 número y un símbolo.
    </i>
</div>

<div class="col-sm-6">
    <label for="exampleInputPassword1" class="form-label">Contraseña</label>
    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="********"
	pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]).{8,}$"
           title="La contraseña debe tener al menos 8 caracteres, una minúscula, una mayúscula, un número y un símbolo.">
    <?= isset($input_error['password'])? '<label class="error">'.$input_error['password'].'</label>':'';  ?> 
    <?= isset($passlan)? '<label class="error">'.$passlan.'</label>':'';  ?>  


	<div id="password-alert" class="alert alert-danger" style="display: none;">
        La contraseña debe tener al menos 8 caracteres, una minúscula, una mayúscula, un número y un símbolo.
    </div>


</div>


				    
					<div class="col-sm-4">
					<label for="exampleInputPassword1" class="form-label">Confirmar contraseña</label>
				      <input type="password" name="c_password" class="form-control" id="inputPassword3" placeholder=""><?= isset($input_error['notmatch'])? '<label class="error">'.$input_error['notmatch'].'</label>':'';  ?> <?= isset($passlan)? '<label class="error">'.$passlan.'</label>':'';  ?>
				    </div>
				  </div>

				  <div class="form-group row">
				 
					</div>
					
					<div class="form-group row">
					</div>

				  <div class="row">

				  	<div class="col-sm-3"><label for="photo">Escoge tu fotografía</label></div>
				  	<div class="col-sm-9">
				      <input type="file" id="photo" name="photo" class="form-control" id="inputPassword3" >
				      <br>
				    </div>
				  </div>

				  
				  <div class="text-center">
				      <button type="submit" name="register" class="btn btn-danger">Registro</button>
				    </div>
				  </div>
				</form>
            </div>
          </div>
		  <br>
		  <div class="text-center">
              <p>Si tienes una cuenta de acceso administrativo, puedes <a href="login.php">Ingresar Aquí</a></p>
    </div>
	</div>
    	
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
    	$('.toast').toast('show')
    </script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const passwordInput = document.getElementById("inputPassword3");
    const passwordAlert = document.getElementById("password-alert");
    const submitButton = document.getElementById("submit-button");

    submitButton.addEventListener("click", function(event) {
        const password = passwordInput.value;
        const isValidPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]).{8,}$/.test(password);

        if (!isValidPassword) {
            passwordAlert.style.display = "block"; // Muestra la alerta
            event.preventDefault(); // Detiene el envío del formulario
        } else {
            passwordAlert.style.display = "none"; // Oculta la alerta
        }
    });
});
</script>




	
  </body>
</html>