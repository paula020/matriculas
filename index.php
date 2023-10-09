<?php require_once 'admin/db_con.php';
 // Función para limpiar y validar los datos de entrada
function limpiarDato($dato) {
  $dato = trim($dato); // Eliminar espacios en blanco al inicio y al final
  $dato = stripslashes($dato); // Eliminar barras invertidas
  $dato = htmlspecialchars($dato); // Convertir caracteres especiales en entidades HTML
  return $dato;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $choose = limpiarDato($_POST['choose']);
  $roll = limpiarDato($_POST['roll']);

  // Validar que los datos no estén vacíos
  if (!empty($choose) && !empty($roll)) {
      // Escapar los datos para prevenir inyección SQL
      $choose = mysqli_real_escape_string($db_con, $choose);
      $roll = mysqli_real_escape_string($db_con, $roll);

      $query = mysqli_query($db_con, "SELECT * FROM `student_info` WHERE `roll`='$roll' AND `class`='$choose'");
      $row = mysqli_fetch_array($query);

      if (!empty($row)) {
          if ($row['roll'] == $roll && $choose == $row['class']) {
              $stroll = $row['roll'];
              $stname = $row['name'];
              $stclass = $row['class'];
              $city = $row['city'];
              $photo = $row['photo'];
              $pcontact = $row['pcontact'];
              // Resto del código para mostrar la información...
          } else {
              echo '<p style="color:red;">Por favor ingrese un número válido de matrícula y grado</p>';
          }
      } else {
          echo '<p style="color:red;">Tu información ingresada no coincide</p>';
      }
  } else {
      echo '<p style="color:red;">Por favor complete todos los campos</p>';
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-57KGD6WS');</script>
<!-- End Google Tag Manager -->


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/estiloss.css">
    <script src="../js/aviso-cookies.js"></script>
    <!-- <script src="js/aviso-cookies.js"></script> -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 

    <title>Matrícula de Estudiantes</title>
<!-- cookies -->






  

  </head>
  
  <body class="fondo-login">

  <!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-57KGD6WS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->


<!-- 
<div class="aviso-cookies activo" id="aviso-cookies">
		<img class="galleta" src="img/cookie.svg" alt="Galleta">
		<h3 class="titulo">Cookies</h3>
		<p class="parrafo">Utilizamos cookies propias y de terceros para mejorar nuestros servicios.</p>
		<button class="boton" id="btn-aceptar-cookies">De acuerdo</button>
		<a class="enlace" href="./aviso.php">Aviso de Cookies</a>
	</div>
	<div class="fondo-aviso-cookies activo" id="fondo-aviso-cookies"></div>
 -->



    <div class="container"><br>
      <a class="btn btn-primary float-right" href="admin/login.php">Panel Administrativo</a>

        <h1 class="animated bounceIn"class="text-center" style="font-family: 'Quicksand', sans-serif;">Sistema de Matrícula de Estudiantes </h1><br>
        <div class="d-flex justify-content-center align-items-center">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/h7q5IIsf_Z4?si=eLuLGWGBg_O7Bem6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
          <div class="row">
            <div class="col-md-10 offset-md-4">
              <form method="POST">
            <table class="text-center infotable">
              <tr>
                <th colspan="2">
                  <p class="text-center">Información del Estudiante</p>
                </th>
              </tr>
              <tr>
                <td>
                   <p>Selecciona el Curso</p>
                </td>
                <td>
                   <select class="form-control" name="choose">
                     <option value="">
                       Selecciona
                     </option>
                     <option value="Primero">
                       Pintura
                     </option>
                     <option value="Segundo">
                       Musica
                     </option>
                     <option value="Tercero">
                       Danza
                     </option>
                     <option value="Cuarto">
                       Fotografia
                     </option>
                     <option value="Quinto">
                       Teatro
                     </option>
                   </select>
                </td>
              </tr>

              <tr>
                <td>
                  <p><label for="roll">Número Matricula</label></p>
                </td>
                <td>
                  <input class="form-control" type="text" pattern="[0-9]{6}" id="roll" placeholder="6 dígitos..." name="roll">
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-center">
                  <input class="btn btn-danger" type="submit" name="showinfo">
                </td>
              </tr>
            </table>
          </form>
            </div>
          </div>
        <br>
        <?php if (isset($_POST['showinfo'])) {
          $choose= $_POST['choose'];
          $roll = $_POST['roll'];
          if (!empty($choose && $roll)) {
            $query = mysqli_query($db_con,"SELECT * FROM `student_info` WHERE `roll`='$roll' AND `class`='$choose'");
            if (!empty($row=mysqli_fetch_array($query))) {
              if ($row['roll']==$roll && $choose==$row['class']) {
                $stroll= $row['roll'];
                $stname= $row['name'];
                $stclass= $row['class'];
                $city= $row['city'];
                $photo= $row['photo'];
                $pcontact= $row['pcontact'];
              ?>
        <div class="row">
          <div class="col-sm-6 offset-sm-3">
            <table class="table table-bordered">
              <tr>
                <td rowspan="5"><h3>Información de Estudiante</h3><img class="img-thumbnail" src="admin/images/<?= isset($photo)?$photo:'';?>" width="250px"></td>
                <td>Nombre</td>
                <td><?= isset($stname)?$stname:'';?></td>
              </tr>
              <tr>
                <td>Número de Matrícula</td>
                <td><?= isset($stroll)?$stroll:'';?></td>
              </tr>
              <tr>
                <td>Grado</td>
                <td><?= isset($stclass)?$stclass:'';?></td>
              </tr>
              <tr>
                <td>Dirección</td>
                <td><?= isset($city)?$city:'';?></td>
              </tr>
              <tr>
                <td>Fecha de Ingreso</td>
                <td><?= isset($pcontact)?$pcontact:'';?></td>
              </tr>
            </table>
          </div>
        </div>  
      <?php 
          }else{
                echo '<p style="color:red;">Por favor ingrese un número válido de matricula y grado</p>';
              }
            }else{
              echo '<p style="color:red;">Tu información ingresada no coincide</p>';
            }
            }else{?>
              <script type="text/javascript">alert("Datos no encontrados");</script>
            <?php }
          }; ?>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    


  </body>
</html>
<style>
  .fondo-login {
    background: linear-gradient(-45deg, #9DDAE2, #E5A2BC, #EEE7AD, #23d5ab);
    background-size: 200% 200%;
    
    animation: gradient 15s ease infinite;
    /* height: 100vh; */
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
 