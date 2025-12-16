<?php include 'inc/conexion.php'; 

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
} 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Agregar Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <title>RESERVAS</title>
    <link rel="icon" type="image/png" href="templates/buscar.png">


    <style>
    .btn-sidebar {
        border: 2px solid #333;
        margin-left: 5px;
        background-color: white;
        color: #333;
        /* Aplicar transición a todas las propiedades relevantes */
        transition: all 0.5s ease;
    }

    .btn-sidebar:hover {
        background-color: #333;
        color: white;
        border-color: #333;
    }

    .card-body {
    height: 200px; /* Ajusta según el tamaño deseado */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    }

    .card-body img {
    max-height: 100%; /* Limita la imagen a la altura del contenedor */
    width: auto; /* Mantiene las proporciones */
    }
    </style>

</head>

<body>

    <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader">
    <img src="https://i.gifer.com/7kRE.gif" alt="Cargando..." 
         style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%);
                width: 150px; height: 150px; z-index: 9999;">
    </div>
    </div>
    <header style="margin-bottom: 20px;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-black navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#modalReservas">RESERVAS RESTAURANTE</a>
            <!-- Modal de Reservas -->
<div class="modal fade" id="modalReservas" tabindex="-1" aria-labelledby="modalReservasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalReservasLabel">Reservar una Mesa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="procesar_reserva.php" method="POST">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="numero_documento">numero de documento</label>
            <input type="documento" class="form-control" id="documento" name="numero_documento" required>
          <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
           
          </div>
          <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
          </div>
          <div class="form-group">
            <label for="numero_personas">Número de Personas:</label>
            <input type="number" class="form-control" id="personas" name="numero_personas" required>
            <div class="form-group">
            <label for="numero_mesa">Número de mesa:</label>
            <input type="number" class="form-control" id="mesa" name="numero_mesa" required>
          </div>
          <button type="submit" class="btn btn-success">Reservar</button>
        </form>
      </div>
    </div>
  </div>
</div>

            </li>
        </ul>

        <!-- Barra de búsqueda centrada -->
        <form class="form-inline ml-3">
            <div class="input-group" data-widget="sidebar-search">
                <input id="search-input" class="form-control form-control-sidebar" type="search" placeholder="MESA" aria-label="Search">
                <div style="margin-top: 7px; color: white;">
                    <i class="fas fa-search fa-fw"> </i>
                </div>

            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                    <i class="fa-solid fa-user" style="color: #74C0FC;"><?php echo $_SESSION['nombre'] ?></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <span class="dropdown-header">Opciones</span>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="auth/logout.php">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</header>


<div class="container">


    <div class="row">

    <?php
    $sql='SELECT ID_MESA,NUMERO_MESA,CAPACIDAD_MESA,UBICACION_MESA,ESTADO_MESA FROM MESAS';

    $result = $conn->query($sql);
    if ($result->rowCount() > 0) {
        // output data of each row
        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            ?>
            <div class="col-sm-3">
               
                    <div class="card <?php echo $row["ESTADO_MESA"]!= 'DISPONIBLE'?'card-danger':'card-success' ;?>">
                        <div class="card-header">
                        <h3 class="card-title">Mesa <?php echo $row["NUMERO_MESA"]?> <?php echo $row["UBICACION_MESA"]?></h3>
                        </div>
                        <div class="card-body">
                        <h3><?php echo $row["ESTADO_MESA"]?></h3>
                        </div>
                    </div>
                </a>
            </div>
        <?php
            //echo "id: " . $row["ins_id"]. " - Name: " . $row["ins_descripcion"]. " " . $row["ins_url"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    $conn=null;
    /*$id=$row["ins_id"];
    $descripcion=$row["ins_descripcion"];
    $url=$row["ins_url"];*/
    ?>    
        
    </div>
</div>

<script>
// Función de búsqueda
document.getElementById('search-input').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.card.card-primary');

    if (searchValue === '') {
        // Si el campo de búsqueda está vacío, mostrar todas las tarjetas
        cards.forEach(card => {
            card.closest('.col-sm-4').style.display = '';
        });
        return;
    }

    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const cardColumn = card.closest('.col-sm-4');
        
        // Divide la búsqueda en palabras individuales
        const searchWords = searchValue.split(' ');
        
        // Considera que hay coincidencia si al menos una palabra de la búsqueda
        // está contenida en el título
        const matches = searchWords.some(word => {
            // Considera coincidencia si al menos 3 caracteres coinciden en secuencia
            return title.includes(word) || 
                   // O si hay coincidencias parciales de palabras
                   (word.length >= 3 && title.split(' ').some(titleWord => 
                       titleWord.includes(word) || word.includes(titleWord)
                   ));
        });

        cardColumn.style.display = matches ? '' : 'none';
    });
});
</script>
</body>
</html>