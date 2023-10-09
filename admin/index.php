<?php require_once 'db_con.php';
session_start();
if (!isset($_SESSION['user_login'])) {
  header('Location: login.php');
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
    <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/solid.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap4.min.js"></script>
    <script src="../js/fontawesome.min.js"></script>
    <script src="../js/script.js"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="/login_copiaa/asset/css/estilos.css">
    <script src="https://kit.fontawesome.com/e1d55cc160.js" crossorigin="anonymous"></script>

    
    
    <title>Panel de Control</title>
  </head>
  <body>

<nav class="navbar navbar-expand-lg navbar-custom">

<a class="navbar-brand" href="index.php"><i class="fa-solid fa-paint-roller fa-3x" style="color: #107766B4;"></i></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>

   
  </button>

  <div class="navbar-collapse collapse justify-content-end" id="navbarSupportedContent">
    <?php $showuser = $_SESSION['user_login']; $haha = mysqli_query($db_con,"SELECT * FROM `users` WHERE `username`='$showuser';"); $showrow=mysqli_fetch_array($haha); ?>
    <ul class="nav navbar-nav ">
      <li class="nav-item"><a class="nav-link" href="index.php?page=user-profile"><i class="fa fa-user"></i> Hola,  <?php echo $showrow['name']; ?>!</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=add-student"><i class="fa fa-user-plus"></i> Agregar Estudiante</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=user-profile"><i class="fa fa-user"></i> Perfil</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
    </ul>
  </div>
</nav>
<br>
    <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="index.php?page=dashboard" class="list-group-item list-group-item-action active">
               <i class="fas fa-tachometer-alt"></i> Panel de Control
              </a>
              <a href="index.php?page=add-student" class="list-group-item list-group-item-action"><i class="fa fa-user-plus"></i> Agregar Estudiante</a>
              <a href="index.php?page=all-student" class="list-group-item list-group-item-action"><i class="fa fa-users"></i> Todos los Estudiantes</a>
              <a href="index.php?page=all-users" class="list-group-item list-group-item-action"><i class="fa fa-users"></i> Todos los Usuarios</a>
              <a href="index.php?page=user-profile" class="list-group-item list-group-item-action"><i class="fa fa-user"></i> Perfil de Usuario</a>
             
            </div>
          </div>
          <div class="col-md-9">
             <div class="content">
                 <?php 
                   if (isset($_GET['page'])) {
                    $page = $_GET['page'].'.php';
                    }else{
                      $page = 'dashboard.php';
                    }

                    if (file_exists($page)) {
                      require_once $page;
                    }else{
                      require_once '404.php';
                    }
                  ?>
             </div>
        </div>
        </div>  
    </div>
    <div class="clearfix"></div>
    
      <br><br><br><br><br><br><br><br><br><br><br><br>
     
      
    
    <script type="text/javascript">
      jQuery('.toast').toast('show');
    </script>
  </body>
</html>
<style>
  .icon .paint-roller {
    font-size: 50px;
    margin-bottom: 200px;
    color: white;
}


.navbar-custom {
  background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
  
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