<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include '../inc/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

   //echo "Usuario1: " . $usuario . "<br>";

    $md5pass = md5($password);

    $stmt = $conn->prepare("SELECT id_cliente, cli_nombre, cli_username, cli_password FROM clientes WHERE cli_username = :usuario and cli_password = :password");   
    $stmt->execute(['usuario' => $usuario, 'password' => $md5pass]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //print_r($user);
    //echo "2";
    // Verificar si el usuario existe
    if (!$user) {
        session_start();
    $_SESSION['mensaje'] = "Error datos incorrectos";
    header('Location: login.php');
        
    }    
    
    else{
            //echo "✅ Usuario encontrado: " . $user['usu_username'] . "<br>";
            //echo "4";
            // Comparar la contraseña usando la versión encriptada
            if ($md5pass === $user['cli_password']) {
                $_SESSION['usuario'] = $user['cli_username'];
                $_SESSION['nombre'] = $user['cli_nombre'];
                header("Location: ../menus.php"); // Redirige inmediatamente
                exit();
            } else {
               //echo "5";
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Contraseña incorrecta."
                    })
                </script>';
            }
        }
    }

?>
</body>
</html>