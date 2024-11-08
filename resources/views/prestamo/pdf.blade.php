<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Préstamos</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            text-align: center;
            margin: 0;
            color: #333;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #1467a6;
            padding-bottom: 10px;
        }
        .header .date-time {
            text-align: right;
            font-size: 10px;
            margin-bottom: 10px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #128bc4;
            color: white;
        }
        .footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 12px;
            color: #555;
            background-color: white;
            padding: 10px 0;
            border-top: 1px solid #ccc;
        }
        img.logo {
            display: block;
            margin: 0 auto 10px auto;
            width: 150px;
        }
        @media print {
            .footer {
                position: fixed;
                bottom: 0;
                page-break-after: always;
            }
            .container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="date-time" style="text-align: right; font-size: 10px; margin-bottom: 10px; color: #555;">
        <?php
        // Configurar la zona horaria a Bolivia
        date_default_timezone_set('America/La_Paz');
        ?>
        Fecha de impresión: <?php echo date('d/m/Y H:i:s'); ?>
    </div>
    <div class="container">
        <div class="header">
            <img src="{{ public_path() . '/images/logo.JPG' }}" alt="Logo Préstamos El Amanecer" class="logo"> <!-- Cambia la ruta del logo -->
            <h1>Reporte de Préstamos</h1>
            <h2>Estado seleccionado: 
                @if($estado)
                    {{ ucfirst($estado) }}
                @else
                    Todos los estados
                @endif
            </h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Numero de Identificación</th>
                    <th>Cliente</th>
                    <th>Prenda</th>
                    <th>Monto</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamos as $prestamo)
                    <tr>
                        <td>{{ $prestamo->cliente->numero_identificacion }}</td>
                        <td>{{ $prestamo->cliente->nombre }}</td>
                        <td>{{ $prestamo->prenda->descripcion }}</td>
                        <td>{{ $prestamo->monto }} Bs</td>
                        <td>{{ $prestamo->fecha_inicio }}</td>
                        <td>{{ $prestamo->fecha_fin }}</td>
                        <td>{{ ucfirst($prestamo->estado) }}</td>
                    </tr>
                    @if($loop->iteration % 20 == 0)
                        </tbody>
                    </table>
                    <div style="page-break-after: always;"></div>
                    <table>
                        <thead>
                            <tr>
                                <th>Numero de Identificación</th>
                                <th>Cliente</th>
                                <th>Prenda</th>
                                <th>Monto</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Préstamos El Amanecer - Cochabamba, Bolivia</p>
    </div>
</body>
</html>
