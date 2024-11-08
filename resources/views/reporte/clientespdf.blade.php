<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes</title>
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
            position: relative;
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
            color: #555;
            position: absolute;
            top: 0;
            right: 20px;
            margin-top: 10px;
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
        @media print {
            .header {
                position: fixed;
                top: 0;
                width: 100%;
                background-color: white;
                padding-bottom: 10px;
                z-index: 9999;
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                page-break-after: always;
                z-index: 9999;
            }
            .container {
                page-break-inside: avoid;
                margin-top: 60px;
                margin-bottom: 60px;
            }
            .date-time {
                margin-right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path() . '/images/logo.JPG' }}" alt="Logo Préstamos El Amanecer" class="logo" style="display: block; margin: 0 auto; width: 150px;">
        <h1>Reporte de Clientes</h1>
        <div class="date-time" style="text-align: right; font-size: 10px; margin-bottom: 10px; color: #555;">
            <?php
            // Configurar la zona horaria a Bolivia
            date_default_timezone_set('America/La_Paz');
            ?>
            Fecha de impresión: <?php echo date('d/m/Y H:i:s'); ?>
        </div>
    </div>
    
    <div class="container">
        <h3>Clientes Registrados</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Correo Electrónico</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>Tipo de Identificación</th>
                    <th>No. Identificación</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }} {{ $cliente->papellido }} {{ $cliente->sapellido }}</td>
                    <td>{{ $cliente->correo_electronico }}</td>
                    <td>{{ $cliente->fecha_nacimiento }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->tipo_documento->caracteristica->nombre }}</td>
                    <td>{{ $cliente->numero_identificacion }}</td>
                    <td>{{ $cliente->created_at }}</td>
                </tr>
                @if($loop->iteration % 20 == 0)
                    </tbody>
                </table>
                <div style="page-break-after: always;"></div>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Tipo de Identificación</th>
                            <th>No. Identificación</th>
                            <th>Fecha de Registro</th>
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
        <p>Contacto: info@prestamoselamanecer.com | Teléfono: +591 123 456 789</p>
    </div>
</body>
</html>
