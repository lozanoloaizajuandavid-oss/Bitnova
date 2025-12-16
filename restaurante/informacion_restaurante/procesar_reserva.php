<?php
// Incluir la conexión a la base de datos
include 'inc/conexion.php';

// Iniciar sesión
session_start();

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y sanitizar los datos del formulario
    $numero_documento = trim($_POST['numero_documento']);
    $nombre = trim($_POST['nombre']);
    $fecha = trim($_POST['fecha']);
    $hora = trim($_POST['hora']);
    $numero_personas = trim($_POST['numero_personas']);
    $numero_mesa = trim($_POST['numero_mesa']);

    // Validar que los campos no estén vacíos
    if (empty($numero_documento) || empty($nombre) || empty($fecha) || empty($hora) || empty($numero_personas) || empty($numero_mesa)) {
        die("Error: Todos los campos son obligatorios.");
    }

    try {
        // Primero verificamos el estado de la mesa
        $sql = "SELECT ESTADO_MESA FROM mesas WHERE NUMERO_MESA = :numero_mesa";
        $stmt_mesa = $conn->prepare($sql);
        $stmt_mesa->bindParam(':numero_mesa', $numero_mesa);
        $stmt_mesa->execute();
        
        $mesa = $stmt_mesa->fetch(PDO::FETCH_ASSOC);
        
        if ($mesa) {
            $estado_mesa = $mesa['ESTADO_MESA'];
            
            // Verificar si la mesa está disponible
            if ($estado_mesa == 'OCUPADA' || $estado_mesa == 'MANTENIMIENTO') {
                // Mostrar SweetAlert de error
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: '¡Mesa no disponible!',
                                text: 'La mesa está " . $estado_mesa . ". Por favor selecciona otra mesa.',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.history.back();
                            });
                        });
                      </script>";
                exit();
            } else {
                // Si la mesa está disponible, proceder con la reserva
                $sql = "INSERT INTO reservas (numero_documento, nombre, fecha, hora, numero_personas, numero_mesa) 
                        VALUES (:numero_documento, :nombre, :fecha, :hora, :numero_personas, :numero_mesa)";

                $stmt = $conn->prepare($sql);

                // Vincular parámetros
                $stmt->bindParam(':numero_documento', $numero_documento);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':hora', $hora);
                $stmt->bindParam(':numero_personas', $numero_personas);
                $stmt->bindParam(':numero_mesa', $numero_mesa);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Actualizar el estado de la mesa a OCUPADA
                    $sql_update = "UPDATE mesas SET ESTADO_MESA = 'OCUPADA' WHERE NUMERO_MESA = :numero_mesa";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bindParam(':numero_mesa', $numero_mesa);
                    $stmt_update->execute();

                    // Mostrar mensaje de éxito
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: '¡Reserva exitosa!',
                                    text: 'Tu mesa ha sido reservada correctamente.',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    window.history.back();
                                });
                            });
                          </script>";
                    exit();
                }
            }
        } else {
            // SweetAlert para cuando la mesa no existe
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: '¡Error!',
                            text: 'La mesa seleccionada no existe.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.history.back();
                        });
                    });
                  </script>";
            exit();
        }
        
    } catch (PDOException $e) {
        // SweetAlert para errores de base de datos
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '¡Error!',
                        text: 'Error al registrar la reserva: " . addslashes($e->getMessage()) . "',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.history.back();
                    });
                });
              </script>";
        exit();
    }
} else {
    die("Acceso denegado.");
}
?>