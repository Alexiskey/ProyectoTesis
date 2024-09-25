<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura UID</title>
    <script>
        let intervalo; // Variable para almacenar el intervalo

        function actualizarLectura() {
            // Crear una solicitud AJAX al archivo lecturaTxt.php
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../includes/lecturaTxt.php", true); // Llama al archivo lecturaTxt.php
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar el contenido del label con la respuesta del servidor
                    document.getElementById("labelTexto").innerText = xhr.responseText;
                }
            };
            xhr.send();
        }

        function toggleLectura() {
            const boton = document.getElementById("botonLectura");
            if (boton.innerText === "Iniciar Lectura") {
                boton.innerText = "Detener Lectura";
                intervalo = setInterval(actualizarLectura, 2000); // Inicia la lectura cada 2 segundos
            } else {
                boton.innerText = "Iniciar Lectura";
                clearInterval(intervalo); // Detiene la lectura
                // Enviar una solicitud POST para actualizar el contenido de lectura.txt
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../includes/lecturaTxt.php", true); // Llama al archivo lecturaTxt.php
                xhr.send();
            }
        }
    </script>
</head>
<body>
    <h1>Lectura UID</h1>
    <button id="botonLectura" onclick="toggleLectura()">Iniciar Lectura</button>
    <label id="labelTexto" style="display: block; margin-top: 20px; font-size: 18px;">Esperando tarjeta...</label>
</body>
</html>
