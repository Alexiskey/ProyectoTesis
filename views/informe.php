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
                    $conexion = mysqli_connect("localhost", "root", "", "ingresos_rfid");
                    if (!$conexion) {
                        die("Error de conexión: " . mysqli_connect_error());
                    }
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

                // Contador de áreas
                var areaCounts = {};
                filteredData.forEach(function (row) {
                    var area = row[6];
                    if (areaCounts[area]) {
                        areaCounts[area]++;
                    } else {
                        areaCounts[area] = 1;
                    }
                });

                // Generar PDF
                const { jsPDF } = window.jspdf;
                var doc = new jsPDF();
                var leftsize = 20;
                var width = 180;

                // Agregar título
                doc.setFontSize(16);
                doc.text("Informe de Ingresos", leftsize, 20);

                // Texto de introducción
                var firstRow = filteredData[0] || [];
                var firstName = firstRow[1] || 'Nombre';
                var lastName = firstRow[2] || 'Apellido1';
                var lastName2 = firstRow[3] || 'Apellido2';
                var introText = `Este es el registro de asistencia de ${firstName} ${lastName} ${lastName2}. El informe presenta un resumen de los ingresos registrados, detallando la información de los usuarios, su rol, y el área de acceso.`;
                var splitText = doc.splitTextToSize(introText, width);
                doc.setFontSize(12);
                doc.text(splitText, leftsize, 30);

                // Agregar tabla al PDF
                var tableData = filteredData.map(function (row) {
                    return [row[0], row[1], row[2], row[3], row[4], row[5], row[6], row[7]];
                });

                doc.autoTable({
                    startY: 50,
                    head: [['ID Usuario', 'Nombre', 'Apellido1', 'Apellido2', 'Rut', 'Rol', 'Área', 'Fecha de Ingreso']],
                    body: tableData,
                });

                // Agregar texto de conclusión
                var finalY = doc.lastAutoTable.finalY || 50;
                var conclusionText = "Conclusión: Los datos muestran un patrón constante de acceso, lo cual es positivo para la seguridad.";
                var conclusionSplitText = doc.splitTextToSize(conclusionText, width);
                doc.text(conclusionSplitText, leftsize, finalY + 10);

                // Contador de áreas
                var areaCountText = "Contador de áreas filtradas:\n";
                for (var area in areaCounts) {
                    areaCountText += area + ": " + areaCounts[area] + "\n";
                }
                var splitAreaCountText = doc.splitTextToSize(areaCountText, width);
                doc.text(splitAreaCountText, leftsize, finalY + 30);

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
