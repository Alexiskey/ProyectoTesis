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

    // Definir las coordenadas específicas para cada área
    $coordenadas = [
        "Sala_Herramientas" => [round($ancho * 0.125), round($alto * 0.25)],
        "Sala_Reuniones"   => [round($ancho * 0.375), round($alto * 0.25)],
        "Comedor"          => [round($ancho * 0.625), round($alto * 0.25)],
        "Reuniones 2"      => [round($ancho * 0.875), round($alto * 0.25)],
        "Estacionamiento"  => [round($ancho * 0.125), round($alto * 0.75)],
        "Sala_Operaciones" => [round($ancho * 0.375), round($alto * 0.75)],
        "Oficina A"        => [round($ancho * 0.625), round($alto * 0.75)],
        "Oficina B"        => [round($ancho * 0.875), round($alto * 0.75)]
    ];

    // Obtener datos del POST
    $areaCounts = isset($_POST) ? $_POST : [];

    // Inicializar el array de conteos con 0 para todas las áreas
    $conteosAreas = array_fill_keys(array_keys($coordenadas), 0);

    // Actualizar los conteos con los datos recibidos
    foreach ($areaCounts as $area => $count) {
        if (array_key_exists($area, $conteosAreas)) {
            $conteosAreas[$area] = intval($count);
        }
    }

    // Función para generar un color entre verde y naranja basado en un índice
    function generarColor($imagen, $indice, $max_indice, $transparencia) {
        $proporcion = $indice / $max_indice;
        $rojo = intval(255 * $proporcion);
        $verde = intval(255 * (1 - $proporcion));
        return imagecolorallocatealpha($imagen, $rojo, $verde, 0, $transparencia);
    }

    // Dibujar puntos en los cuadrantes según el conteo de áreas
    foreach ($conteosAreas as $area => $count) {
        if (isset($coordenadas[$area])) {
            $x = $coordenadas[$area][0];
            $y = $coordenadas[$area][1];

            // Usar el conteo para generar el color
            $transparencia = 50; // Puedes ajustar el nivel de transparencia aquí
            $color_punto = generarColor($imagen_fondo, $count, max($conteosAreas), $transparencia);

            // Dibujar un círculo lleno en lugar de un punto pequeño
            imagefilledellipse($imagen_fondo, $x, $y, 100, 100, $color_punto);

            // Especificar el tamaño del texto para el índice
            $tamano_fuente = 5; // Tamaño de la fuente con `imagestring()`, 5 es el máximo por defecto
            $indice_x = $x - 10; // Ajustar posición x del índice
            $indice_y = $y - 10; // Ajustar posición y del índice

            // Dibujar el número del índice junto al punto
            imagestring($imagen_fondo, $tamano_fuente, $indice_x, $indice_y, $count, imagecolorallocate($imagen_fondo, 0, 0, 0));

            // Agregar el nombre del punto a la imagen
            $textColor = imagecolorallocate($imagen_fondo, 0, 0, 0);  // Color del texto (negro)
            imagestring($imagen_fondo, 3, $x - 20, $y + 10, $area, $textColor);
        }
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
