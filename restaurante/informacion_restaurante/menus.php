
<?php include 'inc/conexion.php'; 

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
} 
if (!isset($_SESSION['tipo'])) {
    $_SESSION['tipo']='NO HAY TIPO ELEGIDO';
}
$FILTRO=isset($_GET['filtro'])?$_GET['filtro']:'TODO';
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

    <title>DOMICILIOS</title>
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
            <a href="#" class="nav-link" data-toggle="modal" data-target="#formularioModal">DOMICILIOS</a>
            </li>
        </ul>

        <!-- Barra de búsqueda centrada -->
        <form class="form-inline ml-3">
            <div class="input-group" data-widget="sidebar-search">
                <input id="search-input" class="form-control form-control-sidebar" type="search" placeholder="PLATO" aria-label="Search">
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
    if($FILTRO == 'TIPO')
    {
        $sql='SELECT id_plato,nombre_plato,plato_url FROM platos';
    }
    else
    {
        $sql="SELECT id_plato,nombre_plato,plato_url FROM platos WHERE tipo_plato = '$FILTRO'";
    }
    /*echo $sql;
    exit;*/

    $result = $conn->query($sql);
    if ($result->rowCount() > 0) {
        // output data of each row
        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            ?>
            <div class="col-sm-4">
                
                    <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title"><?php echo $row["nombre_plato"]?></h3>
                        </div>
                        <div class="card-body">
                            <img 
                                src="<?php echo $row["plato_url"]?>" 
                                
                                class="rounded mx-auto d-block">
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
<!-- Modal del formulario de Domicilios -->
<div id="formularioModal" class="modal fade" tabindex="-1" aria-labelledby="formularioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formularioModalLabel">Información del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pedidoForm" action="procesar_pedido.php" method="POST">
                    <div class="form-group">
                        <label for="numero_documento">numero de documento</label>
                        <input type="text" class="form-control" id="documento" name="numero_documento" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_documento">tipo de documento</label>
                        <input type="text" class="form-control" id="tipo_documento" name="tipo_documento" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_completo">nombre de completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre_completo" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_celular">numero de celular</label>
                        <input type="text" class="form-control" id="telefono" name="numero_celular" required>
                    </div>
                    <div class="form-grtrónicooup">
                        <label for="correo_electronico">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo_electronico" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">ciudad:</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_pedido">fecha del pedido</label>
                        <input type="date" class="form-control" id="fecha" name="fecha_pedido" required>
                    </div>
                    <div class="form-group">
    <label for="plato">Plato Deseado:</label>
    <select class="form-control" id="plato" name="plato" required>
        <option value="">Selecciona un plato</option>
        <?php
        include 'inc/conexion.php'; // Asegúrate de que la conexión está disponible
        $sql = "SELECT id_plato, nombre_plato FROM platos";
        $result = $conn->query($sql);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['nombre_plato'] . "'>" . $row['nombre_plato'] . "</option>";
        }
        ?>
    </select>
</div>

                    </div>
                    <div class="form-group">
                        <label for="estado_pedido">Estado del Pedido:</label>
                        <select class="form-control" id="estado" name="estado_pedido" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Enviado">Enviado</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Pedido</button>
                   
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

</body>
</html>
