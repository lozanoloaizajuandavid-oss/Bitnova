<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina_blog</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Emblema+One&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../pagina_cafe/CSS/style.css">
</head>
<body>
<!--encabezado de pagina -->
<header class="header">
    <div class="color_header" style="background-color: #23310180; width: 100%; height: 100%;">
        <nav class="contenedor">
            <div class="barra" style="padding-top: 4rem;">
                <a href="index.html" class="logo">
                    <h1 class="logo__nombre">
                        Reservas Y <br>
                        <span class="logo__bold">Menús</span>
                    </h1>
                </a>

                <nav class="navegacion">
                    <a href="Contactenos.php" class="navegacion__enlace">Contáctenos</a>
                </nav>
            </div>
        </nav>

        <div class="header__texto">
            <h2 class="no-margin">Mundial del Sazón</h2>
            <p class="no-margin frase">¿Antojo de algo delicioso? Ven a nuestro restaurante y prueba nuestros platos exclusivos. ¡La comida que te mereces está aquí!</p>
        </div>
    </div>
</header>
<!-- termina encabezado de pagina -->

<!--contenido principal de la pagina-->
<main class="contenedor">
    <h2 class="centrar-texto">Contáctenos</h2>

    <div class="contacto_info" style="display: grid; grid-template-columns: 1fr; column-gap: 2rem;">

        <div class="contacto__texto">
            <p><strong>Dirección:</strong> Calle 123 # 45-67, Bogotá, Colombia</p>
            <p><strong>Teléfonos:</strong> +57 300 123 4567 / +57 320 765 4321</p>
            <p><strong>Correo Electrónico:</strong> contacto@mundialdelsazon.com</p>
            <p><strong>Horario de Atención:</strong></p>
            <ul>
                <li>Lunes a Viernes: 12:00 PM - 10:00 PM</li>
                <li>Sábados y Domingos: 1:00 PM - 11:00 PM</li>
            </ul>
            <p>¡Te esperamos para disfrutar de lo mejor de nuestra cocina!</p>
        </div>

    </div>
</main>
<!--fin de contenido principal-->

<footer class="footer">
    <div class="contenedor">
        <div class="barra" style="padding-top: 4rem;">
            <a href="index.html" class="logo">
                <h1 class="logo__nombre">
                    Reservas y
                    <span class="logo__bold">Menus</span>
                </h1>
            </a>

            <nav class="navegacion">
                <a href="Contactenos.php" class="navegacion__enlace">Contáctenos</a>
            </nav>
        </div>
    </div>
</footer>

</body>
</html>
