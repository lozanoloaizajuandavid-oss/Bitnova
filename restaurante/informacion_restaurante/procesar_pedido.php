<?php
// Incluir la conexión a la base de datos
include 'inc/conexion.php';

// Iniciar sesión
session_start();

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y sanitizar los datos del formulario
    $numero_documento = trim($_POST['numero_documento']);
    $tipo_documento = trim($_POST['tipo_documento']);
    $nombre_completo = trim($_POST['nombre_completo']);
    $numero_celular = trim($_POST['numero_celular']);
    $correo_electronico = trim($_POST['correo_electronico']);
    $direccion = trim($_POST['direccion']);
    $ciudad = trim($_POST['ciudad']);
    $fecha_pedido = trim($_POST['fecha_pedido']);
    $estado_pedido = trim($_POST['estado_pedido']);

    // Validar que los campos no estén vacíos
    if (empty($numero_documento) || empty($tipo_documento) || empty($nombre_completo) || empty($numero_celular) || empty($correo_electronico) || empty($direccion) || empty($ciudad) || empty($fecha_pedido) || empty($estado_pedido)) {
        die("Error: Todos los campos son obligatorios.");
    }

    try {
        // Preparar la consulta SQL con parámetros
        $sql = "INSERT INTO domicilios (numero_documento, tipo_documento, nombre_completo, numero_celular, correo_electronico, direccion, ciudad, fecha_pedido, estado_pedido) 
                VALUES (:numero_documento, :tipo_documento, :nombre_completo, :numero_celular, :correo_electronico, :direccion, :ciudad, :fecha_pedido, :estado_pedido)";

        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bindParam(':numero_documento', $numero_documento);
        $stmt->bindParam(':tipo_documento', $tipo_documento);
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':numero_celular', $numero_celular);
        $stmt->bindParam(':correo_electronico', $correo_electronico);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':fecha_pedido', $fecha_pedido);
        $stmt->bindParam(':estado_pedido', $estado_pedido);

        // Ejecutar la consulta
        $stmt->execute();

        // Asegurar que no haya contenido antes del script
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '¡Pedido registrado!',
                        text: 'El pedido se ha registrado con éxito.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.history.back(); // Volver a la página anterior
                    });
                });
              </script>";
        exit();
    } catch (PDOException $e) {
        die("Error al registrar el pedido: " . $e->getMessage());
    }
} else {
    die("Acceso denegado.");
}
