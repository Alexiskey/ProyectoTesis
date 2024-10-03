<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Lista de Ingresos</title>
    <style>
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container button {
            margin: 0 10px;
        }

        .filters-container {
            margin-bottom: 20px;
        }

        .filters-container input,
        .filters-container select {
            margin-right: 10px;
        }

        #dateFilters {
            display: none;
            margin-top: 10px;
        }

        #botonFiltro {
            margin-top: 10px;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container is-fluid">
        <br>
        <div class="nav-buttons">
            <button onclick="window.location.href='adminUser.php'" class="btn btn-success">Usuarios</button>
            <button onclick="window.location.href='adminAreas.php'" class="btn btn-success">Administrar Areas</button>
        </div>

        <div class="col-xs-12">
            <h1>Lista de Ingresos</h1>

            <div class="filters-container">
                <select id="areaFilter">
                    <option value="">Seleccione un área</option>
                    <?php
                    require_once("../includes/_db.php"); 
                    global $conexion; 
                    $areaSQL = "SELECT nombreArea FROM areas";
                    $areasResult = mysqli_query($conexion, $areaSQL);

                    if ($areasResult->num_rows > 0) {
                        while ($areaRow = mysqli_fetch_assoc($areasResult)) {
                            echo '<option value="' . $areaRow['nombreArea'] . '">' . $areaRow['nombreArea'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <select id="roleFilter">
                    <option value="">Seleccione un rol</option>
                    <?php
                    $roleSQL = "SELECT nombreRol FROM roles";
                    $rolesResult = mysqli_query($conexion, $roleSQL);

                    if ($rolesResult->num_rows > 0) {
                        while ($roleRow = mysqli_fetch_assoc($rolesResult)) {
                            echo '<option value="' . $roleRow['nombreRol'] . '">' . $roleRow['nombreRol'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <div id="dateFilters">
                    <label for="startDate">Desde:</label>
                    <input type="date" id="startDate">
                    <input type="time" id="startTime">

                    <label for="endDate">Hasta:</label>
                    <input type="date" id="endDate">
                    <input type="time" id="endTime">
                </div>

                <div id="singleDayFilters">
                    <label for="singleDate">Fecha:</label>
                    <input type="date" id="singleDate">
                    <input type="time" id="singleTime">
                </div>

                <label>
                    <input type="checkbox" id="enableDateFilter">
                    Filtro por Rango de Fechas
                </label>

                <div id="botonFiltro">
                    <button id="filterButton" class="btn btn-primary">Filtrar</button>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-striped table-dark" id="table_id">
                    <thead>
                        <tr>
                            <th>idUsuario</th>
                            <th>Nombre</th>
                            <th>Apellido1</th>
                            <th>Apellido2</th>
                            <th>Rut</th>
                            <th>Rol</th>
                            <th>Area</th>
                            <th>Fecha de Ingreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $SQL = "SELECT usuario.idUsuario, usuario.NombreUsuario, usuario.Apellido1Usuario, usuario.Apellido2Usuario, usuario.rut, 
                        roles.nombreRol, accesos_logs.horaAcceso, areas.nombreArea,
                        DATE_FORMAT(accesos_logs.horaAcceso, '%Y-%m-%d %H:%i') as horaAcceso
                        FROM usuario
                        LEFT JOIN roles ON usuario.idRol = roles.idRol
                        LEFT JOIN accesos_logs ON usuario.idUsuario = accesos_logs.idUsuario
                        LEFT JOIN areas ON accesos_logs.idArea = areas.idAreas
                        WHERE areas.nombreArea IS NOT NULL AND areas.nombreArea != ''";

                        $dato = mysqli_query($conexion, $SQL);

                        if ($dato->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($dato)) {
                        ?>
                                <tr>
                                    <td><?php echo $fila['idUsuario']; ?></td>
                                    <td><?php echo $fila['NombreUsuario']; ?></td>
                                    <td><?php echo $fila['Apellido1Usuario']; ?></td>
                                    <td><?php echo $fila['Apellido2Usuario']; ?></td>
                                    <td><?php echo $fila['rut']; ?></td>
                                    <td><?php echo $fila['nombreRol']; ?></td>
                                    <td><?php echo $fila['nombreArea']; ?></td>
                                    <td><?php echo $fila['horaAcceso']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr class="text-center">
                                <td colspan="8">No existen registros</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

        <script>
            $(document).ready(function () {
                var table = $('#table_id').DataTable({
                    "language": {
                        "search": "Buscar en toda la tabla:",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "lengthMenu": "Mostrar _MENU_ entradas"
                    },
                    "order": [[7, 'desc']],
                    "columnDefs": [
                        {
                            "targets": 7,
                            "render": function (data, type, row) {
                                if (type === 'sort' || type === 'type') {
                                    var dateParts = data.split(' ');
                                    var dateArray = dateParts[0].split('-');
                                    var timeArray = dateParts[1].split(':');
                                    var formattedDate = new Date(
                                        dateArray[0], // Año
                                        dateArray[1] - 1, // Mes (0-11)
                                        dateArray[2], // Día
                                        timeArray[0], // Hora
                                        timeArray[1] // Minutos
                                    ).getTime();
                                    return formattedDate;
                                }
                                return data;
                            }
                        }
                    ]
                });

                // Mostrar/ocultar filtros de fecha al hacer clic en la casilla
                $('#enableDateFilter').change(function () {
                    if ($(this).is(':checked')) {
                        $('#dateFilters').show();
                        $('#singleDayFilters').hide();
                    } else {
                        $('#dateFilters').hide();
                        $('#singleDayFilters').show();
                    }
                });

                // Filtro de búsqueda al hacer clic en el botón de filtro
                $('#filterButton').on('click', function () {
                    table.draw();
                });

                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    var minDate = $('#startDate').val();
                    var maxDate = $('#endDate').val();
                    var minTime = $('#startTime').val();
                    var maxTime = $('#endTime').val();
                    var dateTime = data[7] || ''; // Índice de la columna de fecha

                    var singleDate = $('#singleDate').val();
                    var singleTime = $('#singleTime').val();
                    var singleDateTime = singleDate ? new Date(singleDate + 'T' + (singleTime || '00:00')).getTime() : null;

                    var date = dateTime ? new Date(dateTime).getTime() : null;

                    // Obtener los valores de los filtros de área y rol
                    var areaFilter = $('#areaFilter').val();
                    var roleFilter = $('#roleFilter').val();
                    var area = data[6]; // Índice de la columna de área
                    var rol = data[5]; // Índice de la columna de rol

                    // Comprobación de filtros de área
                    var areaMatch = areaFilter ? area === areaFilter : true;
                    // Comprobación de filtros de rol
                    var roleMatch = roleFilter ? rol === roleFilter : true;

                    if ($('#enableDateFilter').is(':checked')) {
                        // Filtro por rango de fechas
                        var minDateTime = minDate ? new Date(minDate + 'T' + (minTime || '00:00')).getTime() : null;
                        var maxDateTime = maxDate ? new Date(maxDate + 'T' + (maxTime || '23:59')).getTime() : null;

                        if (date >= minDateTime && date <= maxDateTime && areaMatch && roleMatch) {
                            return true;
                        }
                        return false;
                    } else {
                        // Filtro por fecha única
                        if (singleDateTime) {
                            if (date >= singleDateTime && date < singleDateTime + 24 * 60 * 60 * 1000 && areaMatch && roleMatch) {
                                return true;
                            }
                            return false;
                        }
                        return areaMatch && roleMatch; // Si no hay filtros de fecha, solo chequea área y rol
                    }
                });

// Generar PDF
$('#exportPDF').click(function () {
    var filteredData = table.rows({ search: 'applied' }).data().toArray();

    // Contador de usuarios por área y día
    var userAreaDayCounts = {};
    filteredData.forEach(function (row) {
        var userId = row[0]; // ID del usuario
        var name = row[1]; // Nombre
        var lastName1 = row[2]; // Primer apellido
        var lastName2 = row[3]; // Segundo apellido
        var area = row[6]; // Área
        var dateTime = row[7]; // Fecha y hora

        // Extraer solo la fecha (sin la hora)
        var date = dateTime.split(' ')[0];
        // Extraer la hora
        var time = dateTime.split(' ')[1];

        if (!userAreaDayCounts[date]) {
            userAreaDayCounts[date] = {};
        }

        if (!userAreaDayCounts[date][userId]) {
            userAreaDayCounts[date][userId] = {
                id: userId,
                name: name,
                lastName1: lastName1,
                lastName2: lastName2,
                areaCount: {},
                entryTimes: [], // Almacenar las horas de entrada
                exitTimes: []   // Almacenar las horas de salida
            };
        }

        if (!userAreaDayCounts[date][userId].areaCount[area]) {
            userAreaDayCounts[date][userId].areaCount[area] = { count: 0, time: [] };
        }

        // Incrementar el contador de ingresos por área en esa fecha
        userAreaDayCounts[date][userId].areaCount[area].count++;
        userAreaDayCounts[date][userId].areaCount[area].time.push(time); // Agregar la hora

        // Almacenar la hora de entrada y salida
        if (!userAreaDayCounts[date][userId].entryTimes.includes(time)) {
            userAreaDayCounts[date][userId].entryTimes.push(time); // Guardar hora de entrada
        }
        userAreaDayCounts[date][userId].exitTimes.push(time); // Guardar hora de salida
    });

    // Generar PDF
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF();
    var leftsize = 20;
    var width = 170;
    var marginY = 10; // Margen vertical adicional para evitar superposición

    // Agregar título
    doc.setFontSize(16);
    doc.text("Informe de Ingresos", leftsize, 10);

    // Texto de introducción
    var userNames = [];
    filteredData.forEach(function (row) {
        var name = row[1]; // Nombre
        var lastName1 = row[2]; // Primer apellido
        var lastName2 = row[3]; // Segundo apellido
        userNames.push(`${name} ${lastName1} ${lastName2}`);
    });

    // Crear una lista única de nombres
    var uniqueNames = [...new Set(userNames)];
    var namesList = uniqueNames.join(', ');

    // Construir el texto de introducción
    doc.setFontSize(12);
    var introText = `Este es el registro de asistencia de los siguientes usuarios: ${namesList}. El informe presenta un resumen de los ingresos registrados, detallando la información de los usuarios, su rol, y el área de acceso.`;
    var splitText = doc.splitTextToSize(introText, width);
    
    doc.text(splitText, leftsize, 30);

    // Agregar primera tabla al PDF con los datos de ingresos sin agrupar
    var tableData = [];

    // Construir el array de tableData con entradas y salidas
    for (const [date, users] of Object.entries(userAreaDayCounts)) {
        for (const userId in users) {
            const user = users[userId];
            const exitTime = user.entryTimes[0] || ''; // La primera hora de entrada
            const entryTime = user.exitTimes.slice(-1)[0] || ''; // La última hora registrada

            // Obtener el área de acceso (puedes modificarlo si necesitas un formato diferente)
            const area = Object.keys(user.areaCount).join(', ');

            // Agregar los datos al array
            tableData.push([userId, user.name, user.lastName1, user.lastName2, '', '', area, date, entryTime, exitTime]);
        }
    }

    // Ordenar tableData por fecha
    tableData.sort(function (a, b) {
        var dateA = new Date(a[7]); // Convertir a objeto Date
        var dateB = new Date(b[7]); // Convertir a objeto Date
        return dateA - dateB; // Ordenar de menor a mayor
    });

    // Agregar tabla al PDF
    doc.autoTable({
        startY: 50,
        head: [['ID Usuario', 'Nombre', 'Apellido1', 'Apellido2', 'Rut', 'Rol', 'Área', 'Fecha de Ingreso', 'Hora de Entrada', 'Hora de Salida']],
        body: tableData,
    });
                doc.addPage();
                var finalY = 10;
                doc.setFontSize(16);
                finalY += marginY;
                doc.text("Detalle", leftsize, finalY);

                doc.setFontSize(12);
                finalY += marginY;

                var Text = `A continuación, podrá ver el detalle diario de los ingresos realizados durante la semana, organizados por usuario.`;
                var splitText = doc.splitTextToSize(Text, width);
                doc.text(splitText, leftsize, 30);



                var resumenTableData = []; // Para almacenar datos de resumen
                var sortedDates = Object.keys(userAreaDayCounts).sort(function(a, b) {
                    return new Date(a) - new Date(b); // Ordenar de menor a mayor
                });

                // Iterar sobre las fechas ya ordenadas
                for (var i = 0; i < sortedDates.length; i++) {
                    var date = sortedDates[i];
                    doc.setFontSize(12);
                    finalY += marginY; // Añadir un margen vertical antes de cada título

                    // Crear cuerpo de la tabla por día
                    var areaDayTableData = [];
                    var allHours = []; // Arreglo para almacenar todas las horas de un día específico

                    for (var userId in userAreaDayCounts[date]) {
                        var user = userAreaDayCounts[date][userId];
                        for (var area in user.areaCount) {
                            var areaData = user.areaCount[area];
                            areaData.time.forEach(time => {
                                areaDayTableData.push([
                                    user.id, user.name, user.lastName1, user.lastName2, area, `${date} ${time}`, areaData.count, time // Agregar fecha y hora
                                ]);
                                
                                // Almacenar las horas trabajadas para este usuario en el día
                                allHours.push(time);
                            });
                        }
                    }

                    // Ordenar areaDayTableData por fecha y hora
                    areaDayTableData.sort(function (a, b) {
                        var dateTimeA = new Date(a[5]); // Convertir a objeto Date
                        var dateTimeB = new Date(b[5]); // Convertir a objeto Date
                        return dateTimeA - dateTimeB; // Ordenar de menor a mayor
                    });

                    doc.setFontSize(14);
                    finalY += marginY;                
                    doc.text("Tabla detalle de dia " + `${date}`+".", leftsize, finalY);

                    // Agregar la tabla para ese día
                    doc.autoTable({
                        startY: finalY + marginY, // Añadir margen vertical antes de la tabla
                        head: [['ID Usuario', 'Nombre', 'Apellido1', 'Apellido2', 'Área', 'Fecha de Ingreso', 'Cantidad de Ingresos', 'Horas']],
                        body: areaDayTableData,
                    });

                    // Actualizar finalY para después de la tabla
                    finalY = doc.lastAutoTable.finalY || finalY + marginY;

                    // Calcular total de horas trabajadas para el día
                    if (allHours.length > 0) {
                        var firstHour = new Date(`1970-01-01T${allHours[0]}:00`);
                        var lastHour = new Date(`1970-01-01T${allHours[allHours.length - 1]}:00`);
                        
                        // Corregir la diferencia: restar firstHour de lastHour
                        var totalTrabajadas = (firstHour - lastHour) / (1000 * 60 * 60); // Diferencia en horas
                        var totalTrabajadasEnMinutos = (firstHour - lastHour) / (1000 * 60); // Diferencia en minutos
                        var totalhoras = totalTrabajadasEnMinutos / 60;
                        var totalminutos = (totalhoras - parseFloat(totalhoras.toFixed(0)))*60; 
                        totalhoras = parseFloat(totalhoras.toFixed(0)) - 1;
                        totalminutos = parseFloat(totalminutos.toFixed(0));
                    
                    } else {
                        var totalTrabajadas = 0;
                    }
                    if(totalminutos<0){
                        totalhoras = totalhoras - 1;
                        totalminutos = 60 + totalminutos;
                    }
                    var horasLaborales = 9; // Asumiendo que 9 es el total de horas laborales
                    var totalformatohoras = `${totalhoras}:${totalminutos}`;
                    totalTrabajadas = parseFloat(totalTrabajadas.toFixed(2)) - 1; // Acorta a 2 decimales
                    var totalfinal = totalTrabajadas - horasLaborales; 
                    totalfinal = parseFloat(totalfinal.toFixed(2));

                    // Agregar datos a resumenTableData
                    resumenTableData.push([date, horasLaborales, totalTrabajadas, totalfinal , totalformatohoras]);

                }
                // Ordenar areaDayTableData por fecha y hora
                resumenTableData.sort(function (a, b) {
                    var dateTimeA = new Date(a[0]); // Convertir a objeto Date
                    var dateTimeB = new Date(b[0]); // Convertir a objeto Date
                    return dateTimeA - dateTimeB; // Ordenar de menor a mayor
                });
                
                doc.addPage();
                // Crear y agregar la tabla final
                finalY = 10;
                finalY += marginY; // Añadir margen antes de la nueva tabla
                doc.setFontSize(16);
                doc.text("Resumen de Horas Laborales", leftsize, finalY);
                
                doc.autoTable({
                    startY: finalY + marginY,
                    head: [['Fecha', 'Horas Laborales', 'Horas Trabajadas', 'Total', 'Total Horas']],
                    body: resumenTableData,
                });

                // Asegurarse de que haya un margen después de la tabla antes de la conclusión
                finalY = doc.lastAutoTable.finalY || finalY + marginY; 
                finalY += marginY; // Añadir margen antes del texto de conclusión

                // Agregar texto de conclusión
                var conclusionText = "Conclusión: Los datos muestran un patrón constante de acceso, dividido por áreas y fechas, lo cual es positivo para la seguridad.";
                var conclusionSplitText = doc.splitTextToSize(conclusionText, width);
                doc.text(conclusionSplitText, leftsize, finalY);

                // Guardar PDF
                doc.save('informe_ingresos.pdf');
            });

        });        
    </script>
</body>


<div class="button-container">
    <button id="exportPDF" class="btn btn-danger">Exportar a PDF</button>
</div>
</body>

</html>
