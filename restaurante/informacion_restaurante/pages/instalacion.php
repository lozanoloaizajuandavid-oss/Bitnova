<?php
// Incluir el archivo de conexión

include '../inc/conexion.php';
session_start();
include '../inc/crud.php';
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = intval($_GET["id"]); // Convierte a número entero para seguridad
    // Ahora puedes usar $id en la consulta SQL
} else {
    echo "ID inválido";
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit();
} 

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información General</title>
    <link rel="icon" type="image/png" href="../templates/buscar_cliente.png">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <div class="content-wrapper" >
            <section class="content-header">
                <a href="../index.php" class="btn btn-dark">
                    
                    <i class="fa-solid fa-chevron-left"></i>
                        Regresar
                    
                </a>

                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="text-center">Información General de Instalación</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="infoTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="informacion-tab" data-toggle="tab" href="#informacion" role="tab" aria-controls="informacion" aria-selected="true">
                                        <i class="fas fa-info-circle"></i> Información General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="contrato-tab" data-toggle="tab" href="#contrato" role="tab" aria-controls="contrato" aria-selected="false">
                                        <i class="fas fa-file-contract"></i> Contrato
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="instalacion-tab" data-toggle="tab" href="#instalacion" role="tab" aria-controls="instalacion" aria-selected="false">
                                        <i class="fas fa-tools"></i> Instalación
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="felec-tab" data-toggle="tab" href="#felec" role="tab" aria-controls="felec" aria-selected="false">
                                        <i class="fas fa-bolt"></i> FELEC
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="equipos-tab" data-toggle="tab" href="#equipos" role="tab" aria-controls="equipos" aria-selected="false">
                                        <i class="fas fa-desktop"></i> Equipos Hardware
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="software-tab" data-toggle="tab" href="#software" role="tab" aria-controls="software" aria-selected="false">
                                        <i class="fas fa-laptop-code"></i> Software
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" id="trazabilidad-tab" data-toggle="tab" href="#trazabilidad" role="tab" aria-controls="trazabilidad" aria-selected="false">
                                        <i class="fas fa-route"></i> Trazabilidad
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="infoTabsContent">

                            <div class="tab-pane fade show active" id="informacion" role="tabpanel" aria-labelledby="informacion-tab">
                                    <h4>Información general.</h4>
                                    
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>INSTALACION</th>
                                                <th>INFORMACION</th>
                                                
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT ins_descripcion,ins_extra FROM instalacion  WHERE ins_id = $id"; // Ajusta los campos según tu base de datos
                                            $stmt = $conn->query($query);
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['ins_descripcion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ins_extra']) . "</td>";                                               
                                                echo "</tr>";

                                                /*$id_contrato = $row['cont_id']; 
                                                $fecha_inicio = $row['fecha_inicio'];
                                                $fecha_fin = $row['fecha_fin'];
                                                $descripcion = $row['descripcion'];*/
                                            }
                                            ?> 
                                        </tbody>
                                    </table>

                            </div>

                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['frmContrato'])) {
                                    // Recupera los datos del formulario
                                    $cont_id = $_POST['cont_id']; // Asegúrate de que $id_contrato esté definido
                                    $fecha_inicio = $_POST['fecha_inicio'];
                                    $fecha_fin = $_POST['fecha_fin'];
                                    $descripcion = $_POST['descripcion'];
                                
                                    // Datos en array para la función
                                    $data = [
                                        'fecha_inicio' => $fecha_inicio,
                                        'fecha_fin' => $fecha_fin,
                                        'descripcion' => $descripcion
                                    ];
                                
                                    // Llama a la función `update`
                                    $sql = "UPDATE contrato SET fecha_inicio = ?, fecha_fin = ?, descripcion = ? WHERE cont_id = ?";
                                    $values = [$fecha_inicio, $fecha_fin, $descripcion, $cont_id];
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute($values);
                                
                                    // Verifica si se generó una consulta válida
                                    /*if ($result !== null) {
                                        $sql = $result['sql'];
                                        $values = $result['values'];
                                
                                        // Prepara y ejecuta la consulta con los parámetros adecuados
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute($values);
                                    } else {
                                        echo "<div class='alert alert-warning'>No se proporcionaron datos para actualizar.</div>";
                                    }*/
                                }
                                
                            ?>                                
                            <div class="tab-pane fade " id="contrato" role="tabpanel" aria-labelledby="contrato-tab">
                                <h4>Detalles del contrato.</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Fecha inicio</th>
                                            <th>Fecha fin</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT cont_id, ins_descripcion, fecha_inicio,fecha_fin, descripcion FROM contrato INNER JOIN instalacion on(contrato.instalacion_id=instalacion.ins_id) WHERE instalacion.ins_id = $id"; // Ajusta los campos según tu base de datos
                                        $stmt = $conn->query($query);
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['cont_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['ins_descripcion']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fecha_fin']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                                            echo "</tr>";

                                            $id_contrato = $row['cont_id']; 
                                            $fecha_inicio = $row['fecha_inicio'];
                                            $fecha_fin = $row['fecha_fin'];
                                            $descripcion = $row['descripcion'];
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
                                
                                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal'                            
                                    >Editar
                                </button>

                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Editar Información del Contrato <?php echo $id_contrato;?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="">
                                                    <input type="hidden" id="frmContrato" name="frmContrato">
                                                    <input type="hidden" id="cont_id" name="cont_id" value="<?php echo $id_contrato; ?>">
                                                    <div class="form-group">
                                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fecha_fin">Fecha de Fin</label>
                                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descripcion">Descripción</label>
                                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $descripcion; ?></textarea>
                                                    </div>
                                                    <button type="submit" name="update" class="btn btn-primary">Actualizar</button> 
                                               
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                            <div class="tab-pane fade" id="instalacion" role="tabpanel" aria-labelledby="instalacion-tab">
                                <h4>Detalles sobre la instalación.</h4>
                                
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Numero de contacto</th>
                                            <th>Nombre contacto</th>
                                            <th>Direccion</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT ins_id, ins_descripcion, num_numero,num_propietario,ins_direccion FROM instalacion inner join numero_telefono on (numero_telefono.num_ins_id=instalacion.ins_id) WHERE ins_id = $id"; // Ajusta los campos según tu base de datos
                                        $stmt = $conn->query($query);
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['ins_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['ins_descripcion']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['num_numero']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['num_propietario']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['ins_direccion']) . "</td>";
                                            
                                            echo "</tr>";

                                            /*$id_contrato = $row['cont_id']; 
                                            $fecha_inicio = $row['fecha_inicio'];
                                            $fecha_fin = $row['fecha_fin'];
                                            $descripcion = $row['descripcion'];*/
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="felec" role="tabpanel" aria-labelledby="felec-tab">
                                <h4>Información sobre FELEC.</h4>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>INSTALACION</th>
                                            <th>NOTA CREDITO</th>
                                            <th>REPLICAR AUTOMATICO</th>
                                            <th>BOTONES</th>
                                            <th>USUARIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT  ins_descripcion, fel_fe ,fel_nota, fel_replicar,fel_usuario FROM felec inner join instalacion on (felec.fel_ins_id=instalacion.ins_id) WHERE ins_id = $id"; // Ajusta los campos según tu base de datos
                                        $stmt = $conn->query($query);
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['ins_descripcion']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fel_fe']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fel_nota']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fel_replicar']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fel_usuario']) . "</td>";
                                            echo "</tr>";

                                            /*$id_contrato = $row['cont_id']; 
                                            $fecha_inicio = $row['fecha_inicio'];
                                            $fecha_fin = $row['fecha_fin'];
                                            $descripcion = $row['descripcion'];*/
                                        }
                                        ?> 
                                    </tbody>
                                </table>

                            </div>
                                <div class="tab-pane fade" id="equipos" role="tabpanel" aria-labelledby="equipos-tab">
                                    <h4>Listado de equipos de hardware.</h4>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>INSTALACION</th>
                                                <th>TIPO</th>
                                                <th>MODELO</th>
                                                <th>DESCRIPCION</th>
                                                <th>UNIDADES</th>
                                                <th>OPERATIVO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT ins_descripcion,har_tipo ,ih_modelo,ih_unidades, ih_descripcion,ih_operativa FROM instalacion_hardware ih inner join instalacion i on (ih.ih_ins_id=i.ins_id) inner join hardware h on (ih.ih_har_id=h.har_id) WHERE ins_id = $id"; // Ajusta los campos según tu base de datos
                                            $stmt = $conn->query($query);
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['ins_descripcion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['har_tipo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ih_modelo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ih_descripcion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ih_unidades']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ih_operativa']) . "</td>";
                                                echo "</tr>";

                                                /*$id_contrato = $row['cont_id']; 
                                                $fecha_inicio = $row['fecha_inicio'];
                                                $fecha_fin = $row['fecha_fin'];
                                                $descripcion = $row['descripcion'];*/
                                            }
                                            ?> 
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane fade" id="software" role="tabpanel" aria-labelledby="software-tab">
                                    <h4>Descripción del software instalado.</h4>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>INSTALACION</th>
                                                <th>SOFTWARE</th>
                                                <th>VERSION</th>
                                                <th>ESTADO</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT ins_descripcion,sof_nombre ,is_version,is_estado FROM instalacion_software iso inner join instalacion i on (iso.is_ins_id=i.ins_id) inner join software s on (iso.is_sof_id=s.sof_id) WHERE ins_id = $id"; // Ajusta los campos según tu base de datos
                                            $stmt = $conn->query($query);
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['ins_descripcion']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['sof_nombre']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['is_version']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['is_estado']) . "</td>";
                                                echo "</tr>";

                                                /*$id_contrato = $row['cont_id']; 
                                                $fecha_inicio = $row['fecha_inicio'];
                                                $fecha_fin = $row['fecha_fin'];
                                                $descripcion = $row['descripcion'];*/
                                            }
                                            ?> 
                                        </tbody>
                                    </table>


                                </div>
                                
                                <div class="tab-pane fade" id="trazabilidad" role="tabpanel" aria-labelledby="trazabilidad-tab">
                                    <p>Datos de trazabilidad.</p>

                                    





                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
