<?php
function generarGrafica() {
    $ancho = 850; // Ancho de la imagen base
    $alto = 824;  // Alto de la imagen base

    // Crear una imagen en blanco
    $imagen_fondo = imagecreatetruecolor($ancho, $alto);

    // Asignar color blanco al fondo
    $color_blanco = imagecolorallocate($imagen_fondo, 255, 255, 255);
    imagefilledrectangle($imagen_fondo, 0, 0, $ancho, $alto, $color_blanco);

    // Cargar la imagen con transparencia
    $imagen_transparente = imagecreatefrompng('../imagenes/oficina.png');

    // Asegurarse de que la imagen transparente tenga un canal alfa
    imagealphablending($imagen_transparente, false);
    imagesavealpha($imagen_transparente, true);

    // Copiar la imagen con transparencia sobre el fondo blanco
    imagecopy($imagen_fondo, $imagen_transparente, 0, 0, 0, 0, $ancho, $alto);

    $puntos = [
        [round($ancho * 0.125), round($alto * 0.25)],  // Cuadrante 1 (fila 1, columna 1)
        [round($ancho * 0.375), round($alto * 0.25)],  // Cuadrante 2 (fila 1, columna 2)
        [round($ancho * 0.625), round($alto * 0.25)],  // Cuadrante 3 (fila 1, columna 3)
        [round($ancho * 0.875), round($alto * 0.25)],  // Cuadrante 4 (fila 1, columna 4)
        [round($ancho * 0.125), round($alto * 0.75)],  // Cuadrante 5 (fila 2, columna 1)
        [round($ancho * 0.375), round($alto * 0.75)],  // Cuadrante 6 (fila 2, columna 2)
        [round($ancho * 0.625), round($alto * 0.75)],  // Cuadrante 7 (fila 2, columna 3)
        [round($ancho * 0.875), round($alto * 0.75)]   // Cuadrante 8 (fila 2, columna 4)
    ];

    // Nombres de los puntos
    $nombresPuntos = [
        "Sala_Herramientas",
        "Sala_Reuniones",
        "Comedor",
        "Reuniones 2",
        "Oficina A",
        "Oficina B",
        "Oficina C",
        "Oficina D"
    ];

    // Función para generar un color entre verde y naranja basado en un índice
    function generarColor($imagen, $indice, $max_indice, $transparencia) {
        $proporcion = $indice / $max_indice;
        $rojo = intval(255 * $proporcion);
        $verde = intval(255 * (1 - $proporcion));
        return imagecolorallocatealpha($imagen, $rojo, $verde, 0, $transparencia);
    }

    // Dibujar puntos en los cuadrantes
    for ($i = 0; $i < count($puntos); $i++) {
        $x = $puntos[$i][0];
        $y = $puntos[$i][1];

        // Generar un índice aleatorio entre 1 y 15
        $indice_aleatorio = rand(1, 15);
        $tamano_punto = 100;

        $transparencia = 50; // Puedes ajustar el nivel de transparencia aquí
        $color_punto = generarColor($imagen_fondo, $indice_aleatorio, 15, $transparencia);

        // Dibujar un círculo lleno en lugar de un punto pequeño
        imagefilledellipse($imagen_fondo, $x, $y, $tamano_punto, $tamano_punto, $color_punto);

        // Especificar el tamaño del texto para el índice
        $tamano_fuente = 5; // Tamaño de la fuente con `imagestring()`, 5 es el máximo por defecto
        $indice_x = $x - 10; // Ajustar posición x del índice
        $indice_y = $y - 10; // Ajustar posición y del índice

        // Dibujar el número del índice aleatorio junto al punto
        imagestring($imagen_fondo, $tamano_fuente, $indice_x, $indice_y, $indice_aleatorio, imagecolorallocate($imagen_fondo, 0, 0, 0));

        // Agregar el nombre del punto a la imagen
        $textColor = imagecolorallocate($imagen_fondo, 0, 0, 0);  // Color del texto (negro)
        imagestring($imagen_fondo, 3, $x - 20, $y + 10, $nombresPuntos[$i], $textColor);
    }

    // Crear el directorio si no existe
    $rutaDirectorio = '../imagenes/oficinaZone';
    if (!file_exists($rutaDirectorio)) {
        mkdir($rutaDirectorio, 0777, true);
    }

    // Guardar la imagen en la carpeta oficinaZone
    $rutaImagen = $rutaDirectorio . '/oficinazone.png';
    imagepng($imagen_fondo, $rutaImagen);

    // Liberar memoria
    imagedestroy($imagen_fondo);
    imagedestroy($imagen_transparente);

    // Responder al navegador
    echo json_encode(['status' => 'success', 'path' => $rutaImagen]);
}

// Llamar a la función para generar la gráfica
generarGrafica();
?>
